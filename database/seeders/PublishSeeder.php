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
            'nama' => 'Big Think',
            'alamat' => 'Jl. Siliwangi No.41, Sawah Gede, Kec. Cianjur, Kabupaten Cianjur, Jawa Barat 43212',
            'tlp' => '(0263) 261265',
            'pemilik' => 'BT.Corp',
            'bank' => 'Syariah',
            'no_rekening' => '213123',
            'npwp' => '20203872',
            'slogan' => 'Big success start from a small think',
            'email' => 'info@bigthink.corp',
            'logo' => '/assets/img/easepos_logo/ease6.png',
            'grade' => 4
        ]);
        DB::table('t_perusahaan')->insert([
            'nama' => 'Big Think3',
            'alamat' => 'Jl. Siliwangi No.41, Sawah Gede, Kec. Cianjur, Kabupaten Cianjur, Jawa Barat 43212',
            'tlp' => '(0263) 261265',
            'pemilik' => 'BT.Corp',
            'bank' => 'Syariah',
            'no_rekening' => '213123',
            'npwp' => '20203872',
            'slogan' => 'Big success start from a small think',
            'email' => 'info@bigthink.corp',
            'logo' => '/assets/img/easepos_logo/ease6.png',
            'grade' => 2
        ]);
        DB::table('t_perusahaan')->insert([
            'nama' => 'Big Think2',
            'alamat' => 'Jl. Siliwangi No.41, Sawah Gede, Kec. Cianjur, Kabupaten Cianjur, Jawa Barat 43212',
            'tlp' => '(0263) 261265',
            'pemilik' => 'BT.Corp',
            'bank' => 'Syariah',
            'no_rekening' => '213123',
            'npwp' => '20203872',
            'slogan' => 'Big success start from a small think',
            'email' => 'info@bigthink.corp',
            'logo' => '/assets/img/easepos_logo/ease6.png',
            'grade' => 2
        ]);
        DB::table('t_perusahaan')->insert([
            'nama' => 'Big Think4',
            'alamat' => 'Jl. Siliwangi No.41, Sawah Gede, Kec. Cianjur, Kabupaten Cianjur, Jawa Barat 43212',
            'tlp' => '(0263) 261265',
            'pemilik' => 'BT.Corp',
            'bank' => 'Syariah',
            'no_rekening' => '213123',
            'npwp' => '20203872',
            'slogan' => 'Big success start from a small think',
            'email' => 'info@bigthink.corp',
            'logo' => '/assets/img/easepos_logo/ease6.png',
            'grade' => 3
        ]);

        DB::table('t_users')->insert([
            'nama' => 'Super Admin',
            'alamat' => 'Cianjur',
            'tlp' => '01293912',
            'username' => 'SuperAdmin',
            'password' => bcrypt('SuperAdmin123'),
            'hak_akses' => 'super_admin',
            'id_perusahaan' => 1
        ]);

        DB::table('t_users')->insert([
            'nama' => 'SuperThink',
            'alamat' => 'Jl.Kh Shaleh',
            'tlp' => '082118356193',
            'jenis_kelamin' => 'L',
            'username' => 'Admin',
            'password' => bcrypt('admin123'),
            'hak_akses' => 'admin',
            'id_perusahaan' => 1,
        ]);
        DB::table('t_users')->insert([
            'nama' => 'Cashier',
            'alamat' => 'Jl.Kh Shaleh',
            'tlp' => '082118356193',
            'jenis_kelamin' => 'L',
            'username' => 'kasir',
            'password' => bcrypt('kasir123'),
            'hak_akses' => 'kasir',
            'id_perusahaan' => 1,
        ]);

        // DB::table('t_users')->insert([
        //     'nama' => 'ZiePos',
        //     'alamat' => 'Jl.Komplek Spenda',
        //     'tlp' => '082118356193',
        //     'jenis_kelamin' => 'L',
        //     'username' => 'super_admin',
        //     'password' => bcrypt('test123'),
        //     'hak_akses' => 'super_admin',
        //     'id_perusahaan' => 1,
        // ]);

        // DB::table('t_users')->insert([
        //     'nama' => 'ZiePos1',
        //     'alamat' => 'Jl.Komplek Spenda',
        //     'tlp' => '082118356193',
        //     'jenis_kelamin' => 'L',
        //     'username' => 'admin',
        //     'password' => bcrypt('test123'),
        //     'hak_akses' => 'admin',
        //     'id_perusahaan' => 1,
        // ]);

        // DB::table('t_users')->insert([
        //     'nama' => 'ZiePos2',
        //     'alamat' => 'Jl.Komplek Spenda',
        //     'tlp' => '082118356193',
        //     'jenis_kelamin' => 'L',
        //     'username' => 'owner',
        //     'password' => bcrypt('test123'),
        //     'hak_akses' => 'owner',
        //     'id_perusahaan' => 1,
        // ]);

        // DB::table('t_users')->insert([
        //     'nama' => 'ZiePos3',
        //     'alamat' => 'Jl.Komplek Spenda',
        //     'tlp' => '082118356193',
        //     'jenis_kelamin' => 'L',
        //     'username' => 'kasir',
        //     'password' => bcrypt('test123'),
        //     'hak_akses' => 'kasir',
        //     'id_perusahaan' => 1,
        // ]);
    }
}
