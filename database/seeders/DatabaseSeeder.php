<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Perusahaan;

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
            'logo' => '213123',
            'grade' => 1
        ]);

        Perusahaan::Create([
            'nama' => 'Nur',
            'alamat' => 'asdsadsadf',
            'tlp' => '012893219',
            'pemilik' => 'Nur Kumalasari',
            'bank' => 'Syariah',
            'no_rekening' => '213123',
            'npwp' => '23321321321',
            'slogan' => '213123',
            'email' => 'asdsakdjkasjdsakh@gmail.com',
            'grade' => 1,
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
            'hak_akses' => 1,
            'id_perusahaan' => '1'
        ]);

        DB::table('t_pelanggan')->insert([
            'nama' => 'Udin',
            'alamat' => 'Jl udin Udin al-udin',
            'tlp' => '082118356213',
            'jenis_kelamin' => 'L',
            'id_perusahaan' => 1,
        ]);


        DB::table('t_barang')->insert([
            'kode' => '001',
            'nama' => 'Nabati Cheese',
            'barcode' => 'BRC-2022102001',
            'tgl'=> date('Y-m-d'),
            'id_kategori' => 1,
            'id_supplier' => 1,
            'id_satuan' => 1,
            'id_merek' => 1,
            'id_perusahaan' => 1,
            'stock' => 100,
            'stock_minimal' => 2,
            'harga_beli' => 4500,
            'keuntungan' => 5,
            'keterangan' => "Anjai Mabar",
            'status' => 1,
        ]);

        DB::table('t_barang')->insert([
            'kode' => '002',
            'nama' => 'Nabati Chocolate',
            'barcode' => 'BRC-2022102002',
            'tgl'=> date('Y-m-d'),
            'id_kategori' => 1,
            'id_supplier' => 1,
            'id_satuan' => 1,
            'id_merek' => 1,
            'id_perusahaan' => 1,
            'stock' => 100,
            'stock_minimal' => 2,
            'harga_beli' => 4000,
            'keuntungan' => 5,
            'keterangan' => "Anjai Mabar",
            'status' => 1,
        ]);

        DB::table('t_barang')->insert([
            'kode' => '003',
            'nama' => 'Nabati Black',
            'barcode' => 'BRC-2022102003',
            'tgl'=> date('Y-m-d'),
            'id_kategori' => 2,
            'id_supplier' => 1,
            'id_satuan' => 1,
            'id_merek' => 1,
            'id_perusahaan' => 1,
            'stock' => 100,
            'stock_minimal' => 2,
            'harga_beli' => 6000,
            'keuntungan' => 5,
            'keterangan' => "Anjai Mabar",
            'status' => 1,
        ]);

        DB::table('t_barang')->insert([
            'kode' => '004',
            'nama' => 'Nabati Caramel',
            'barcode' => 'BRC-2022102004',
            'tgl'=> date('Y-m-d'),
            'id_kategori' => 2,
            'id_supplier' => 1,
            'id_satuan' => 1,
            'id_merek' => 1,
            'id_perusahaan' => 1,
            'stock' => 100,
            'stock_minimal' => 2,
            'harga_beli' => 2300,
            'keuntungan' => 5,
            'keterangan' => "Anjai Mabar",
            'status' => 1,
        ]);

        DB::table('t_barang')->insert([
            'kode' => '005',
            'nama' => 'Nabati Chocolate Coated',
            'barcode' => 'BRC-2022102005',
            'tgl'=> date('Y-m-d'),
            'id_kategori' => 1,
            'id_supplier' => 1,
            'id_satuan' => 1,
            'id_merek' => 2,
            'id_perusahaan' => 1,
            'stock' => 100,
            'stock_minimal' => 2,
            'harga_beli' => 3600,
            'keuntungan' => 5,
            'keterangan' => "Anjai Mabar",
            'status' => 1,
        ]);

        DB::table('t_barang')->insert([
            'kode' => '006',
            'nama' => 'Nabati White',
            'barcode' => 'BRC-2022102006',
            'tgl'=> date('Y-m-d'),
            'id_kategori' => 1,
            'id_supplier' => 1,
            'id_satuan' => 1,
            'id_merek' => 2,
            'id_perusahaan' => 1,
            'stock' => 100,
            'stock_minimal' => 2,
            'harga_beli' => 1900,
            'keuntungan' => 5,
            'keterangan' => "Anjai Mabar",
            'status' => 1,
        ]);

        DB::table('t_barang')->insert([
            'kode' => '007',
            'nama' => 'Nabati Peanut Butter',
            'barcode' => 'BRC-2022102007',
            'tgl'=> date('Y-m-d'),
            'id_kategori' => 2,
            'id_supplier' => 1,
            'id_satuan' => 2,
            'id_merek' => 1,
            'id_perusahaan' => 1,
            'stock' => 100,
            'stock_minimal' => 2,
            'harga_beli' => 2500,
            'keuntungan' => 5,
            'keterangan' => "Anjai Mabar",
            'status' => 1,
        ]);

        DB::table('t_barang')->insert([
            'kode' => '008',
            'nama' => 'Nabati Pink Lava',
            'barcode' => 'BRC-2022102008',
            'tgl'=> date('Y-m-d'),
            'id_kategori' => 2,
            'id_supplier' => 1,
            'id_satuan' => 2,
            'id_merek' => 1,
            'id_perusahaan' => 1,
            'stock' => 100,
            'stock_minimal' => 2,
            'harga_beli' => 2200,
            'keuntungan' => 5,
            'keterangan' => "Anjai Mabar",
            'status' => 1,
        ]);

        DB::table('t_barang')->insert([
            'kode' => '009',
            'nama' => 'Nabati Chocolate Coconut',
            'barcode' => 'BRC-2022102009',
            'tgl'=> date('Y-m-d'),
            'id_kategori' => 1,
            'id_supplier' => 1,
            'id_satuan' => 1,
            'id_merek' => 1,
            'id_perusahaan' => 1,
            'stock' => 100,
            'stock_minimal' => 2,
            'harga_beli' => 2300,
            'keuntungan' => 5,
            'keterangan' => "Anjai Mabar",
            'status' => 1,
        ]);

        DB::table('t_barang')->insert([
            'kode' => '010',
            'nama' => 'Nabati Raspbery Yoghurt',
            'barcode' => 'BRC-2022102010',
            'tgl'=> date('Y-m-d'),
            'id_kategori' => 1,
            'id_supplier' => 1,
            'id_satuan' => 1,
            'id_merek' => 2,
            'id_perusahaan' => 1,
            'stock' => 100,
            'stock_minimal' => 2,
            'harga_beli' => 2500,
            'keuntungan' => 5,
            'keterangan' => "Anjai Mabar",
            'status' => 1,
        ]);

        DB::table('t_barang')->insert([
            'kode' => '011',
            'nama' => 'Nabati Peach Yoghurt',
            'barcode' => 'BRC-2022102011',
            'tgl'=> date('Y-m-d'),
            'id_kategori' => 2,
            'id_supplier' => 1,
            'id_satuan' => 1,
            'id_merek' => 1,
            'id_perusahaan' => 1,
            'stock' => 100,
            'stock_minimal' => 2,
            'harga_beli' => 2100,
            'keuntungan' => 5,
            'keterangan' => "Anjai Mabar",
            'status' => 1,
        ]);

        DB::table('t_barang')->insert([
            'kode' => '012',
            'nama' => 'Nabati Hazelnut',
            'barcode' => 'BRC-2022102012',
            'tgl'=> date('Y-m-d'),
            'id_kategori' => 2,
            'id_supplier' => 1,
            'id_satuan' => 2,
            'id_merek' => 1,
            'id_perusahaan' => 1,
            'stock' => 100,
            'stock_minimal' => 2,
            'harga_beli' => 4000,
            'keuntungan' => 5,
            'keterangan' => "Anjai Mabar",
            'status' => 1,
        ]);

        DB::table('t_barang')->insert([
            'kode' => '013',
            'nama' => 'Nabati Vanilla Cream',
            'barcode' => 'BRC-2022102013',
            'tgl'=> date('Y-m-d'),
            'id_kategori' => 1,
            'id_supplier' => 1,
            'id_satuan' => 1,
            'id_merek' => 1,
            'id_perusahaan' => 1,
            'stock' => 100,
            'stock_minimal' => 2,
            'harga_beli' => 3000,
            'keuntungan' => 5,
            'keterangan' => "Anjai Mabar",
            'status' => 1,
        ]);

        DB::table('t_barang')->insert([
            'kode' => '014',
            'nama' => 'Nabati Cookies and Cream',
            'barcode' => 'BRC-2022102014',
            'tgl'=> date('Y-m-d'),
            'id_kategori' => 1,
            'id_supplier' => 1,
            'id_satuan' => 1,
            'id_merek' => 2,
            'id_perusahaan' => 1,
            'stock' => 100,
            'stock_minimal' => 2,
            'harga_beli' => 6500,
            'keuntungan' => 5,
            'keterangan' => "Anjai Mabar",
            'status' => 1,
        ]);

        DB::table('t_barang')->insert([
            'kode' => '015',
            'nama' => 'Nabati Coconut Lava',
            'barcode' => 'BRC-2022102015',
            'tgl'=> date('Y-m-d'),
            'id_kategori' => 2,
            'id_supplier' => 1,
            'id_satuan' => 1,
            'id_merek' => 1,
            'id_perusahaan' => 1,
            'stock' => 100,
            'stock_minimal' => 2,
            'harga_beli' => 8000,
            'keuntungan' => 5,
            'keterangan' => "Anjai Mabar",
            'status' => 1,
        ]);
    }
}
