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
            'password' => 'required'
        ]);

        // Cek rate limiting
        // if (RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Terlalu banyak percobaan login. Silakan coba lagi nanti.',
        //         'data' => $request->all()
        //     ], 429); // 429 Too Many Requests
        // }

        // Mencoba melakukan autentikasi
        if (auth()->attempt($credentials)) {
            // Regenerasi session ID untuk mencegah fixation attacks
            $request->session()->regenerate();

            // Reset rate limiter
            RateLimiter::clear($this->throttleKey($request));

            // Mengembalikan response redirect ke halaman home
            return response()->json([
                'success' => true,
                'message' => 'Login berhasil, dialihkan ke dashboard.',
                'data' => $request->all()
            ], 200);
        }

        // Inkrement rate limiter
        RateLimiter::hit($this->throttleKey($request));

        // Logging untuk autentikasi yang gagal
        \Log::warning('Login gagal untuk email: ' . $request->email);

        // Mengembalikan response kembali ke halaman login dengan pesan error
        return response()->json([
            'success' => false,
            'message' => 'Kredensial yang diberikan tidak cocok dengan catatan kami.',
                'data' => $request->all()
        ], 401); // 401 Unauthorized
    } catch (\Exception $e) {
        \Log::error('Error during login: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan saat login. Silakan coba lagi.',
                'data' => $request->all()
        ], 500); // 500 Internal Server Error
    }
}


    protected function throttleKey(Request $request)
    {
        return Str::lower($request->input('email')) . '|' . $request->ip();
    }



    public function inRegistrasi(Request $request)
{
    try {
        $validatedData = $request->validate([
            'email' => 'required|email|unique:users,email',
            'username' => [
                'required',
                'string',
                'max:255',
                'unique:users,username',
                // aturan validasi kustom untuk username
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^[a-zA-Z0-9-_]+$/', $value)) {
                        $fail('The '.$attribute.' format is invalid.');
                    }
                },
            ],
            'password' => 'required|min:6',
            'pilihanType' => 'required',
            'nama' => 'required|string|max:255',
            'noWa' => 'required|max:15'
        ]);

        $user = User::create([
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'name' => $validatedData['nama'],
            'username' => $validatedData['username'],
            'wa_phone' => $validatedData['noWa'],
            'type' => $validatedData['pilihanType'],
        ]);

        return redirect(route('home'))->with('success', 'Registrasi berhasil. Silahkan login.');
    } catch (\Illuminate\Validation\ValidationException $e) {
        return back()->withErrors($e->validator)->withInput()->with('error', 'Terjadi kesalahan pada validasi data.');
    }
}

}
