<?php

namespace App\Http\Controllers;

use App\Models\PasswordChanges;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Contracts\Service\Attribute\Required;

class PasswordChangesController extends Controller
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
    public function show($passwordChanges)
    {
        // dd($passwordChanges);
        return view('Pages/PasswordUpdate', compact('passwordChanges'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PasswordChanges $passwordChanges)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $passwordChanges)
    {
        // dd($request->all());
        // $request->validate([
        //     'current_password' => 'required',
        //     'password' => 'required',
        // ]);
        $passwordChanges = PasswordChanges::where('uuid', $passwordChanges)->first();
        $user = User::find($passwordChanges->user_id);



        // Ubah password
        $user->password = Hash::make($request->password);
        $user->save();

        // Auto login setelah perubahan password berhasil
        // Auth::login($user);

        return redirect(route('home'))->with('success', 'Password berhasil diubah silahkan login');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PasswordChanges $passwordChanges)
    {
        //
    }

    function verifikasiCode(){
        return view('Pages/verifikasiCode' );
    }

    public function verifikasiCodeTes(Request $request) {
        // Validasi untuk memastikan kode verifikasi ada
        $request->validate([
            'verification_code' => 'required'
        ]);
    
        // Mencari data perubahan password berdasarkan kode verifikasi
        $passwordChanges = PasswordChanges::where('noVerifikasi', $request->verification_code)->first();
        
        // Jika data perubahan password ditemukan, redirect ke halaman perubahan password
        if ($passwordChanges) {
            return redirect()->route('passwrod.change', $passwordChanges->uuid);
        }
    
        // Jika tidak ditemukan, kembali dengan pesan error
        return back()->with('error', 'Kode Verifikasi salah!!');
    }
    
}
