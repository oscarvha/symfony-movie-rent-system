<?php

namespace App\Service\DTO;
use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;


class MovieCreateDTO implements DTOInterface
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
     * @Assert\NotBlank()
     */
    private ?File $image;

    /**
     * @var int
     */
    private int $user;

    /**
     * MovieCreateDTO constructor.
     * @param string $title
     * @param string $reference
     * @param int $stock
     * @param File|null $image
     * @param int $user
     */
    private function __construct(string $title, string $reference, int $stock, ?File $image , int $user)
    {
        $this->title = $title;
        $this->reference = $reference;
        $this->stock = $stock;
        $this->image = $image;
        $this->user = $user;
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
     * @param User $user
     * @return MovieCreateDTO
     */
    public static function createByUser(User $user) : self
    {
        return new self(
            '',
            '',
            0,
            null,
            $user->getId()
        );
    }

    /**
     * @return int
     */
    public function getUser(): int
    {
        return $this->user;
    }
}