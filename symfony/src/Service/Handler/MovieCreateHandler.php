<?php
/**
 * User: Oscar Sanchez
 * Date: 2/4/21
 */

namespace App\Service\Handler;


use App\Entity\Movie;
use App\Entity\ValueObject\Roles;
use App\Exception\MovieExistWithTheSameNameException;
use App\Exception\MovieReferenceExistException;
use App\Exception\StockNotShouldBeNegativeException;
use App\Exception\UserTypeNotPermitManipulateObjectException;
use App\Repository\MovieRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Service\DTO\DTOInterface;
use App\Service\DTO\MovieCreateDTO;

class MovieCreateHandler implements ServiceHandlerInterface
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
     * MovieCreateHandler constructor.
     * @param MovieRepositoryInterface $movieRepository
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(MovieRepositoryInterface $movieRepository, UserRepositoryInterface $userRepository)
    {
        $this->movieRepository = $movieRepository;
        $this->userRepository = $userRepository;
    }


    /**
     * @param DTOInterface|MovieCreateDTO $dto
     * @throws UserTypeNotPermitManipulateObjectException
     * @throws MovieExistWithTheSameNameException
     * @throws StockNotShouldBeNegativeException
     * @throws MovieReferenceExistException
     */
    public function handle(DTOInterface|MovieCreateDTO $dto)
    {
        $user = $this->userRepository->getById($dto->getUser());

        if(!$user->getRoles()->has(Roles::ADMIN)) {
            throw new UserTypeNotPermitManipulateObjectException();
        }

        $existByTitle = $this->movieRepository->findByTitle($dto->getTitle());

        if($existByTitle) {
            throw new MovieExistWithTheSameNameException();
        }

        $existByReference = $this->movieRepository->findByReference($dto->getReference());

        if($existByReference) {
            throw new MovieReferenceExistException();
        }

        $movie = new Movie($dto->getTitle(), $dto->getReference(), $dto->getStock(), $dto->getImage());

        $this->movieRepository->save($movie);

    }
}