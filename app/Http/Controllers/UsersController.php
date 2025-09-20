<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return Inertia::render('Settings/User', [
            'users' => $users
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255|unique:users,name',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8', // nullable if password change is optional
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->is_admin = $request->administrator ? 1 : 0;
        $user->address = $request->address;
        $user->password = Hash::make($request->password); // fix this
        $user->save();

        return to_route('account.index');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Validate, but ignore the current user's ID for unique checks
        $request->validate([
            'name'     => 'required|string|max:255|unique:users,name,' . $user->id,
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'address'  => 'nullable|string|max:255',
            'administrator' => 'nullable|boolean',
        ]);

        // Update the existing user (not creating a new one)
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->is_admin = $request->boolean('administrator');
        $user->address  = $request->address;

        // Only hash and update password if it was provided
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->update();

        return to_route('account.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function reset_password(User $user, Request $request)
    {



    }
}
