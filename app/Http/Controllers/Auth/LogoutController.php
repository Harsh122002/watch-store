<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        $request->session()->invalidate(); // Invalidate the session

        Auth::logout(); // Log the user out

        // Redirect to the login page or any other page after logout
        return redirect('/login')->with('status', 'You have been logged out.');
    }
}
