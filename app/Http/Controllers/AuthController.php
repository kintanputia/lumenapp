<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    public function login(Request $request){
        // dd($requset->all());die();
        $user = User::where('email', $request->email)->first();

        if($user){
            if($request->password == $user->password){
                return response()->json([
                    'success' => 1,
                    'message' => 'Selamat datang '.$user->name,
                    'user' => $user
                ]);
            }
            else{
                return $this->error('Password Salah');
            }
        }
        else{
            return $this->error('Email tidak terdaftar');
        }
    }

    public function user(Request $request, $id){
        $user = User::where('id', $id)->first();
        if($user){
            return response()->json([
                'success' => 1,
                'user' => $user
            ]);
        }

        return $this->error("Gagal Menampilkan");
    }
    

    public function update(Request $request, $id){
        $user = User::where('id', $id)->first();
        if($user){
            $user->update($request->all());
            return $this->success($user);
        }

        return $this->error("Perubahan Gagal");
    }

    public function changePassword(Request $request, $id){
        $user = User::where('id', $id)->first();
        if($user){
            $user->update($request->all());
            return $this->success($user);
        }

        return $this->error("Perubahan Gagal");
    }

    
    public function success($data) {
        return response()->json([
            'success' => 1,
            'data' => $data
        ]);
    }

    public function error($pasan){
        return response()->json([
            'success' => 0,
            'message' => $pasan
        ]);
    }

    // public function login(Request $request)
    // {
    //     $this->validate($request, [
    //         'email' => 'required|email',
    //         'password' => 'required|min:6'
    //     ]);

    //     $email = $request->input('email');
    //     $password = $request->input('password');

    //     $user = User::where('email', $email)->first();
    //     if (!$user) {
    //         $error=true; 
    //         return response()->json([
    //             'error' => $error,
    //             'message' => 'Email Salah'], 401);
    //     }

    //     if($user->password === $password){
    //         $token = Str::random(40);

    //         $user->update([
    //             'api_token' => $token
    //         ]);

    //         $error=false; 

    //         return response()->json([
    //             'error' => $error,
    //             'api_token' => $token,
    //             'data' => $user
    //         ]);
    //     }
    //     else {
    //         $error=true; 
    //         return response()->json([
    //             'error' => $error,
    //             'pesan' => 'login gagal'
    //         ]);
    //     }

    // }

    public function logout(Request $request){
        $user = \Auth::user();
        $user->token = null;
        $user->save();

        return response()->json(['message' => 'Pengguna telah logout']);
    }
}
