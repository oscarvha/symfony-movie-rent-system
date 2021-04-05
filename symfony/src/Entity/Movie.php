<?php
/**
 * User: Oscar Sanchez
 * Date: 29/3/21
 */

namespace App\Entity;


use App\Exception\NotMovieStockForRentingException;
use App\Exception\StockNotShouldBeNegativeException;
use App\Image\ImageManipulator;
use App\Util\StringUtil;
use App\Util\UploadsUtil;
use Symfony\Component\HttpFoundation\File\File;

class Movie
{
    const UPLOAD_SUBDIRECTORY = 'movie';

    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $title;

    /**
     * @var string
     */
    private string $reference;

    /**
     * @var int
     */
    private int $stock;

    /**
     * @var string|null
     */
    private ?string $image;

    /**
     * Movie constructor.
     * @param string $title
     * @param string $reference
     * @param int $stock
     * @param File|null $image
     * @throws StockNotShouldBeNegativeException
     */
    public function __construct(string $title, string $reference, int $stock, ?File $image)
    {
        $this->title = $title;
        $this->reference = $reference;

        if($stock < 0) {
            throw new StockNotShouldBeNegativeException();
        }

        $this->stock = $stock;

        $this->addMedia($image);
    }

    /**
     * @param File|null $image
     */
    private function addMedia(?File $image)
    {
        if($image) {
            $this->addImage($image);
        }
    }

    /**
     * @param File $image
     */
    private function addImage(File $image)
    {
        if (isset($this->image)) {
            $this->deleteImage();
        }

        $cleanString = StringUtil::cleanString($this->title);
        $fileName = $cleanString . '-main-' . uniqid() . '.';
        $extension = ImageManipulator::getExtensionTmpFile($image);
        $fileOutput = UploadsUtil::getDirectoryPrivateUploadsPath(self::UPLOAD_SUBDIRECTORY) . '/' . $fileName;

        ImageManipulator::generateThumbnails($fileOutput, $image);

        $this->image = UploadsUtil::getPublicPath(self::UPLOAD_SUBDIRECTORY) . '/' . $fileName . $extension;
    }

    public function addMedias(File $image)
    {
        $this->addImage($image);
    }

    /**
     *
     */
    private function deleteImage()
    {
        try {
            UploadsUtil::delete(UploadsUtil::getDirectoryPath($this->image));

        } catch (\InvalidArgumentException $e) {
        }


        $this->image = null;
    }

    public function deleteMedias()
    {
        $this->deleteImage();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
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
     * @throws StockNotShouldBeNegativeException
     */
    public function setStock(int $stock): void
    {
        if($stock < 0) {
            throw new StockNotShouldBeNegativeException();
        }
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @param string|null $image
     */
    public function setImage(?string $image): void
    {
        $this->image = $image;
    }

    /**
     * @throws NotMovieStockForRentingException
     */
    public function rent()
    {
        if($this->stock < 1) {
            throw new NotMovieStockForRentingException();
        }

        $this->stock--;
    }

    /**
     *
     */
    public function unRent(): void
    {
        $this->stock++;
    }

    /**
     * @return bool
     */
    public function isAvailableForRent(): bool
    {
        if($this->stock < 1) {
           return false;
        }

        return true;
    }


}