<?php

// app/Http/Controllers/UserController.php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function getNonAdminUsers(Request $request)
    {
        $perPage = $request->input('per_page', 15);
        $page = $request->input('page', 1);

        // Fetch users where is_admin is false (0) with pagination
        $users = User::where('is_admin', false)->paginate($perPage, ['*'], 'page', $page);

        return response()->json($users);
    }
    
}
