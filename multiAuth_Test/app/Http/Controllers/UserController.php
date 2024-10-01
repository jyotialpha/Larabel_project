<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Show the user's profile details.
     */
    public function showDetails()
    {
        $user = Auth::user();
        return view('user.details', compact('user'));
    }

    /**
     * Show the form for updating the user's password.
     */
    public function showUpdatePasswordForm()
    {
        return view('user.update-password');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password does not match.']);
        }

        // Update password directly
        User::where('id', $user->id)->update(['password' => Hash::make($request->new_password)]);

        return redirect()->route('acount.details')->with('success', 'Password updated successfully.');
    }
}
