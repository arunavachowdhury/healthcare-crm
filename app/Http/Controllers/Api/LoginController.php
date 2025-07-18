<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
            'password' => ['required']
        ]);
 
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('login');

            return response()->json(['status'=> 'success', 'data'=> $user, 'token' => $token->plainTextToken]);
        }
 
        return response()->json([
            'status' => 'error',
            'error' => 'The provided credentials do not match our records.',
        ]);
    }
}
