<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('t_perusahaan')->insert([
            'nama' => 'IDK',
            'alamat' => 'asdsadsadf',
            'tlp' => '3213213',
            'pemilik' => 'I dont know',
            'bank' => 'Syariah',
            'no_rekening' => '213123',
            'npwp' => '21312312312',
            'slogan' => '213123',
            'email' => 'asdsakdjkasjdsakh',
            'logo' => '213123'
        ]);

        DB::table('t_perusahaan')->insert([
            'nama' => 'Nur',
            'alamat' => 'asdsadsadf',
            'tlp' => '012893219',
            'pemilik' => 'Nur Kumalasari',
            'bank' => 'Syariah',
            'no_rekening' => '213123',
            'npwp' => '23321321321',
            'slogan' => '213123',
            'email' => 'asdsakdjkasjdsakh@gmail.com',
            'logo' => '/assets/img/buildings.png'
        ]);

        DB::table('t_kategori')->insert([
            'nama' => 'Makanan',
            'id_perusahaan' => '1'
        ]);

        DB::table('t_kategori')->insert([
            'nama' => 'Minuman',
            'id_perusahaan' => '1'
        ]);

        DB::table('t_merek')->insert([
            'nama' => 'Nabati',
            'id_perusahaan' => '1'
        ]);

        DB::table('t_merek')->insert([
            'nama' => 'Aqua',
            'id_perusahaan' => '1'
        ]);

        DB::table('t_satuan')->insert([
            'nama' => 'Sachet',
            'id_perusahaan' => '1'
        ]);

        DB::table('t_satuan')->insert([
            'nama' => 'Meter',
            'id_perusahaan' => '1'
        ]);

        DB::table('t_supplier')->insert([
            'nama' => 'PT. Surya Dana',
            'alamat' => 'Jl. Siliwangi no 44 cianjur',
            'tlp' => '234234234',
            'salesman' => 'Asep',
            'bank' => 'Syariah',
            'no_rekening' => '213123',
            'id_perusahaan' => '1'
        ]);

        DB::table('t_users')->insert([
            'nama' => 'fadhil',
            'alamat' => 'cianjur',
            'tlp' => '01293912',
            'username' => 'SuperAdmin',
            'password' => bcrypt('SuperAdmin123'),
            'hak_akses' => 'admin',
            'id_perusahaan' => '1'
        ]);
    }
}
