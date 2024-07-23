<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class ImageService
{
    /**
     Service for manage image operations in the system.
    */

    public static function saveImage(UploadedFile $image, string $destinationPath): ?string
    {
        if ($image->isValid()) {
            $fileName = time() . '_' . $image->getClientOriginalName();
            $image->move($destinationPath, $fileName);
            return $destinationPath . $fileName;
        }

        return null;
    }
}
