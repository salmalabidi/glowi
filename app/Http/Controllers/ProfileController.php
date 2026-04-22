<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Ajouter les compteurs - Vérifie que les relations existent
        $user->orders_count = $user->orders()->count() ?? 0;
        $user->reviews_count = $user->reviews()->count() ?? 0;
        $user->wishlists_count = $user->wishlists()->count() ?? 0;
        
        // Change 'profile.index' en 'account.index'
        return view('account.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);
        
        $user->update($validated);
        
        return redirect()->route('profile.index')->with('success', 'Vos informations ont été mises à jour avec succès !');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'nullable|url|max:500',
        ]);
        
        $user = Auth::user();
        $user->profile_photo = $request->profile_photo;
        $user->save();
        
        return redirect()->route('profile.index')->with('success', 'Votre photo de profil a été mise à jour !');
    }

    public function deletePhoto()
    {
        $user = Auth::user();
        $user->profile_photo = null;
        $user->save();
        
        return redirect()->route('profile.index')->with('success', 'Votre photo de profil a été supprimée.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|current_password',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);
        
        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);
        
        return redirect()->route('profile.index')->with('success', 'Votre mot de passe a été changé avec succès !');
    }
}