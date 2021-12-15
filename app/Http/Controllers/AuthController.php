<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();
        if (!$user) {
            return response()->json(['message' => 'Email Salah'], 401);
        }

        if($user->password === $password){
            $token = Str::random(40);

            // $user->update([
            //     'token' => $token
            // ]);

            return response()->json([
                'token' => $token,
                'data' => $user
            ]);

        }

    }

    public function logout(Request $request){
        $user = \Auth::user();
        $user->token = null;
        $user->save();

        return response()->json(['message' => 'Pengguna telah logout']);
    }
}
