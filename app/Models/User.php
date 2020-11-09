<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $credentials = [
        'email', 'password'
    ];

    protected $responseLogin = [
        'id','first_name', 'last_name', 'email'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];

    }

    static function rules() {
        return [
            'email' => 'required|string',
            'password' => 'required|min:6',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
        ];
    }

    public function getCredentials()
    {
        return $this->credentials;
    }

    static function credentialsRules() {
        return [
            'email' => 'required|email|string',
            'password' => 'required|string|min:6',
           ];
    }

    public function getResponseLogin()
    {
        return $this->responseLogin;
    }

}
