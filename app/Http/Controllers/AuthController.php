<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function inLogin(Request $request)
    {
        try {
            // Validasi input
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            // Mencoba melakukan autentikasi
            if (auth()->attempt($credentials)) {
                // Regenerasi session ID untuk mencegah fixation attacks
                $request->session()->regenerate();

                // Mengembalikan response redirect ke halaman home
                return redirect()->route('home')->with('success', 'Login berhasil, dialihkan ke dashboard.');
            }

            // Mengembalikan response kembali ke halaman login dengan pesan error
            return back()->withErrors([
                'email' => 'Kredensial yang diberikan tidak cocok dengan catatan kami.',
            ])->onlyInput('email'); // Mempertahankan input email
        } catch (\Exception $e) {
            \Log::error('Error during login: ' . $e->getMessage());
            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat login. Silakan coba lagi.',
            ]);
        }
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
