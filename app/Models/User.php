<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    // Specify the fields that are mass assignable
    protected $fillable = ['name', 'email', 'password']; // Add the fields you want to allow

    // Implement JWT methods
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    public function projects()
{
    return $this->belongsToMany(Project::class);
}
public function tasks()
{
    return $this->hasMany(Task::class);
}
}
