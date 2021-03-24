<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
Use GuzzleHttp\Client;
Use Laravel\Passport\Client as OClient;

class AuthController extends Controller
{

    public function refresToken(Request $request) {
        $request->validate([
            'refresh_token' => 'required'
        ]);
        $oClient = OClient::where('password_client', 1)->first();
        return $this->getRefreshedToken($oClient, request('refresh_token'));
    }

    public function login(Request $request) {

        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                "message" => "invalid email or password"
            ], 401);
        }

        $user = $request->user();

        $oClient = OClient::where('password_client', 1)->first();
        $tokens $this->getRefreshedToken($oClient, request('refresh_token'));

        $token = $user->createToken('Access Token');

        $user->access_token = $token->accessToken;

        return response()->json([
            "message" => "login successful",
            "user"=>$user
        ], 200);

    }

    public function signup(Request $request) {

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string'
        ]);

        $user = new User([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password)
        ]);

        $user->save();

        $token = $user->createToken('Access Token');

        $user->access_token = $token->accessToken;

        return response()->json([
            "message" => "User registered",
            "user" => $user
        ], 201);

    }

    public function logout(Request $request) {

        $request->user()->token()->revoke();
        return response()->json([
            "message" => "User logged out"
        ], 200);

    }

    public function index(Request $request) {
        return response()->json([
            "user" => $request->user()
        ], 200);
    }
}
