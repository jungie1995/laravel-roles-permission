<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * ------------------------------------------------------------------------
 * auth routes
 * ------------------------------------------------------------------------
 */
Route::post('login', [AuthController::class, 'login']);
Route::get('auth/verify', [
    AuthController::class,
    'verify',
]);

Route::middleware('auth:sanctum')->group(function () {
    /**
     * ------------------------------------------------------------------------
     * common routes
     * ------------------------------------------------------------------------
     */
    Route::get('logout', [ AuthController::class, 'logout', ]);
    Route::get('user', function (Request $request) { return $request->user(); });

    /**
     * ------------------------------------------------------------------------
     * users routes
     * ------------------------------------------------------------------------
     */
    Route::get('users', [UserController::class, 'index',])->middleware('permission:users-all|users-view');

    Route::post('users', [UserController::class, 'store',])->middleware('permission:users-all|users-create');

    Route::patch('users/{userId}', [UserController::class, 'update',])->middleware('permission:users-all|users-edit');

    Route::delete('users/{userId}', [UserController::class, 'destroy',])->middleware('permission:users-all|users-delete');

    /**
     * ------------------------------------------------------------------------
     * roles routes
     * ------------------------------------------------------------------------
     */
    Route::get('roles', [RoleController::class, 'index',])->middleware('permission:roles-all|roles-view');

    Route::post('roles', [RoleController::class, 'store',])->middleware('permission:roles-all|roles-create');

    Route::patch('roles/{roleId}', [RoleController::class, 'update',])->middleware('permission:roles-all|roles-edit');

    Route::delete('roles/{roleId}', [RoleController::class, 'destroy',])->middleware('permission:roles-all|roles-delete');

    /**
     * ------------------------------------------------------------------------
     * permissions routes
     * ------------------------------------------------------------------------
     */
    Route::get('permissions', [PermissionController::class, 'index',])->middleware('permission:permissions-all|permissions-view');

    Route::post('permissions', [PermissionController::class, 'store',])->middleware('permission:permissions-all|permissions-create');

    Route::patch('permissions/{permissionId}', [PermissionController::class, 'update',])->middleware('permission:permissions-all|permissions-edit');

    Route::delete('permissions/{permissionId}', [PermissionController::class, 'destroy',])->middleware('permission:permissions-all|permissions-delete');
});
