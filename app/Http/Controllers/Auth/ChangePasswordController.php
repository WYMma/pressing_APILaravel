<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class ChangePasswordController extends Controller
{
    /**
     * Handle the password change request.
     */
    public function changePassword(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string',
        ]);

        $user = $request->user();

        // Check if the current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'current_password' => ['The provided password does not match our records.'],
            ], 452);
        }

        // Check if the password was updated in the last 30 days
        $lastUpdated = new Carbon($user->updated_at);
        if ($lastUpdated->diffInDays(Carbon::now()) < 30) {
            return response()->json([
                'error' => 'You cannot change your password within 30 days of the last change.'
            ], 453); // Custom status code (429 Too Many Requests, or you can use another custom code)
        }

        // Update the password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json(['message' => 'Password updated successfully.'], 200);
    }
}
