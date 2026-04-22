<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login-register', ['mode' => 'login']);
    }

    public function showRegister()
    {
        return view('auth.login-register', ['mode' => 'register']);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'is_admin' => false,
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Compte créé avec succès.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->is_admin) {
                return redirect()->route('admin.dashboard')
                    ->with('success', 'Bienvenue dans l’espace administrateur.');
            }

            return redirect()->route('home')
                ->with('success', 'Connexion réussie.');
        }

        return back()
            ->withErrors([
                'email' => 'Email ou mot de passe incorrect.',
            ])
            ->withInput()
            ->with('mode', 'login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Déconnexion réussie.');
    }
}