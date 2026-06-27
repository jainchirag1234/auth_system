<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('register');
    }
    public function register(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'required'
        ]);
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);
        Auth::login($user);
        return redirect('/dashboard');
    }
    public function showLogin()
    {
        return view('login');
    }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);
        if(Auth::attempt($credentials)){
            return redirect('/dashboard');
        }
        return back()->withErrors([
            'email'=>'Invalid Credentials'
        ]);

    }
    public function dashboard()
    {
        return view('dashboard');
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
