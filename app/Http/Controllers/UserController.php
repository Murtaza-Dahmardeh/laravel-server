<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;

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
            'profile_picture' => '',
            'password' => 'min:6|confirmed',
        ]);

        $user = new User([
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'title' => $request->get('title'),
            'company' => $request->get('company'),
            'email' => $request->get('email'),
            'phone_number' => $request->get('phone_number'),
            'bio' => $request->get('bio'),
            'profile_picture' => $request->get('profile_picture'),
            'password' => bcrypt($request->get('password')),
        ]);
        $user->save();

        return response()->json(['data' => $user, 'message' => 'User has been added']);
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        return response()->json($user);
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
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
    
        $user->delete();
    
        return response()->json(['message' => 'User deleted successfully']);
    }

    /**
     * Upload the profile picture.
     */
    public function upload(Request $request)
    {
        $photo = $request->file('image');
        $filename = $photo->store('photos');
    
        $headers = [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS',
            'Access-Control-Allow-Headers' => 'Content-Type, X-Auth-Token, Origin, Authorization',
        ];
    
        return response()->json([
            'filename' => $filename
        ], 200, $headers);
    }

    public function loadPhoto($filename) {
        $path = storage_path('app/photos/' . $filename);
    
        if (!File::exists($path)) {
            abort(404);
        }
    
        $file = File::get($path);
        $type = File::mimeType($path);
    
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
    
        return $response;
    }
}
