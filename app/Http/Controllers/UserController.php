<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return response()->json(['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'title' => 'required',
            'company' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required',
            'bio' => 'required',
            'profile_picture' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'password' => 'min:6|confirmed',
        ]);

        // $profilePictureName = time().'.'.$request->profile_picture->extension();  
        // $request->profile_picture->move(public_path('profile_pictures'), $profilePictureName);

        $user = new User([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'title' => $request->get('title'),
            'company' => $request->get('company'),
            'email' => $request->get('email'),
            'phone_number' => $request->get('phone_number'),
            'bio' => $request->get('bio'),
            // 'profile_picture' => $profilePictureName,
            'password' => bcrypt($request->get('password')),
        ]);
        $user->save();

        return response()->json(['data' => $user, 'message' => 'User has been added']);
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'sometimes|min:6|confirmed',
        ]);

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        if ($request->filled('password')) {
            $user->password = bcrypt($request->get('password'));
        }
        $user->save();

        return redirect('/users')->with('success', 'User has been updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect('/users')->with('success', 'User has been deleted');
    }
}
