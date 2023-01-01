<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;

class AuthController extends Controller
{

    use HttpResponses;

    public function register(RegisterUserRequest $request) 
    {    
        $request->validated($request->only(['username', 'email', 'password']));

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('API Token')->plainTextToken;

        return $this->success([
            'user' => $user,
            'token' => $token
        ], 'Registration is sucessful.', 201);
    }

    public function login(LoginUserRequest $request) 
    {
        $request->validated($request->only(['email', 'password']));

        if(!Auth::attempt($request->only('email', 'password'))) {
            return $this->error('', 'Credentials do not match.', 401);
        }

        $user = User::where('email', $request->email)->first();

        $token = $user->createToken('API Token')->plainTextToken;

        return $this->success([
            'user' => $user,
            'token' => $token
        ], 'Login is successful.');
    }

    public function logout() 
    {
        Auth::user()->currentAccessToken()->delete();

        return $this->success('', 'You have succesfully been logged out and your token has been removed.');
    }
}
