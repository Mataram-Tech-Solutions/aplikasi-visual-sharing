<?php

namespace App\Http\Controllers;

use App\Models\Foto;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id(); // Ambil ID user yang sedang login

        $data = Foto::with('uploadby')
            ->withCount('countlikes', 'countcoment')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) use ($userId) {
                return [
                    'id' => $item->id,
                    'uploaded_by' => $item->uploaded_by,
                    'albumId' => $item->albumId,
                    'namaFile' => $item->unique."_".$item->namaFile,
                    'deskripsi' => $item->deskripsi,
                    'countlikes_count' => $item->countlikes_count,
                    'countcoment_count' => $item->countcoment_count,              
                    'created_at' => Carbon::parse($item->created_at)->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::parse($item->updated_at)->format('Y-m-d H:i:s'),
                    'uploadby' => $item->uploadby, // Jika ingin tetap menampilkan relasi
                    'is_liked' => $item->countlikes()->where('userId', $userId)->exists() // Status like
                ];
            });

        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan!',
            'data' => $data,
        ], 200);
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
