<?php

namespace App\Helpers;

use Throwable;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ImageHelper
{
  public static function saveBase64Image($imageData, $directory = "upload/images")
  {
    $path = public_path($directory);

    if (!File::isDirectory($path)) {
      File::makeDirectory($path, 0755, true, true);
    }

    try {
      $image = Image::make(base64_decode($imageData));
      $imageName = uniqid() . ".JPG";
      $image->save(public_path($directory . "/" . $imageName));
      $return = [
        "response" => true,
        "message" => $imageName
      ];
    } catch (Throwable $e) {
      $return = [
        "response" => false,
        "message" => $e->getMessage()
      ];
    }

    return $return;
  }

  public static function deleteImage($imagePath)
  {
    $checkFileExist = File::exists(public_path($imagePath));
    if ($checkFileExist) {
      try {
        File::delete(public_path($imagePath));
        $return = [
          "response" => true,
          "message" => "Image deleted successfully"
        ];
      } catch (Throwable $e) {
        $return = [
          "response" => false,
          "message" => $e->getMessage()
        ];
      }
      return $return;
    }
  }
}
