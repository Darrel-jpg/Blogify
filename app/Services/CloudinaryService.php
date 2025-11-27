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
}