<?php
/**
 * User: Oscar Sanchez
 * Date: 4/4/21
 */

namespace App\Service\Handler;


use App\Entity\ValueObject\RentStatus;
use App\Entity\ValueObject\Roles;
use App\EventDispatcher\Event\RentStatusWasChange;
use App\EventDispatcher\Event\SubscriberWasSend;
use App\EventDispatcher\EventPublisher;
use App\Exception\RentIsAlreadyIsFinishedException;
use App\Exception\UserTypeNotPermitManipulateObjectException;
use App\Repository\MovieRepositoryInterface;
use App\Repository\RentRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Service\DTO\DTOInterface;
use App\Service\DTO\RentChangeStatusDTO;
use Symfony\Component\EventDispatcher\EventDispatcher;

class RentChangeStatusHandler implements ServiceHandlerInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * @var MovieRepositoryInterface
     */
    private MovieRepositoryInterface $movieRepository;

    /**
     * @var RentRepositoryInterface
     */
    private RentRepositoryInterface $rentRepository;

    /**
     * RentMovieHandler constructor.
     * @param UserRepositoryInterface $userRepository
     * @param RentRepositoryInterface $rentRepository
     */
    public function __construct(UserRepositoryInterface $userRepository,
                                RentRepositoryInterface $rentRepository)
    {
        $this->userRepository = $userRepository;
        $this->rentRepository = $rentRepository;
    }


    /**
     * @param DTOInterface|RentChangeStatusDTO $dto
     * @throws UserTypeNotPermitManipulateObjectException
     * @throws RentIsAlreadyIsFinishedException
     */
    public function handle(DTOInterface|RentChangeStatusDTO $dto)
    {
        $user = $this->userRepository->getById($dto->getUser());
        $rent = $this->rentRepository->getById($dto->getRent());

        if(!$user->getRoles()->has(Roles::ADMIN)) {
            throw new UserTypeNotPermitManipulateObjectException();
        }

        if($rent->isFinish()) {
            throw new RentIsAlreadyIsFinishedException();
        }

        $rent->changeStatus($dto->getNewStatus());
        $this->rentRepository->save($rent);

        //EventPublisher::publish(new RentStatusWasChange($dto));
    }
}