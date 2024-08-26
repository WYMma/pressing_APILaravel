<?php

use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\CreditCardController;
use App\Http\Controllers\PersonnelsController;
use App\Http\Controllers\UserController;
use App\Models\Connection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AddresseController;



Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'phone' => 'required|string',
        'password' => 'required',
        'device_name' => 'required',
        'tokenFCM' => 'required|string',
    ]);

    $user = User::where('phone', $request->phone)->first();
    Connection::create([
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
Route::post('/CreateUser', [UserController::class, 'createUser']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/user/revoke', function (Request $request) {
        $user = $request->user();
        $user->tokens()->delete();
        Connection::where('userID', $user->id)->delete();
        return 'Tokens Revoked';
    });
    Route::get('/client/{userId}', [ClientController::class, 'getClientByUserId']);
    Route::put('/client/{clientId}', [ClientController::class, 'updateClient']);
    Route::post('/change-password', [ChangePasswordController::class, 'changePassword']);
    Route::get('/personnel/{userId}', [PersonnelsController::class, 'getPersonnelByUserId']);
    Route::put('/personnel/{personnelID}', [PersonnelsController::class, 'updatePersonnel']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/addresses/{clientId}', [AddresseController::class, 'getAddresses']);  // Fetch addresses
    Route::post('/addresses', [AddresseController::class, 'createAddress']);          // Create address
    Route::put('/addresses/{addressID}', [AddresseController::class, 'updateAddress']); // Update address
    Route::delete('/addresses/{addressID}', [AddresseController::class, 'deleteAddress']); // Delete address
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/credit-cards', [CreditCardController::class, 'store']);
    Route::put('/credit-cards/{cardID}', [CreditCardController::class, 'update']);
    Route::get('/credit-cards/{clientID}', [CreditCardController::class, 'index']);
    Route::delete('/credit-cards/{cardID}', [CreditCardController::class, 'destroy']); // Delete address
});
