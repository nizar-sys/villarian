<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequestLogin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.login');
    }

    public function store(RequestLogin $request)
    {
        $credentials = $request->validated();
        if (Auth::attempt($credentials, $request->has('remember'))) {
            return redirect(route('home'))->with('success', 'Selamat datang kembali!');
        }
        return redirect(route('login'))->with('error', 'Email atau password salah.');
    }

    public function destroy()
    {
        if (Auth::user()->role == 'admin') {
            Auth::logout();
            return redirect(route('login'))->with('success', 'Anda berhasil logout.');
        }
        
        Auth::logout();
        return redirect('/');
    }

    public function redirect($provider)
    {
        try {
            return Socialite::driver($provider)->redirect();
        } catch (\Throwable $th) {
            return back()->with('error', 'Error ' . $th->getMessage());
        }
    }

    public function callback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
            $authUser = $this->findOrCreateUser($user, $provider);
            Auth::login($authUser, true);
            return redirect('/'); // redirect ke halaman home masing-masing yaa:D
        } catch (\Throwable $th) {
            return back()->with('error', 'Error ' . $th->getMessage());
        }
    }

    public function findOrCreateUser($user, $provider)
    {
        try {
            $authUser = User::where('provider_id', $user->id)->first();
            if ($authUser) {
                return $authUser;
            }
            return User::create([
                'uuid' => Str::uuid(),
                'name'     => $user->name,
                'email'    => $user->email,
                'email_verified_at' => now(),
                'password' => Hash::make('villarian'.$user->email),
                'avatar' => $user->getAvatar(),
                'provider' => $provider,
                'provider_id' => $user->id,
                'remember_token' => Str::random(100),
            ]);
        } catch (\Throwable $th) {
            return back()->with('error', 'Error ' . $th->getMessage());
        }
    }
}
