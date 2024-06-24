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
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return to_route('home');
        }

        return to_route('auth.index')->withErrors(['error' => 'Invalid credentials']);
    }

    public function register(RegisterRequest $request) {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);


        if ($user) {
            Auth::login($user);
            return to_route('home');
        }

        return back()->withErrors('Error creating user. Please try again.')->withInput(['name' => $request->input('name'), 'email' => $request->input('email')]);
    }

    public function logout() {
        Auth::logout();
        return to_route('auth.index');
    }
}
