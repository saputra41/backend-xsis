<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MoviesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [[
            "title" => "Pengabdi Setan 2 Comunion",
            "description" => "Adalah sebuah film horor Indonesia tahun 2022 yang disutradarai dan ditulis oleh Joko Anwar sebagai sekuel dari film tahun 2017, Pengabdi Setan.",
            "rating" => 7.0,
            "image" => "",
            "created_at" => now()
        ], [
            "title" => "Pengabdi Setan",
            "description" => "",
            "rating" => 8.5,
            "image" => "",
            "created_at" => now()
        ]];

        DB::table('movies')->insert($data);
    }
}
