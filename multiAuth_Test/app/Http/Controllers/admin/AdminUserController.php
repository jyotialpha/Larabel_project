<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    // Display a list of users
    public function index()
    {
        $users = User::where('role', 'customer')->get();
        return view('admin.users.index', compact('users'));
    }

    // Display a single user
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    // Show the form for editing a user
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // Update the specified user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all()); // Add validation as needed
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    // Remove the specified user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}

