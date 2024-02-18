<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index() {
        return view('auth.index');
    }

    public function create() {
        return view('auth.create');
    }

    public function login(Request $request) {
        $user = Auth::attempt($request->only('email', 'password'));
        if ($user) {
            return redirect()->route('transaction.index');
        }
        return redirect()->route('auth.index')->with('error', 'Invalid credentials');
    }

    public function register(RegisterRequest $request) {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);


        if ($user) {
            Auth::login($user);
        }

        return to_route('auth.index');
    }
}
