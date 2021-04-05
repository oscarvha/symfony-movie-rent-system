<?php
/**
 * User: Oscar Sanchez
 * Date: 3/4/21
 */

namespace App\Service\Handler;


use App\Entity\ValueObject\RentStatus;
use App\Exception\RentIsAlreadyIsFinishedException;
use App\Exception\UserTypeNotPermitManipulateObjectException;
use App\Repository\RentRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Service\DTO\DTOInterface;
use App\Service\DTO\RentUserChangeStatusDTO;

class RentUserChangeStatusHandler implements ServiceHandlerInterface
{

    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

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
     * @param DTOInterface|RentUserChangeStatusDTO $dto
     * @return void
     * @throws RentIsAlreadyIsFinishedException
     * @throws UserTypeNotPermitManipulateObjectException
     */
    public function handle(DTOInterface|RentUserChangeStatusDTO $dto)
    {
        $user = $this->userRepository->getById($dto->getUser());
        $rent = $this->rentRepository->getById($dto->getRent());

        if($user->getId() != $rent->getUser()->getId()) {
            throw new UserTypeNotPermitManipulateObjectException();
        }

        if($dto->getNewStatus() == RentStatus::CANCELED) {

            $rent->cancel();
        }

        if($dto->getNewStatus() == RentStatus::RETURNED_USER) {

            $rent->return();
        }

        $this->rentRepository->save($rent);
    }
}