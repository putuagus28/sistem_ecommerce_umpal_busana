<?php

use App\Admin;
use App\Pelanggan;
use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\DB;

class AkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Admin::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Admin::create([
            'name' => 'admin',
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'role' => 'admin',
            'email' => 'admin@gmail.com',
            'no_telp' => '',
            'alamat' => '',
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Pelanggan::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Pelanggan::create([
            'name' => 'pelanggan',
            'username' => 'pelanggan',
            'password' => bcrypt('pelanggan'),
            'role' => 'pelanggan',
            'email' => 'pelanggan@gmail.com',
            'no_telp' => '',
            'alamat' => '',
        ]);
    }
}
