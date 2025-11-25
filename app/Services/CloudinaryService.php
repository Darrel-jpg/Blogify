<?php

namespace App\Services;

use Cloudinary\Api\Upload\UploadApi;

class CloudinaryService
{
    public static function upload($file, $folder = 'profile')
    {
        $upload = (new UploadApi())->upload(
            $file->getRealPath(),
            ['folder' => $folder]
        );

        return $upload['secure_url'];
    }

    // public static function delete($url)
    // {
    //     // Convert full URL to public_id
    //     $publicId = self::extractPublicId($url);

    //     if ($publicId) {
    //         Cloudinary::destroy($publicId);
    //     }
    // }

    // private static function extractPublicId($url)
    // {
    //     $path = parse_url($url, PHP_URL_PATH);
    //     $parts = explode('/', $path);
    //     $filtered = array_slice($parts, 5);

    //     if (count($filtered) < 1) {
    //         return null;
    //     }

    //     $filename = implode('/', $filtered);

    //     return pathinfo($filename, PATHINFO_DIRNAME) . '/' . pathinfo($filename, PATHINFO_FILENAME);
    // }
}