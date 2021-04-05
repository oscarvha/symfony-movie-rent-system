<?php
/**
 * User: Oscar Sanchez
 * Date: 3/4/21
 */

namespace App\Entity;


use App\Entity\ValueObject\RentStatus;
use App\Entity\ValueObject\Roles;
use App\Exception\NotMovieStockForRentingException;
use App\Exception\RentIsAlreadyIsFinishedException;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Validator\Constraints\DateTime;

class Rent
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var User
     */
    private User $user;

    /**
     * @var Movie
     */
    private Movie $movie;

    /**
     * @var \DateTimeInterface
     */
    private \DateTimeInterface $createdAt;

    /**
     * @var \DateTimeInterface
     */
    private \DateTimeInterface $updatedAt;

    /**
     * @var RentStatus
     */
    private RentStatus $status;

    /**
     * Rent constructor.
     * @param User $user
     * @param Movie $movie
     * @throws NotMovieStockForRentingException
     */
    public function __construct(User $user, Movie $movie)
    {
        $this->user = $user;
        $this->movie = $movie;
        $this->createdAt =  new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->rent($movie);

    }

    /**
     * @param Movie $movie
     * @throws NotMovieStockForRentingException
     */
    private function rent(Movie $movie)
    {
        $this->status = RentStatus::creatByStatus(RentStatus::PENDING_CONFIRM);
        $movie->rent();
    }

    /**
     * @return string
     */
    #[Pure] public function getStatus(): string
    {
        return $this->status->get();
    }

    /**
     * @return Movie
     */
    public function getMovie(): Movie
    {
        return $this->movie;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt(): \DateTime|\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime|\DateTimeInterface
     */
    public function getUpdatedAt(): \DateTime|\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @throws RentIsAlreadyIsFinishedException
     */
    public function cancel()
    {
        if($this->isFinish()) {
            throw new RentIsAlreadyIsFinishedException();
        }
        $newRentStatus = RentStatus::createByUser(RentStatus::CANCELED);
        $this->movie->unRent();
        $this->status = $newRentStatus;
    }

    /**
     * @throws RentIsAlreadyIsFinishedException
     */
    public function return()
    {
        if($this->isFinish()) {
            throw new RentIsAlreadyIsFinishedException();
        }
        $newRentStatus = RentStatus::createByUser(RentStatus::RETURNED_USER);
        $this->movie->unRent();
        $this->status = $newRentStatus;
    }

    /**
     * @param string $newStatus
     * @throws RentIsAlreadyIsFinishedException
     */
    public function changeStatus(string $newStatus)
    {
        if($this->isFinish()) {
            throw new RentIsAlreadyIsFinishedException();
        }

        if($newStatus === RentStatus::CANCELED) {
            $this->cancel();
        }

        if($newStatus === RentStatus::FINISH) {
            $this->finish();
        }

        $newStatus = RentStatus::creatByStatus($newStatus);
        $this->status = $newStatus;
    }


    private function finish()
    {
        $this->movie->unRent();
        $newRentStatus = RentStatus::creatByStatus(RentStatus::FINISH);
        $this->status = $newRentStatus;
    }

    #[Pure] public function isFinish(): bool
    {
        return in_array($this->status->get(), RentStatus::FINISHED_STATUS);
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }


}