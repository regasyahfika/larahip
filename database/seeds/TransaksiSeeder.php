<?php

use App\DetailTransaksi;
use App\Transaksi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

    	for($i = 1; $i <= 200; $i++){
            DB::table('transaksi')->insert([
                'kodetransaksi' => 'INV'.$faker->randomNumber(4),
                'tanggal' => $faker->date,
                'total' => $faker->randomNumber(4),
            ]);
        }

        $trans = Transaksi::all();
        foreach ($trans as $item) {
            $detail = DetailTransaksi::create([
                'kodetransaksi' => $item->kodetransaksi,
                'nama_produk' => $faker->name,
                'qty' => $faker->randomNumber(2)
            ]);
        }
    }
}
