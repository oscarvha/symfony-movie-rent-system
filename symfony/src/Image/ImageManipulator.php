<?php


namespace App\Image;

use Exception;
use http\Exception\InvalidArgumentException;


class ImageManipulator
{
    const AVATAR_WIDTH = 50;
    const MINIATURE_WIDTH = 100;
    const EXTEND_MINIATURE_WIDTH = 250;
    const THUMBNAIL_WIDTH = 500;
    const FULL_COVER_WIDTH = 1920;


    public  static function generateAvatar(string $targetFile, string $originalFile) :void
    {
        self::resize(self::AVATAR_WIDTH,$targetFile,$originalFile);
    }

    public static function generateMiniature(string $targetFile, string $originalFile) : void
    {
     self::resize(self::MINIATURE_WIDTH,$targetFile,$originalFile);
    }

    public static function generateExtendMiniature(string $targetFile, string $originalFile) : void
    {
        self::resize(self::EXTEND_MINIATURE_WIDTH,$targetFile,$originalFile);
    }
    /**
     * @param string $targetFile
     * @param string $originalFile
     */
    public static function generateThumbnails(string $targetFile, string $originalFile) : void
    {
        self::resize(self::THUMBNAIL_WIDTH,$targetFile,$originalFile);
    }

    /**
     * @param string $targetFile
     * @param string $originalFile
     */
    public static function generateFullCover(string $targetFile, string $originalFile) : void
    {
        self::resize(self::FULL_COVER_WIDTH, $targetFile, $originalFile);
    }

    /**
     * @param $newWidth
     * @param $targetFile
     * @param $originalFile
     */
    private static function resize(int $newWidth, string $targetFile, string $originalFile) : void
    {
        $extension = self::getExtensionTmpFile($originalFile);

        switch ($extension) {
            case 'jpg':
                self::resizeImageJPG($newWidth,$targetFile,$originalFile);
                break;

            case 'png':
                self::resizeImagePNG($newWidth, $targetFile, $originalFile);
                break;

            case 'igif':
                self::resizeImageGIF($newWidth,$targetFile,$originalFile);
                break;

            default:
                throw new InvalidArgumentException('Invalid Image Type');
        }
    }

    /**
     * @param string $filename
     * @return string|null
     */
    public static function getExtensionTmpFile(string $filename) : ?string
    {
        $info = getimagesize($filename);
        $mime = $info['mime'];

        if('image/jpeg'=== $mime ) {
            return 'jpg';
        }

        if('image/png'=== $mime ) {
            return 'png';
        }

        if('image/gif'=== $mime ) {
            return 'gif';
        }
        throw new InvalidArgumentException('Invalid Image Type');
    }

    /**
     * @param int $newWidth
     * @param string $targetFile
     * @param string $originalFile
     */
    private static function resizeImageJPG(int $newWidth, string $targetFile, string $originalFile) : void
    {
        $img = imagecreatefromjpeg($originalFile);
        list($width, $height) = getimagesize($originalFile);

        $newHeight = ($height / $width) * $newWidth;
        $tmp = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        $targetFile = $targetFile.'jpg';

        if (file_exists($targetFile)) {
            unlink($targetFile);
        }

        imagejpeg($tmp, "$targetFile");

        if (!file_exists($targetFile)) {
            throw new \InvalidArgumentException(sprintf('The file %s not exist', $targetFile));
        }
    }

    /**
     * @param int $newWidth
     * @param string $targetFile
     * @param string $originalFile
     */
    private static function resizeImagePNG(int $newWidth, string $targetFile, string $originalFile) : void
    {
        $img = imagecreatefrompng($originalFile);
        list($width, $height) = getimagesize($originalFile);

        $newHeight = ($height / $width) * $newWidth;
        $tmp = imagecreatetruecolor($newWidth, $newHeight);
        $background = imagecolorallocate($tmp , 0, 0, 0);

        imagecolortransparent($tmp, $background);
        imagealphablending($tmp, false);
        imagesavealpha($tmp, true);

        imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        $targetFile = $targetFile.'png';

        if (file_exists($targetFile)) {
            unlink($targetFile);
        }

        imagepng($tmp, "$targetFile");

        if (!file_exists($targetFile)) {
            throw new \InvalidArgumentException(sprintf('The file %s not exist', $targetFile));
        }
    }


    /**
     * @param int $newWidth
     * @param string $targetFile
     * @param string $originalFile
     */
    private static function resizeImageGIF(int $newWidth, string $targetFile, string $originalFile) : void
    {
        $img = imagecreatefromgif($originalFile);
        list($width, $height) = getimagesize($originalFile);

        $newHeight = ($height / $width) * $newWidth;
        $tmp = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        $targetFile = $targetFile.'gif';

        if (file_exists($targetFile)) {
            unlink($targetFile);
        }

        imagegif($tmp, "$targetFile");

        if (!file_exists($targetFile)) {
            throw new \InvalidArgumentException(sprintf('The file %s not exist', $targetFile));
        }


    }

    public static function resize_crop_image($max_width, $max_height, $source_file, $dst_dir, $quality = 80)
    {
        $imgsize = getimagesize($source_file);
        $width = $imgsize[0];
        $height = $imgsize[1];
        $mime = $imgsize['mime'];

        switch($mime){
            case 'image/gif':
                $image_create = "imagecreatefromgif";
                $image = "imagegif";
                break;

            case 'image/png':
                $image_create = "imagecreatefrompng";
                $image = "imagepng";
                $quality = 7;
                break;

            case 'image/jpeg':
                $image_create = "imagecreatefromjpeg";
                $image = "imagejpeg";
                $quality = 80;
                break;

            default:
                return false;
                break;
        }

        $dst_img = imagecreatetruecolor($max_width, $max_height);
        imagealphablending($dst_img, false);
        imagesavealpha($dst_img, true);
        $src_img = $image_create($source_file);

        $width_new = $height * $max_width / $max_height;
        $height_new = $width * $max_height / $max_width;
        //if the new width is greater than the actual width of the image, then the height is too large and the rest cut off, or vice versa
        if($width_new > $width){
            //cut point by height
            $h_point = (($height - $height_new) / 2);
            //copy image
            imagecopyresampled($dst_img, $src_img, 0, 0, 0, $h_point, $max_width, $max_height, $width, $height_new);
        }else{
            //cut point by width
            $w_point = (($width - $width_new) / 2);
            imagecopyresampled($dst_img, $src_img, 0, 0, $w_point, 0, $max_width, $max_height, $width_new, $height);
        }

        $image($dst_img, $dst_dir, $quality);

        if($dst_img)imagedestroy($dst_img);
        if($src_img)imagedestroy($src_img);
    }



}