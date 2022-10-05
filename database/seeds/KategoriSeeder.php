<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Kategori;
use Illuminate\Support\Facades\DB;


class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Kategori::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        for ($i = 0; $i < 4; $i++) {
            Kategori::create([
                'nama_kategori' => 'kategori' . ($i + 1),
            ]);
        }
    }
}
