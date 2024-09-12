<?php

use App\Http\Controllers\ApiKeyController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\CreditCardController;
use App\Http\Controllers\LignePanierController;
use App\Http\Controllers\MissionController;
use App\Http\Controllers\PersonnelsController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use App\Models\Connection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AddresseController;
use App\Http\Controllers\FcmController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PressingController;


Route::post('send-fcm-notification', [FcmController::class, 'sendFcmNotification']);

Route::post('/sanctum/token', function (Request $request) {
    $request->validate([
        'phone' => 'required|string',
        'password' => 'required',
        'device_name' => 'required',
        'tokenFCM' => 'required|string',
    ]);

    $user = User::where('phone', $request->phone)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'phone' => ['The provided credentials are incorrect.'],
        ]);
    }

    Connection::create([
        'userID' => $user->id,
        'tokenFCM' => $request->tokenFCM,
    ]);

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
    Route::get('/addresses/single/{addressID}', [AddresseController::class, 'getAddressById']); // Get address by ID
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/credit-cards', [CreditCardController::class, 'store']);
    Route::put('/credit-cards/{cardID}', [CreditCardController::class, 'update']);
    Route::get('/credit-cards/{clientID}', [CreditCardController::class, 'index']);
    Route::delete('/credit-cards/{cardID}', [CreditCardController::class, 'destroy']); // Delete address
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('api-keys', [ApiKeyController::class, 'index']);
    Route::post('api-keys', [ApiKeyController::class, 'store']);
    Route::get('api-keys/{id}', [ApiKeyController::class, 'show']);
    Route::put('api-keys/{id}', [ApiKeyController::class, 'update']);
    Route::delete('api-keys/{id}', [ApiKeyController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/services', [ServiceController::class, 'index']);
    Route::post('/services', [ServiceController::class, 'store']);
    Route::put('/services/{id}', [ServiceController::class, 'update']);
    Route::delete('/services/{id}', [ServiceController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/sales', [SaleController::class, 'index']);
    Route::post('/sales', [SaleController::class, 'store']);
    Route::put('/sales/{id}', [SaleController::class, 'update']);
    Route::delete('/sales/{id}', [SaleController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/items', [ItemController::class, 'index']);
    Route::post('/items', [ItemController::class, 'store']);
    Route::get('/items/{id}', [ItemController::class, 'show']);
    Route::put('/items/{id}', [ItemController::class, 'update']);
    Route::delete('/items/{id}', [ItemController::class, 'destroy']);
    Route::get('/categories', [CategorieController::class, 'getCategoryIdAndName']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/create-cart', [LignePanierController::class, 'createCart']);
    Route::post('/lignepanier', [LignePanierController::class, 'store']);
    Route::get('/lignepanier/{cartID}', [LignePanierController::class, 'index']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/commande', [CommandeController::class, 'store']);
    Route::get('/commande/', [CommandeController::class, 'index']);
    Route::get('/commande/{commandeID}', [CommandeController::class, 'show']);
    Route::delete('/commande/{commandeID}', [CommandeController::class, 'destroy']);
    Route::put('/commande/{commandeID}', [CommandeController::class, 'update']);
    Route::put('/commande/pickup/{commandeID}', [CommandeController::class, 'pickup']);
    Route::put('/commande/deliver/{commandeID}', [CommandeController::class, 'deliver']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/pressing', [PressingController::class, 'index']);
    Route::post('/pressing', [PressingController::class, 'store']);
    Route::get('/pressing/{id}', [PressingController::class, 'show']);
    Route::put('/pressing/{id}', [PressingController::class, 'update']);
    Route::delete('/pressing/{id}', [PressingController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/missions', [MissionController::class, 'index']);
    Route::get('/missions/{id}', [MissionController::class, 'show']);
    Route::post('/missions', [MissionController::class, 'store']);
    Route::put('/missions/{id}', [MissionController::class, 'update']);
    Route::delete('/missions/{id}', [MissionController::class, 'destroy']);
});
