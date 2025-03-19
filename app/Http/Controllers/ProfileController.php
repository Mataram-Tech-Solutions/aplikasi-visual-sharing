<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Foto;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id = Auth::id();
        $user = User::where('id', $id)->first();
        $userid = $user->id;
        $totalLikes = Foto::where('uploaded_by', $userid)
            ->withCount('countlikes') // Pastikan relasi countlikes() ada di model Foto
            ->get()
            ->sum('countlikes_count');
        $photos = Foto::where('uploaded_by', $userid)
            ->withCount('countlikes')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($photo) use ($userid) {
                return [
                    'id' => $photo->id,
                    'uploaded_by' => $photo->uploaded_by,
                    'albumId' => $photo->albumId,
                    'namaFile' => $photo->unique."_".$photo->namaFile,
                    'deskripsi' => $photo->deskripsi,
                    'countlikes_count' => $photo->countlikes_count ?? 0,
                    'countcoment_count' => $photo->countcoment_count ?? 0,
                    'created_at' => Carbon::parse($photo->created_at)->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::parse($photo->updated_at)->format('Y-m-d H:i:s'),
                    'uploadby' => $photo->uploadby, // Jika ingin tetap menampilkan relasi
                    'is_liked' => $photo->countlikes()->where('userId', $userid)->exists()
                ];
            });

            // $albums = Album::with('fotoalbum') // Pastikan relasi fotoalbum ada di Model Album
            // ->where('created_by', $userid)
            // ->orderBy('created_at', 'desc')
            // ->get()
            // ->map(function ($album) use ($userid) { 
            //     return [
            //         'id' => $album->id,
            //         'type' => 'album',
            //         'judulAlbum' => $album->name,
            //         'namaFile' => $album->fotoalbum->map(function ($foto) {
            //             return $foto->unique . "_" . $foto->namaFile; // Ambil hanya nama file
            //         })->toArray(), // Ubah ke array biasa
            //         'uploaded_by' => $album->createdby,
            //         'is_liked' => $album->countlikesalbum()->where('userId', $userid)->exists(),
            //         'created_at' => $album->created_at->format('Y-m-d H:i:s'),
            //     ];
            // });
        

        // Gabungkan album dan foto, lalu urutkan berdasarkan created_at
        // $mergedData = collect($photos)->merge($albums)->sortByDesc('created_at')->values();

        return response()->json([
            'status' => true,
            'message' => 'Data user ditemukan!',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'foto' => $user->foto,
                'alamat' => $user->alamat,
                'jumlahlike' => $totalLikes,
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $user->updated_at->format('Y-m-d H:i:s'),
                'postingan' => $photos, // Semua data foto dan album dalam satu array
            ]
        ], 200);    }

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
        //
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
    public function destroy(string $id)
    {
        //
    }
}
