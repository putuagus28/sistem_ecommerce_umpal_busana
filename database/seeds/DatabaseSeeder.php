<?php

use Database\Seeders\KategoriSeeder;
use Database\Seeders\LocationsSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AkunSeeder::class);
        $this->call(KategoriSeeder::class);
        $this->call(LocationsSeeder::class);
    }
}
