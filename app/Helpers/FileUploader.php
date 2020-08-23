<?php

namespace App\Helpers;

use Faker\Provider\Uuid;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class FileUploader
{
    /**
     * @param string $source
     * @return string
     */
    public static function uploadFile(string $source)
    {
        $name = Uuid::uuid();
        $fileExtension = explode("base64", $source);
        $extension = str_replace(
            'data:image/',
            '',
            str_replace(
                ';',
                '',
                $fileExtension[0]
            )
        );
        $fileSource = substr($source, strpos($source, ",") + 1);
        $fileName = "{$name}.{$extension}";
        Storage::disk('public')->put(
            $fileName,
            base64_decode($fileSource),
            ['visibility' => 'public']
        );
        return Storage::url($fileName);
    }
}
