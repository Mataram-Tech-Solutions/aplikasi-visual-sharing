<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
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
        if (!$request->has('userid') || !$request->has('fotoid')) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan!',
            ], 400);
        }

        Like::create([
            'userId' => $request->userid,
            'fotoId' => $request->fotoid,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Berhasil like!',
        ],200 );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $likes = Like::where('fotoId', $id)
            ->with('likedby') // Pastikan relasi ke model User sudah ada
            ->get();

        // Kelompokkan data sesuai format yang diinginkan
        $result = [
            'id' => $id,
            'fotoId' => $id,
            'user' => $likes->map(function ($like) {
                return [
                    'id' => $like->user->id,
                    'name' => $like->user->name,
                    'email' => $like->user->email,
                    'foto' => $like->user->foto,
                    'alamat' => $like->user->alamat,
                ];
            })
        ];

        return response()->json([
            'status' => true,
            'message' => 'Data pengguna yang menyukai foto ditemukan!',
            'data' => [$result] // Dibungkus dalam array agar sesuai format
        ], 200);

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
