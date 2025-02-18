<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    protected ?string $resourceName = "users";
    protected array $fileFieldNames = ["photo"];
    protected array $fileFolderPaths = ["photos"];

    /**
     * Register a new user.
     */
    public function register(UserRequest $request) {

        // Use the CreateNewUser for user creation
        $user = new User($request->validated());
        $this->storeFiles($request, $user);
        $user->save();

        // Issue a token for the user
        $token = $user->createToken($user->role." Token")->plainTextToken;

        return $this->respondAuthenticated(
            $token,
            "User registered successfully!"
        );
    }

    /**
     * Log in an existing user.
     */
    public function login(Request $request) {
        $validated = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $validated['email'])->first();

        // Check if the user exists and password matches
        if (!$user || !Hash::check($validated['password'], $user->password)) {
            return $this->respondUnAuthorized('The provided credentials are incorrect.');
        }

        $user->update(['last_login_at' => now()]);

        // Create token
        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->respondAuthenticated(
            $token,
            "User logged in successfully!",
            new UserResource($user)
        );
    }

    /**
     * Forgot Password.
     */
    public function forgotPassword(Request $request) {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Send password reset link to user's email
        Password::sendResetLink($request->only('email'));

        return $this->respondSuccess(
            "Password reset link has been sent to the provided email if it exists."
        );
    }

    /**
     * Reset Password.
     */
    public function resetPassword(Request $request) {
        $request->validate([
            'token' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Reset the user's password
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill(['password' => Hash::make($password)])->save();
            }
        );

        if ($status == Password::INVALID_USER || $status == Password::INVALID_TOKEN) {
            return $this->respondError(
                "User not found or token has expired!", null, 400
            );
        }

        return $this->respondSuccess(
            'Password has been reset successfully!'
        );
    }

    public function updatePassword(Request $request) {
        // Validate the input
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = $request->user();  // Get the authenticated user

        // Check if the current password is correct
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return $this->respondError(
                "The provided current password is incorrect.", null, 400);
        }

        // Update the password
        $user->update(['password' => $request->input('password')]);

        return $this->respondSuccess("Password updated successfully!");
    }


    /**
     * Log out the authenticated user (Revoke tokens).
     */
    public function logout(Request $request) {
        $request->user()->tokens()->delete();

        return $this->respondSuccess(
            "Logged out successfully!"
        );
    }
}
