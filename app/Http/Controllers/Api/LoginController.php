<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class LoginController extends Controller
{
    //
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        /*Auth::validate([
            'email' => $request->email,
            'password' => $request->password,
        ]);*/

        $user = User::where('email', '=', $request->post('email'))->first();
        if ($user && Hash::check($request->password, $user->password)) {

            $token = $user->createToken($request->userAgent(), ['posts.create', 'posts.update']);

            return Response::json([
                'message' => 'Authenticated',
                'access_token' => $token->plainTextToken,
            ]);
        }

        return Response::json([
            'message' => 'Invalid email and password combination',
        ], 401);
    }

    public function tokens()
    {
        $user = Auth::guard('sanctum')->user();
        return $user->tokens;
    }

    public function logout(Request $request)
    {
        $user = Auth::guard('sanctum')->user();
        // Logout form current device
        $user->currentAccessToken()->delete();

        // Logout form all devices
        //$user->tokens()->delete();

        return [
            'message' => 'Logged out',
        ];
    }
}
