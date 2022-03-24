<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestChangeInfoProfile;
use App\Http\Requests\RequestChangePassword;
use App\Models\User;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        return view('dashboard.profile.index');
    }

    public function changeAva(Request $request)
    {
        try {

            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:20348',
            ]);
            $user = User::findOrFail(auth()->user()->id);

            $imageName = 'profile.' . time() . '.' . $request->image->getClientOriginalExtension();

            $request->image->move(public_path('/uploads/images/profiles'), $imageName);

            if($user->avatar != 'avatar.png'){
                unlink(public_path('/uploads/images/profiles/'.$user->avatar));
            }

            $user->update([
                'avatar' => $imageName,
                'updated_at' => date(now())
            ]);

            return redirect()->route('profile')->with('success', 'Berhasil ubah avatar profile');
        } catch (\Throwable $th) {
            return back()->with('error', 'Error ' . $th->getMessage());
        }
    }

    public function changeInformation(RequestChangeInfoProfile $request)
    {
        try {
            $user = User::findOrFail(Auth::id());
            $user->update($request->validated() + ['updated_at' => date(now()), 'email_verified_at' => null]);

            return redirect()->route('profile')->with('success', 'Berhasil ubah informasi profile');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function sendVerifyEmail(Request $request)
    {
        try {
            $request->user()->sendEmailVerificationNotification();
            return response()->json([
                'message' => 'Berhasil mengirim email verifikasi'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error ' . $th->getMessage()
            ]);
        }
    }

    public function verifyEmail(EmailVerificationRequest $request)
    {
        try {
        
            $request->fulfill();
            return back()->with('success', 'Email berhasil diverifikasi.');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function changePassword(RequestChangePassword $request)
    {
        try {
            $user = User::findOrFail(Auth::id());

            if (!Hash::check($request->validated('old_password'), $user->password)) {
                return back()->with('error', 'Password lama tidak sesuai');
            }

            $user->update([
                'password' => Hash::make($request->validated('new_password')),
                'updated_at' => date(now())
            ]);

            return redirect()->route('profile')->with('success', 'Berhasil ubah password');
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
