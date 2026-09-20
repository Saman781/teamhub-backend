<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\PositionController;
use Illuminate\Support\Facades\Route;

// Public routes (no login needed)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes (login required)
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    // Users
    Route::apiResource('users', UserController::class);
    Route::post('/users/{user}/assign-role', [UserController::class, 'assignRole']);

    // Roles
    Route::apiResource('roles', RoleController::class);
    Route::get('/permissions', [RoleController::class, 'allPermissions']);

    // Positions
    Route::apiResource('positions', PositionController::class);
});

Route::get('/debug-check', function () {
    return response()->json([
        'roles' => \Spatie\Permission\Models\Role::all(),
        'permissions' => \Spatie\Permission\Models\Permission::all(),
        'positions' => \App\Models\Position::with('role')->get(),
    ]);
});