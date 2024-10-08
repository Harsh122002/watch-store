<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CustomResetPasswordController extends Controller
{
 

    public function reset(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email', // Check if email exists in users table
            'password' => 'required|string|min:8|confirmed', // Password confirmation
        ]);

        // If validation fails, return back with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Find the user by email
        $user = User::where('email', $request->email)->first();

        if ($user) {
            // Update the password
            $user->password = Hash::make($request->password);
            $user->save();

            // Optionally, log the user in after resetting the password
            auth()->login($user);

            // Flash success message
            session()->flash('success', 'Your password has been updated successfully!');

            // Redirect to home or any other page
            return redirect()->intended('/');
        } else {
            // Return back if the user is not found
            return redirect()->back()->withErrors(['email' => 'No user found with this email.']);
        }
    }
}
