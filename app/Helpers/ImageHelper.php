<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;

class ImageHelper
{
    /**
     * Handle the deletion of an image file.
     *
     * @param string $imagePath
     * @return void
     */
    public static function handleImageDelete($imagePath)
    {
        $defaultIcon = '/images/defaultIcon.svg';
        if (Storage::disk('public')->exists($imagePath) && strcmp($imagePath, $defaultIcon) != 0) {
            Storage::disk('public')->delete($imagePath);
        }
    }
}
