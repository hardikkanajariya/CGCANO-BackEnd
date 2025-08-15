<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\GuestAccountCreatedMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Exception;

class GuestUserController extends Controller
{
    /**
     * Create a guest user account during ticket purchase
     */
    public function createGuestUser(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile' => 'required|string|max:20',
            'user_id' => 'nullable|string|max:255'
        ]);

        try {
            // Check if user exists first
            $existingUser = User::where('email', $request->email)->first();

            // If user exists, return their ID directly without any updates
            if ($existingUser) {
                return response()->json([
                    'user_exists' => true,
                    'message' => 'User already exists',
                    'user_id' => $existingUser->id,
                    'temp_password_sent' => false
                ], 200);
            }

            // Generate a temporary password for new user
            $tempPassword = 'CGCANO' . rand(1000, 9999);

            // Create new user account
            $user = User::create([
                'fullname' => $request->fullname,
                'email' => $request->email,
                'mobile' => $request->mobile,
                'password' => Hash::make($tempPassword),
                'role' => 'user',
                'created_by' => 'guest_registration',
                'is_guest_account' => true,
                'temp_password_sent_at' => now()
            ]);

            // Send email with temporary credentials
            $passwordSent = false;
            try {
                Mail::to($user->email)->send(new GuestAccountCreatedMail($user, $tempPassword));
                $passwordSent = true;
            } catch (Exception $e) {
                // Log email error but don't fail the registration
                Log::error('Failed to send guest account email: ' . $e->getMessage());
            }

            return response()->json([
                'user_exists' => false,
                'message' => 'Guest account created successfully',
                'user_id' => $user->id,
                'temp_password_sent' => $passwordSent
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Failed to create guest account',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
