<?php

namespace App\Http\Controllers;

use toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $cek = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($cek)) {
            $request->session()->regenerate();
            toastr()->success('Login Berhasil');
            return redirect('/pak');
        }
        toastr()->error('Login gagal!');
        return back();
    }

    public function logout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        toastr()->success('See you next time!');
        return redirect('/');
    }
}
