<?php

use Illuminate\Database\Seeder;
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
        $kategori = [
            [
                'nama_kategori' => 'Teknologi'
            ],
            [
                'nama_kategori' => 'Seni'
            ]
        ];
        DB::table('kategori')->insert($kategori);
    }
}
