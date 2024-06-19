<?php

namespace App\Http\Controllers;

use App\Models\KprFileBank;
use App\Models\FileBank;
use Illuminate\Http\Request;

class KprFileBankController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(KprFileBank $kprFileBank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KprFileBank $kprFileBank)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KprFileBank $kprFileBank)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KprFileBank $kprFileBank)
    {
        //
    }

    function fileKprBank(Request $request)
    {
        try {
            // Validasi request
            $validatedData = $request->validate([
                'file' => 'required|file',
                'kpr_id' => 'required|integer',
                'bank_id' => 'required|integer'
            ]);

            // Menyimpan file yang diupload ke dalam storage
            $path = $request->file('file')->store('/images/pengajuan/kpr/' . $request->kpr_id, 'public');

            // Membuat instance FileBank dan mengisinya dengan data
            $fileBank = new FileBank();
            $fileBank->file_name = basename($path);
            $fileBank->file_path = '/storage/images/pengajuan/kpr/' . $request->kpr_id;
            $fileBank->bank_id = $request->bank_id;
            $fileBank->file_type = $request->file_type;
            $fileBank->save();

            // Membuat instance KprFileBank dan mengisinya dengan data
            $kprFileBank = new KprFileBank();
            $kprFileBank->kpr_id = $request->kpr_id;
            $kprFileBank->file_bank_id = $fileBank->id;
            $kprFileBank->save();

            // Mengembalikan user ke halaman sebelumnya dengan pesan sukses
            return back()->with('success', 'File Bank berhasil disimpan');
        } catch (\Exception $e) {
            // Menangani kesalahan yang mungkin terjadi
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
