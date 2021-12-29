<?php

namespace App\Http\Controllers;

use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function register(Request $request){
        //nama, email, password
        $validasi = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required|unique:users',
            'no_hp' => 'required|unique:users',
            'password' => 'required|min:6'
        ]);

        if($validasi->fails()){
            $val = $validasi->errors()->all();
            return $this->error($val[0]);
        }

        // $user = User::create($request->all());

        $user = User::create([
                    'id' => 1,
                    'email' => $request->email,
                    'password' => $request->password,
                    'nama' => $request->nama,
                    'no_hp' => $request->no_hp
                ]);

        if($user){
            return response()->json([
                'success' => 1,
                'message' => 'Selamat datang Register Berhasil',
                'user' => $user
            ]);
        }

        return $this->error('Registrasi gagal');

    }

    public function error($pasan){
        return response()->json([
            'success' => 0,
            'message' => $pasan
        ]);
    }

    // public function register(Request $request){
    //     $this->validate($request, [
    //         'email' => 'required|unique:users|email',
    //         'password' => 'required|min:6'
    //     ]);
    //     $email = $request->input('email');
    //     $password = Hash::make($request->input('password'));

    //     $user = User::create([
    //         'email' => $email,
    //         'password' => $password
    //     ]);

    //     return response()->json(['message' => 'Pendaftaran pengguna berhasil dilaksanakan']);
    // }

    public function getUser(){
        
        $user = User::where('id_user', '=', Auth::user()->id)->first();
        return response()->json([
            'data' => $user
        ]);
    }

}
