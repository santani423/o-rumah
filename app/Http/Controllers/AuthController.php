<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function inLogin(Request $request)
    {
        // return response()->json([
        //     'success' => true,
        //     'message' => 'Login berhasil, dialihkan ke dashboard.'
        // ]);
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect(route('home'));
        }
        return back()->with('error', 'Kredensial yang diberikan tidak cocok dengan catatan kami.');

    }
    public function inRegistrasi(Request $request)
    {
        // dd($request->all());
        try {
            $validatedData = $request->validate([
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'pilihanType' => 'required',
                'nama' => 'required|string|max:255',
                'noWa' => 'required|max:15'
            ]);

            $user = User::create([
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'name' => $validatedData['nama'],
                'username' => $validatedData['nama'],
                'wa_phone' => $validatedData['noWa'],
                'type' => $validatedData['pilihanType'],
            ]);
            // dd($request->all());
            auth()->login($user);
            return redirect(route('home'));
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Registrasi berhasil, dialihkan ke dashboard.'
            // ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->with('error', 'Terjadi kesalahan pada validasi data.');
            // return response()->json([
            //     'success' => false,
            //     'message' => 'Terjadi kesalahan pada validasi data.',
            //     'errors' => $e->errors()
            // ]);
        }
    }
}
