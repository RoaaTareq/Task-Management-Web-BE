<?php
// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Optionally, you can include authorization logic here
        // $this->authorize('viewAny', User::class);

        $users = User::all(); // Fetch all users

        return response()->json($users);
    }
}
