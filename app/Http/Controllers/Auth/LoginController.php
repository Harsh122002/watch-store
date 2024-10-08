<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // If validation fails, return back with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Attempt to log in
        if (Auth::attempt($request->only('email', 'password'))) {
            // Authentication passed
            return redirect('/');
        }

        // Authentication failed
        return redirect()->back()->withErrors(['email' => 'Invalid email or password'])->withInput();
    }
    public function adminLogin(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        // If validation fails, return back with errors
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        // Ensure the user is an admin
        $credentials = $request->only('email', 'password');
        $credentials['type'] = 'admin'; // Add the role check
    
        // Attempt to log in with admin credentials
        if (Auth::attempt($credentials)) {
            // Authentication passed, redirect to admin dashboard or home
            return redirect('/admin-home'); // Adjust this to the appropriate route
        }
    
        // Authentication failed
        return redirect()->back()->withErrors(['email' => 'Invalid email, password, or access level'])->withInput();
    }
    
}
