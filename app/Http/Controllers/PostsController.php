<?php

namespace App\Http\Controllers;

use App\Post;
use App\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Image;
use File;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::with('category')->latest()->get();
        return response([
            'success' => true,
            'message' => 'List Posts',
            'data' => $posts
        ], 200);
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id_kategori' => 'required|exists:App\Kategori,id',
                'judul' => 'required|min:5',
                'gambar' => 'required|image|mimes:jpeg,png',
                'isi' => 'required|min:6',
                'status' => 'required|in:true,false',
            ],
                [
                    'id_kategori.required' => 'Masukkan Kategori!',
                    'judul.required' => 'Masukkan Judul Post!',
                    'gambar.required' => 'Masukkan Gambar Post !',
                    'isi.required' => 'Masukkan Isi Post!',
                    'status.required' => 'Masukkan Status!',
                ]
            );

            if($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silahkan Isi Data',
                    'data'    => $validator->errors()
                ],400);

            } else {
                $kategori = Kategori::find($request->get('id_kategori'));
                if (!$kategori) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Tidak ada data',
                    ], 400);
                }
                if($request->gambar){
                    $imageName = time().'.'.$request->gambar->getClientOriginalExtension();
                    $request->gambar->move(public_path('images'), $imageName);
                }
                $post = new Post();
                $post->id_kategori = $kategori->id;
                $post->judul = $request->input('judul');
                $post->isi = $request->input('isi');
                $post->status = $request->input('status');
                $post->gambar = $imageName;
                $post->save();

                if ($post) {
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
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception]);
        }

    }


    public function show($id)
    {
        $post = Post::find($id);

        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'Detail Post!',
                'data'    => $post
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post Tidak Ditemukan!',
                'data'    => ''
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'id_kategori' => 'required|exists:App\Kategori,id',
                'judul' => 'required|min:5',
                'gambar' => 'required|image|mimes:jpeg,png',
                'isi' => 'required|min:6',
                'status' => 'required|in:true,false',
            ],
                [
                    'id_kategori.required' => 'Masukkan Kategori!',
                    'judul.required' => 'Masukkan Judul Post!',
                    'gambar.required' => 'Masukkan Gambar Post !',
                    'isi.required' => 'Masukkan Isi Post!',
                    'status.required' => 'Masukkan Status!',
                ]
            );

            if($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silahkan Data',
                    'data'    => $validator->errors()
                ],400);

            } else {
                $kategori = Kategori::find($request->get('id_kategori'));
                if (!$kategori) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Tidak ada data',
                    ], 400);
                }
                $post = Post::find($id);
                $post->id_kategori = $kategori->id;
                $post->judul = $request->input('judul');
                $post->isi = $request->input('isi');
                $post->status = $request->input('status');
                if($request->gambar){
                    $imageName = time().'.'.$request->gambar->getClientOriginalExtension();
                    $request->gambar->move(public_path('images'), $imageName);
                    \File::delete('images/'.$post->gambar);
                    $post->gambar = $imageName;
                }
                $post->save();

                if ($post) {
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
        } catch (\Throwable $th) {
            //throw $th;
        }

    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        \File::delete('images/'.$post->gambar);
        $post->delete();

        if ($post) {
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
