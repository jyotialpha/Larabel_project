<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    //*This Method will show login page for customer
    public function index()
    {
        return view('login');
    }

    //*This Method will authenticate user
    public function authenticate(Request $request)
{
    // Validate the input
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if ($validator->passes()) {
        // Attempt to authenticate the customer user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Check if the user is a customer
            if (Auth::user()->role != "customer") {
                // If not a customer, log them out and redirect to login page
                Auth::logout();
                return redirect()->route('acount.login')->with('error', 'You are not authorized to access this page');
            }
            // If customer, redirect to customer dashboard
            return redirect()->route('acount.dashboard');
        } else {
            // If authentication fails, redirect to login page with error message
            return redirect()->back()->with('error', 'Invalid email or password');
        }
    } else {
        // If validation fails, redirect to login page with errors
        return redirect()->route('acount.login')->withErrors($validator)->withInput();
    }
}

    //*This method show the registration page
    public function register()
    {
        return view('register');
    }

    public function processRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
        ]);

        if ($validator->passes()) {

            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = bcrypt($request->password);
            $user->role = 'customer';
            $user->save();
            return redirect()->route('acount.login')->with('success','you have registerd successfully.');
        } else {
            return redirect()->route('acount.register')->withErrors($validator)->withInput();
        }
    }


    public function logout(){
        Auth::logout();
        return redirect()->route('acount.login');
    }
}
