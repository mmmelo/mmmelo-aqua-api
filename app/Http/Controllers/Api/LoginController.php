<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function auth( Request $request) {
        $tokenExp = $this->tokenExp( false);
        $credentials = $request->only( $this->user->getCredentials());
        Validator::make( $credentials, User::credentialsRules())->validate();
        if( $token = Auth::guard( 'api')->setTTL($tokenExp)->attempt($credentials)){
            return $this->successResponse( [
                    'token' => $token,
                    'expires_in' => Auth::guard('api')->factory()->getTTL(),
                    'user' => Auth::guard( 'api')->user()->only( $this->user->getResponseLogin()),
                ]);
        }
        return $this->errorResponse( Constants::AUTH_LOGIN_FAILED, Response::HTTP_UNAUTHORIZED);
    }
}
