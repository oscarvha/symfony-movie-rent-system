<?php
/**
 * User: Oscar Sanchez
 * Date: 31/7/20
 */

namespace App\Util;


use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class FileUtil
{
    static public function getContentFile(string $file)
    {
        if(!file_exists($file)) {
            throw new FileNotFoundException($file);
        }

        return file_get_contents($file);
    }
}