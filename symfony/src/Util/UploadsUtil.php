<?php

namespace App\Util;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;

class UploadsUtil
{
    const UPLOADS_DIRECTORY = 'uploads';
    const DIRECTORY_PUBLIC = __DIR__.'/../../public';
    const DIRECTORY_PUBLIC_UPLOADS = __DIR__.'/../../public/uploads';

    public static function upload(File $uploadedFile, string $directory, string $fileName): void
    {
        self::createDirectoryIfNotExists(self::DIRECTORY_PUBLIC_UPLOADS.'/'.$directory);

        if (file_exists($directory) && !is_dir($directory)) {
            throw new FileException(sprintf('The path %s is a file, not a directory', $directory));
        }

        $uploadedFile->move(self::DIRECTORY_PUBLIC_UPLOADS.'/'.$directory, $fileName);
    }


    public static function delete(string $filePath): void
    {
        if (!file_exists($filePath)) {
            throw new \InvalidArgumentException(sprintf('The file %s not exist', $filePath));
        }

        unlink($filePath);
    }

    public static function getDirectoryPath(string $subdirectory = ''): string
    {
        $path = realpath(self::DIRECTORY_PUBLIC);

        if (!empty($subdirectory)) {
            $path .= '/'.$subdirectory;
        }

        return $path;
    }

    public static function getDirectoryPathUploads(string  $subdirectory = ''): string
    {
        $path = '/'.self::DIRECTORY_PUBLIC_UPLOADS;

        if (!empty($subdirectory)) {
            $path .= '/'.$subdirectory;
        }

        return $path;
    }

    public static function getPublicPath(string $subdirectory = ''): string
    {
        $path = '/'.self::UPLOADS_DIRECTORY;

        if (!empty($subdirectory)) {
            $path .= '/'.$subdirectory;
        }

        return $path;
    }

    public static function getDirectoryPrivateUploadsPath(string $subdirectory = ''): string
    {
        $path = realpath(self::DIRECTORY_PUBLIC_UPLOADS);

        if (!empty($subdirectory)) {
            $path .= '/'.$subdirectory;
        }

        return $path;
    }

    public static function createDirectoryIfNotExists(string $path): void
    {
        if (!file_exists($path)) {
            mkdir($path, 0777);
        }
    }

    public static function createSubdirectoryIfNotExists(string $subdirectory): void
    {
        static::createDirectoryIfNotExists(self::DIRECTORY_PUBLIC_UPLOADS.'/'.$subdirectory);
    }

    public static function existFile(string $filePath): bool
    {
        if (file_exists($filePath)) {
            return true;
        }

        return false;
    }
}
