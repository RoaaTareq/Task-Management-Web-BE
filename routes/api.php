<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;





/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// routes/api.php

// routes/api.php

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');

Route::get('/categories', [CategoryController::class, 'index']);


Route::middleware('auth:api')->group(function () {
    Route::resource('tasks', TaskController::class);
    Route::get('/tasks/{taskId}/categories', [TaskController::class, 'getTaskCategories']);
    Route::get('/tasks/{taskId}/users', [TaskController::class, 'getUsersForTask']);
    Route::get('/dashboard', [TaskController::class, 'dashboard']);
});




