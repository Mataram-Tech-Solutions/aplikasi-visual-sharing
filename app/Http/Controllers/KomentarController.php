<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KomentarController extends Controller
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
        $id = Auth::id();
        if (!$request->has('fotoid') || !$request->has('komentar')) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan!',
            ], 400);
        }

        Komentar::create([
            'created_by' => $id,
            'fotoId' => $request->fotoid,
            'isikomen' => $request->komentar,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Berhasil berkomentar!',
            'data' => $request->komentar
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $komentars = Komentar::where('fotoId', $id)
            ->with('komentarby')
            ->get();

        if ($komentars->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada komentar untuk foto ini!',
                'data' => []
            ], 400);
        }

        $result = $komentars->map(function ($komentar) {
            return [
                'id' => $komentar->id, // Ambil ID dari komentar
                'fotoId' => $komentar->fotoId,
                'user' => [
                    'id' => $komentar->komentarby->id,
                    'name' => $komentar->komentarby->name,
                    'email' => $komentar->komentarby->email,
                    'foto' => $komentar->komentarby->foto,
                ],
                'komentar' => $komentar->isikomen,
                'created_at' => Carbon::parse($komentar->created_at)->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::parse($komentar->updated_at)->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Data pengguna yang berkomentar ditemukan!',
            'data' => $result
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
        $komentar = Komentar::where('id', $id)
            ->first();

        if ($komentar) {
            $komentar->delete();

            return response()->json([
                'status' => true,
                'message' => 'Berhasil hapus komentar!',
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan!',
            ], 400);
        }
    }
}
