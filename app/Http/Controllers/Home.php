<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Home extends Controller
{
    public function home()
    {
        return response()->json([
            'message' => 'Welcome to the API',
            'status' => 'Connected'
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (auth()->attempt($credentials)) {
            $request->session()->regenerate();

            return response()->json([
                'message' => 'Login success',
                'status' => 'Connected'
            ]);
        }

        return response()->json([
            'message' => 'Login failed',
            'status' => 'Not Connected'
        ]);
    }
}
