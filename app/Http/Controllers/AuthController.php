<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
  public function login()
  {
    return view('pages.auth.login');
  }

  public function cekLogin(Request $request)
  {
    $input = $request->validate([
      'email' => ['required'],
      'password' => ['required'],
    ]);

    if (Auth::attempt($input)) {
      if (Auth::user()->isAktif()) {
        return redirect(route('dashboard.index'))->withInfo('Anda berhasil masuk!');
      } else {
        Auth::logout();
        return back()->withWarning('Akun anda tidak aktif!');
      }
    } else {
      return back()->withInput()->withWarning('Email atau password salah!');
    }
  }

  public function logout(Request $request)
  {
    Auth::logout();
    return redirect(route('home'));
  }
}
