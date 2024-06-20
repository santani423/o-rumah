<?php

namespace App\Http\Controllers;

use App\Models\PasswordChanges;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
    public function show(PasswordChanges $passwordChanges)
    {
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
    public function update(Request $request, PasswordChanges $passwordChanges)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::find(auth()->user()->id);

        // Validasi password saat ini
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak cocok.']);
        }

        // Ubah password
        $user->password = Hash::make($request->password);
        $user->save();

        // Auto login setelah perubahan password berhasil
        Auth::login($user);

        return redirect('/home')->with('success', 'Password berhasil diubah dan Anda telah login.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PasswordChanges $passwordChanges)
    {
        //
    }
}
