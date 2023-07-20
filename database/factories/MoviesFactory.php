<?php

namespace Database\Factories;

use Illuminate\Support\Facades\File;
use Illuminate\Database\Eloquent\Factories\Factory;

class MoviesFactory extends Factory
{
    public function definition(): array
    {
        $newName = uniqid() . ".JPG";
        $oldPath = public_path("upload/images/oppenheimer.jpg");
        $newPath = public_path("upload/images/$newName");

        File::copy($oldPath, $newPath);

        return [
            'title' => 'Oppenheimer',
            'description' => 'Oppenheimer adalah film biografi sejarah Amerika Serikat tahun 2023 yang disutradarai oleh Christopher Nolan dan diproduseri oleh Christopher Nolan, Emma Thomas dan Charles Roven.',
            'rating' => 9.0,
            'image' => $newName,
        ];
    }
}
