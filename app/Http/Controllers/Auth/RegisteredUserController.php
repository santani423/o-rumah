<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Breeze/Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|string|lowercase|email|max:100|unique:' . User::class,
            'username' => 'required|string|lowercase|max:100|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'name.required' => 'Nama wajib diisi',
            'name.string' => 'Nama wajib berupa teks',
            'name.max' => 'Nama maksimal 100 karakter',

            'email.required' => 'Email wajib diisi',
            'email.string' => 'Email wajib berupa teks',
            'email.lowercase' => 'Email harus menggunakan huruf kecil',
            'email.email' => 'Email tidak valid',
            'email.max' => 'Email maksimal 100 karakter',
            'email.unique' => 'Email sudah terdaftar',

            'username.required' => 'Username wajib diisi',
            'username.string' => 'Username wajib berupa teks',
            'username.lowercase' => 'Username harus menggunakan huruf kecil',
            'username.max' => 'Username maksimal 100 karakter',
            'username.unique' => 'Username sudah terdaftar',

            'password.required' => 'Password wajib diisi',
            'password.confirmed' => 'Password tidak cocok',
            'password.string' => 'Password wajib berupa teks',
            'password.max' => 'Password maksimal 100 karakter',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'type' => 'unassigned',
            'timezone' => 'UTC'
        ]);

        event(new Registered($user));

        return redirect()->route('chooseRole');
    }
}
