<?php

// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getNonAdminUsers()
    {
        // Fetch users where is_admin is false (0)
        $users = User::where('is_admin', false)->get();

        // Return the list of users in JSON format
        return response()->json($users);
    }
}
