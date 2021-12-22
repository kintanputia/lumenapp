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
            $error=true; 
            return response()->json([
                'error' => $error,
                'message' => 'Email Salah'], 401);
        }

        if($user->password === $password){
            $token = Str::random(40);

            $user->update([
                'api_token' => $token
            ]);

            $error=false; 

            return response()->json([
                'error' => $error,
                'api_token' => $token,
                'data' => $user
            ]);
        }
        else {
            $error=true; 
            return response()->json([
                'error' => $error,
                'pesan' => 'login gagal'
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
