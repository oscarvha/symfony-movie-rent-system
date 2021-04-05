<?php
/**
 * User: Oscar Sanchez
 * Date: 3/4/21
 */

namespace App\Service\Handler;


use App\Entity\Rent;
use App\Exception\NotMovieStockForRentingException;
use App\Exception\UserRentDuplicateMovie;
use App\Repository\MovieRepositoryInterface;
use App\Repository\RentRepositoryInterface;
use App\Repository\UserRepositoryInterface;
use App\Service\DTO\DTOInterface;
use App\Service\DTO\RentMovieDTO;

class RentMovieHandler implements ServiceHandlerInterface
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
     * @param MovieRepositoryInterface $movieRepository
     * @param RentRepositoryInterface $rentRepository
     */
    public function __construct(UserRepositoryInterface $userRepository,
                                MovieRepositoryInterface $movieRepository ,
                                RentRepositoryInterface $rentRepository)
    {
        $this->userRepository = $userRepository;
        $this->movieRepository = $movieRepository;
        $this->rentRepository = $rentRepository;
    }


    /**
     * @param DTOInterface|RentMovieDTO $dto
     * @return void
     * @throws NotMovieStockForRentingException
     */
    public function handle(DTOInterface|RentMovieDTO $dto)
    {
        $user = $this->userRepository->getById($dto->getUser());
        $movie = $this->movieRepository->getById($dto->getMovie());
        $rent = new Rent($user, $movie);

        $this->rentRepository->save($rent);
    }
}