<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Exception;
use Illuminate\Support\Str;

class SocialiteController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $socialUser = Socialite::driver($provider)->user();
            
            // Cek apakah user sudah ada
            $user = User::where('email', $socialUser->getEmail())->first();
            
            if ($user) {
                // Update provider info jika user login dengan provider berbeda
                $user->update([
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                    'avatar' => $socialUser->getAvatar(),
                ]);
            } else {
                // Buat user baru
                $user = User::create([
                    'name' => $socialUser->getName(),
                    'email' => $socialUser->getEmail(),
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                    'avatar' => $socialUser->getAvatar(),
                    'email_verified_at' => now(),
                    'password' => null, // OAuth users tidak perlu password
                ]);
            }
            
            Auth::login($user);
            
            return redirect()->route('dashboard')->with('success', 'Login berhasil dengan ' . ucfirst($provider) . '!');
            
        } catch (Exception $e) {
            return redirect()->route('login')->withErrors([
                'error' => 'Terjadi kesalahan saat login dengan ' . ucfirst($provider) . '. Silakan coba lagi.'
            ]);
        }
    }
}
