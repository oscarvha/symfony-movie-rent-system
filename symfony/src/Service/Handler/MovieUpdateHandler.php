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
use App\Service\DTO\MovieUpdateDTO;

class MovieUpdateHandler implements ServiceHandlerInterface
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
     * @param DTOInterface|MovieUpdateDTO $dto
     * @return mixed
     * @throws MovieExistWithTheSameNameException
     * @throws MovieReferenceExistException
     * @throws UserTypeNotPermitManipulateObjectException
     * @throws StockNotShouldBeNegativeException
     */
    public function handle(DTOInterface|MovieUpdateDTO $dto)
    {
        $user = $this->userRepository->getById($dto->getUser());

        if(!$user->getRoles()->has(Roles::ADMIN)) {
            throw new UserTypeNotPermitManipulateObjectException();
        }

        $movie = $this->movieRepository->getById($dto->getMovie());

        $existByTitle = $this->movieRepository->findByTitle($dto->getTitle());

        if($existByTitle) {
            if($movie->getId() != $existByTitle->getId()) {
                throw new MovieExistWithTheSameNameException();
            }
        }

        $existByReference = $this->movieRepository->findByReference($dto->getReference());

        if($existByReference) {
            if($movie->getId() != $existByReference->getId()) {
                return throw new MovieReferenceExistException();

            }
        }

        $movie->setTitle($dto->getTitle());
        $movie->setReference($dto->getReference());
        $movie->setStock($dto->getStock());

        if($dto->getImage()) {
            $movie->addMedias($dto->getImage());
        }

        $this->movieRepository->save($movie);

    }


}