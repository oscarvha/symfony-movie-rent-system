<?php
/**
 * User: Oscar Sanchez
 * Date: 3/4/21
 */

namespace App\Service\Handler;


use App\Entity\ValueObject\Roles;
use App\Exception\UserTypeNotPermitManipulateObjectException;
use App\Repository\MovieRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Service\DTO\DTOInterface;
use App\Service\DTO\MovieDeleteDTO;

class MovieDeleteHandler implements ServiceHandlerInterface
{
    /**
     * @var MovieRepositoryInterface
     */
    private MovieRepositoryInterface $movieRepository;

    /**
     * @var UserRepositoryInterface
     */
    private UserRepositoryInterface $userRepository;

    /**
     * MovieDeleteHandler constructor.
     * @param MovieRepositoryInterface $movieRepository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(MovieRepositoryInterface $movieRepository, UserRepositoryInterface $userRepository)
    {
        $this->movieRepository = $movieRepository;
        $this->userRepository = $userRepository;
    }


    /**
     * @param DTOInterface|MovieDeleteDTO $dto
     * @return mixed|void
     */
    public function handle(DTOInterface|MovieDeleteDTO $dto)
    {
        $user = $this->userRepository->getById($dto->getUser());

        if(!$user->getRoles()->has(Roles::ADMIN)) {
            throw new UserTypeNotPermitManipulateObjectException();
        }

        $movie = $this->movieRepository->getById($dto->getId());

        $movie->deleteMedias();
        $this->movieRepository->delete($movie);

    }
}