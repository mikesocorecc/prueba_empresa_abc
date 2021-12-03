<?php

namespace App\Http\Controllers\auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\auth\AuthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
// validasi
use Illuminate\Support\Facades\Validator;

// jwt auth
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([ // validated login
            'email' => 'required|email',
            'password' => 'required',
        ]);
        // Si el correo electrónico es correcto y contraseña
        if (Auth::attempt($request->only('email','password'))) {
            $status = true;
            $user = Auth::user();
            $response = [
                    'user' =>  $user->toArray(),
                    'token' => JWTAuth::fromUser($user),
            ];
            // Estado exitoso
            return response()->json(compact('status', 'response'));
        }else {
            // ini untuk erorr
            $errors = [
                'email' => ['Email or Password is incorrect'],
                'password' => ['Email or Password is incorrect'],
            ];
            return response()->json(compact('errors'), 402);
        }


    }
    public function register(AuthRequest $request)
    {
        $request->validated(); // validate biasa
        if ($request->password === $request->confrim_password) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            // masukin role di user baru
            $user->role()->attach(2);
            return response()->json(['pesan' => 'data berhasil di tambahkan']);
        } else {
            $errors = [
                'password' => ['Password or Confrim password is incorrect'],
                'confrim_password' => ['Password or Confrim password is incorrect']
            ];
            return response()->json(compact('errors'), 402);
        }
    }
    public function userProfile() {
        return response()->json(auth()->user());
    }
    public function logout(request $request){
        Auth::logout();
        return response()->json(['status'=>'true','mensaje' => 'Usted logró cerrar sesión correctamente']);
    }
}
