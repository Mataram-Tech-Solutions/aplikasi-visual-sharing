<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Carbon\Carbon;
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
        // Validasi request
        if (!$request->has('userid') || !$request->has('fotoid')) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan!',
            ], 400);
        }

        $like = Like::where('userId', $request->userid)
            ->where('fotoId', $request->fotoid)
            ->first();

        if ($like) {
            $like->delete();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil unlike!',
            ], 200);
        } else {
            Like::create([
                'userId' => $request->userid,
                'fotoId' => $request->fotoid,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Berhasil like!',
            ], 200);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $likes = Like::where('fotoId', $id)
            ->with('likedby') // Pastikan relasi ke model User sudah ada
            ->get();

        $result = [
            'fotoId' => $id,
            'user' => $likes->map(function ($like) {
                return [
                    'id' => $like->likedby->id,
                    'name' => $like->likedby->name,
                    'email' => $like->likedby->email,
                    'foto' => $like->likedby->foto,
                    'created_at' => Carbon::parse($like->created_at)->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::parse($like->updated_at)->format('Y-m-d H:i:s'),
                ];
            })
        ];

        return response()->json([
            'status' => true,
            'message' => 'Data pengguna yang menyukai foto ditemukan!',
            'data' => [$result]
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
