<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    // Implement JWTSubject methods
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    protected $fillable = [
        'name', // Add 'name' here
        'email',
        'password',
    ];


    public function getJWTCustomClaims()
    {
        return [];
    }
}
