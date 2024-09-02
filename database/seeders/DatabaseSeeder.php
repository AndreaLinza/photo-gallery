<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Album;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        DB::statement('SET FOREIGN_KEY_CHECKs=0');

        User::truncate();
        Album::truncate();
        Photo::truncate();

        User::factory(20)->has(Album::factory(10)->has(Photo::factory(20)))->create();
        /*
        $this->call(UserSeeder::class);
        $this->call(AlbumSeeder::class);
        $this->call(PhotoSeeder::class);
        */
    }
}
