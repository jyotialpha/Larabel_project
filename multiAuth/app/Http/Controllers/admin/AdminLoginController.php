<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminLoginController extends Controller
{

    //This method will show admin login page/screen
    public function index()
    {
        return view('admin.login');
    }

    //*This Method will authenticate Admin user
    public function authenticate(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->passes()) {

            if (Auth::guard('web')->attempt(['email' => $request->email, 'password' => $request->password])) {

                if (Auth::guard('web')->user()->role!="admin") {
                    Auth::guard('web')->logout();
                    return redirect()->route('admin.login')->with('error', 'You are not Autherise to asscess this Page');
                }


                return redirect()->route('admin.AdminDashboard');
            } else {
                return redirect()->route('admin.login')->with('error', 'Invalid email or password');
            }
        } else {
            return redirect()->route('admin.login')->withErrors($validator)->withInput();
        }
    }

    //*This Function will logout admin user
    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('admin.login');
    }

    //*Admin register Controller
    public function register()
    {
        return view('admin.register');
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
            $user->role = 'admin';
            $user->save();
            return redirect()->route('admin.login')->with('success', 'you have registerd successfully.');
        } else {
            return redirect()->route('admin.register')->withErrors($validator)->withInput();
        }
    }
}
