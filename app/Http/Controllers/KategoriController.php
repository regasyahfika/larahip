<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kategori;
use Illuminate\Support\Facades\Validator;

class KategoriController extends Controller
{
    public function index()
    {
        $posts = Kategori::latest()->get();
        return response([
            'success' => true,
            'message' => 'List Kategori',
            'data' => $posts
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required'
        ],
            [
                'nama_kategori.required' => 'Masukkan Nama Kategori!',
            ]
        );

        if($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Silahkan Isi Data',
                'data'    => $validator->errors()
            ],400);

        } else {
            $kategori = new Kategori();
            $kategori->status = $request->input('nama_kategori');
            $kategori->save();

            if ($kategori) {
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal disimpan',
                ], 400);
            }
        }
    }


    public function show($id)
    {
        $kategori = Kategori::find($id);

        if ($kategori) {
            return response()->json([
                'success' => true,
                'message' => 'Detail kategori!',
                'data'    => $kategori
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Kategori Tidak Ditemukan!',
                'data'    => ''
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_kategori' => 'required'
        ],
            [
                'nama_kategori.required' => 'Masukkan Nama Kategori!',
            ]
        );

        if($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => 'Silahkan Data',
                'data'    => $validator->errors()
            ],400);

        } else {
            $kategori = Kategori::find($id);
            $kategori->nama_kategori = $request->input('nama_kategori');
            $kategori->save();

            if ($kategori) {
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil Diupdate!',
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal Diupdate!',
                ], 500);
            }

        }

    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        if ($kategori) {
            return response()->json([
                'success' => true,
                'message' => 'Berhasil Dihapus!',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal Dihapus!',
            ], 500);
        }
    }
}
