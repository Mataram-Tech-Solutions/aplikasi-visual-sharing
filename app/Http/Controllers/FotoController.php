<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Foto;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class FotoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::id();
        $unique = time();
        $files = $request->file('fotos'); 
        $files = Arr::wrap($files);

        if (count($files) == 1) {
            // **Jika hanya 1 foto**, langsung simpan ke tabel Foto
            $file = $files[0];
            $filename = $unique . '_' . $file->getClientOriginalName();
            $fileDb = $file->getClientOriginalName();

            $foto = Foto::create([
                'uploaded_by' => $user,
                'unique' => time(),
                'namaFile' => $fileDb,
                'deskripsi' => $request->deskripsi,
                'albumId' => null, // Tidak masuk album
            ]);
            $file->move(public_path('upload/image'), $filename);

            return response()->json([
                'status' => true,
                'message' => 'Foto berhasil diunggah!',
                'data' => $foto
            ], 200);
        } else {
            $album = Album::create([
                'name' => $request->nameAlbum,
                'deskripsi' => $request->deskripsiAlbum,
                'created_by' => $user,
            ]);
    
            // Buat folder jika belum ada
            $folderPath = public_path('uploads/images');
    
            $fotoList = [];
    
            foreach ($files as $file) {
                $filename = $unique . '_' . $file->getClientOriginalName();
                $fileDb = $file->getClientOriginalName();
                
                // Simpan file ke storage
                $file->move($folderPath, $filename);
    
                $foto = Foto::create([
                    'uploaded_by' => $user,
                    'unique' => $unique,
                    'namaFile' => $fileDb,
                    'deskripsi' => $request->deskripsi,
                    'albumId' => $album->id, // Masuk ke album yang baru dibuat
                ]);
    
                $fotoList[] = $foto;
            }

            return response()->json([
                'status' => true,
                'message' => 'Album & foto berhasil diunggah!',
                'album' => $album,
                'fotos' => $fotoList
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $userId = Auth::id(); 

            $data = Foto::where('id', $id)
                            ->where('uploaded_by', $userId)
                            ->first();

            if (!$data) {
                return response()->json(['message' => 'Data tidak ditemukan atau Anda tidak memiliki izin'], 400);
            }

            $data->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menghapus data', 'error' => $e->getMessage()], 500);
        }
    }

}
