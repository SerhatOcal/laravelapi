<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $valitador = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($valitador->fails()){
            return response()->json([
               'message' => $valitador->messages()
            ]);
        }

        $user = User::where('email', $request->input('email'))->first();
        if ($user){
            if (Hash::check($request->input('password'), $user->password)){
                $newToken = Str::random(60);
                $user->update(['api_token' => $newToken]);

                return response()->json([
                    'name' => $user->name,
                    'access_token' => $newToken,
                    'time' => time()
                ]);
            }

            return response()->json([
                'message' => 'Invalid Password'
            ]);
        }

        return response()->json([
            'message' => 'User Not Found!'
        ]);
    }
}
