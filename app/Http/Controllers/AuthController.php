<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    protected $whatsAppService;

    public function __construct(WhatsAppService $whatsAppService)
    {
        $this->whatsAppService = $whatsAppService;
    }
    public function inLogin(Request $request)
    {
        try {
            // Validasi input
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);
    
            // Cek rate limiting
            if (RateLimiter::tooManyAttempts($this->throttleKey($request), 5)) {
                return response()->json([
                    'message' => 'Terlalu banyak percobaan login. Silakan coba lagi nanti.',
                ], 429);
            }
    
            // Mencoba melakukan autentikasi
            if (auth()->attempt($credentials)) {
                // Regenerasi session ID untuk mencegah fixation attacks
                $request->session()->regenerate();
    
                // Reset rate limiter
                RateLimiter::clear($this->throttleKey($request));
    
                // Mengembalikan response JSON dengan pesan sukses
                return response()->json([
                    'message' => 'Login berhasil, dialihkan ke dashboard.',
                    'redirect' => route('home'),
                    'email' => $request->email,
                    'password' => $request->password,
                ], 200);
            }
    
            // Inkrement rate limiter
            RateLimiter::hit($this->throttleKey($request));
    
            // Logging untuk autentikasi yang gagal
            \Log::warning('Login gagal untuk email: ' . $request->email);
    
            // Mengembalikan response JSON dengan pesan error
            return response()->json([
                'message' => 'Kredensial yang diberikan tidak cocok dengan catatan kami.',
            ], 401); // 401 Unauthorized
        } catch (\Exception $e) {
            \Log::error('Error during login: ' . $e->getMessage());
            return response()->json([
                'message' => 'Terjadi kesalahan saat login. Silakan coba lagi.',
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
   
        $nama = $validatedData['nama'];
        $namaAplikasi = 'O-Rumah';
        $message = "🎉 Halo! $nama 🎉
        
        Selamat bergabung di $namaAplikasi! 🏠 Kami sangat senang memiliki kalian sebagai bagian dari komunitas ini. 🤗
        
        Ayo kejar reward prestasi mobil dengan mengajak lebih banyak teman bergabung! Semakin banyak yang ikut, semakin seru perjalanan kita menuju kesuksesan bersama. 🚀
        
        Jangan ragu untuk berbagi pengalaman dan cerita kalian di sini. Mari bersama-sama mencapai impian dan meraih kesuksesan! 💪
        
        Terima kasih sudah menjadi bagian dari $namaAplikasi! 🙌";
        
        $response = $this->whatsAppService->sendMessage($validatedData['noWa'], $message);
        
        return redirect(route('home'))->with('success', 'Registrasi berhasil. Silahkan login.');
    } catch (\Illuminate\Validation\ValidationException $e) {
        return back()->withErrors($e->validator)->withInput()->with('error', 'Terjadi kesalahan pada validasi data.');
    }
}

}
