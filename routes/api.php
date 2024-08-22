<?php

use App\Http\Controllers\UserController;
use App\Models\Connection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\ClientController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'phone' => 'required|string',
        'password' => 'required',
        'device_name' => 'required',
        'tokenFCM' => 'required|string',
    ]);

    $user = User::where('phone', $request->phone)->first();
    $connection =Connection::create([
        'userID' => $user->id,
        'tokenFCM' => $request->tokenFCM,
    ]);

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'phone' => ['The provided credentials are incorrect.'],
        ]);
    }

    return $user->createToken($request->device_name)->plainTextToken;
});

Route::get('/user/revoke', function (Request $request) {
    $user = $request->user();
    $user->tokens()->delete();
    $connection = Connection::where('userID', $user->id)->delete();
    return 'Tokens Revoked';
})->middleware('auth:sanctum');

Route::get('/client/{userId}', [ClientController::class, 'getClientByUserId'])->middleware('auth:sanctum');

Route::post('/CreateUser', [UserController::class, 'createUser']);
