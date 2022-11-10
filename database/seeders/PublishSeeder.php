<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PublishSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
            'logo' => '',
            'grade' => 3
        ]);
    }
}
