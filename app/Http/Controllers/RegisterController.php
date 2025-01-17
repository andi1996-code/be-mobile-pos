<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    //show register form
    public function index()
    {
        return view('pages.auth.register');
    }

    //store register data
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $data = $request->all();
        //nama yang disimpan ke database otomatis huruf awal besar
        $data['name'] = ucwords(strtolower($request->name));
        $data['password'] = Hash::make($request->password);
        \App\Models\User::create($data);
        //ketika sukses register, redirect ke halaman login
        return redirect()->route('login')->with('success', 'Register success, please login');
    }
}
