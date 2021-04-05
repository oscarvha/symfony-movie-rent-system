<?php

namespace App\Service\DTO;
use App\Entity\Movie;
use App\Entity\User;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;


class MovieUpdateDTO implements DTOInterface
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    private string $title;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    private string $reference;

    /**
     * @var int
     * @Assert\Positive
     */
    private int $stock;

    /**
     * @var File|null
     * @Assert\Image
     */
    private ?File $image;

    /**
     * @var int
     */
    private int $user;

    /**
     * @var int
     */
    private int $movie;

    /**
     * MovieCreateDTO constructor.
     * @param string $title
     * @param string $reference
     * @param int $stock
     * @param File|null $image
     * @param int $user
     * @param int $movie
     */
    private function __construct(string $title, string $reference, int $stock, ?File $image , int $user, int $movie)
    {
        $this->title = $title;
        $this->reference = $reference;
        $this->stock = $stock;
        $this->image = $image;
        $this->user = $user;
        $this->movie = $movie;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     */
    public function setReference(string $reference): void
    {
        $this->reference = $reference;
    }

    /**
     * @return int
     */
    public function getStock(): int
    {
        return $this->stock;
    }

    /**
     * @param int $stock
     */
    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }

    /**
     * @return File|null
     */
    public function getImage(): ?File
    {
        return $this->image;
    }

    /**
     * @param File|null $image
     */
    public function setImage(?File $image): void
    {
        $this->image = $image;
    }

    /**
     * @param Movie $movie
     * @param User $user
     * @return MovieUpdateDTO
     */
    #[Pure] public static function createByMovieAndUser(Movie $movie, User $user) : self
    {
        return new self(
            ($movie->getTitle()) ? $movie->getTitle() : '',
            ($movie->getReference()) ? $movie->getReference() : '',
            ($movie->getStock()) ? $movie->getStock() : '',
            null,
            $user->getId(),
            $movie->getId()
        );
    }

    /**
     * @return int
     */
    public function getUser(): int
    {
        return $this->user;
    }

    /**
     * @return int
     */
    public function getMovie(): int
    {
        return $this->movie;
    }
}