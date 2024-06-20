<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function inLogin(Request $request)
    {
        try {
            // Validasi input
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required|min:8'
            ]);

            // Cek rate limiting
            if (RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
                return back()->withErrors([
                    'email' => 'Terlalu banyak percobaan login. Silakan coba lagi nanti.',
                ])->onlyInput('email');
            }

            // Mencoba melakukan autentikasi
            if (auth()->attempt($credentials)) {
                // Regenerasi session ID untuk mencegah fixation attacks
                $request->session()->regenerate();

                // Reset rate limiter
                RateLimiter::clear($this->throttleKey($request));

                // Mengembalikan response redirect ke halaman home
                return redirect()->route('home')->with('success', 'Login berhasil, dialihkan ke dashboard.');
            }

            // Inkrement rate limiter
            RateLimiter::hit($this->throttleKey($request));

            // Logging untuk autentikasi yang gagal
            \Log::warning('Login gagal untuk email: ' . $request->email);

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

    protected function throttleKey(Request $request)
    {
        return Str::lower($request->input('email')) . '|' . $request->ip();
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
            // auth()->login($user);
            return redirect(route('home'))->with('success', 'Password berhasil diubah silahkan login');
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
