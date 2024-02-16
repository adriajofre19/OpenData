<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginGithubController extends Controller
{
    public function login()
    {
        return Socialite::driver(driver: 'github')->redirect();
    }

    public function callback()
    {
        $userAuth = Socialite::driver('github')->user();
        $user = User::where('email', $userAuth->email)->first();
    
        if ($user) {
            // Si el usuario existe, intenta iniciar sesión
            Auth::login($user);
    
            // Redirige a la página deseada después de iniciar sesión
            return redirect('/profile');
        } else {
            // Si el usuario no existe, puedes manejarlo de acuerdo a tus necesidades
            return redirect('/login')->with('error', 'Usuario no encontrado');
        }
    }
}