<?php

namespace App\Http\Controllers;

use App\DetailTransaksi;
use Illuminate\Http\Request;
use App\Transaksi;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::latest()->get();
        return response([
            'success' => true,
            'message' => 'List Transaksi',
            'data' => $transaksi
        ], 200);
    }

    public function show($id)
    {
        $kategori = DetailTransaksi::where('kodetransaksi', $id)->first();

        if ($kategori) {
            return response()->json([
                'success' => true,
                'message' => 'Detail transaksi!',
                'data'    => $kategori
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Transaksi Tidak Ditemukan!',
                'data'    => ''
            ], 404);
        }
    }

}
