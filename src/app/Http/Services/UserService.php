<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\StoreImageRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class UserService
{
    
    public function getAllUsers() : EloquentCollection {
        return User::all();
    }

    public function createNewUser(StoreUserRequest $request) : User {
        
        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return $user;
    }

    public function updateUser(User $user, UpdateUserRequest $request) : User {

        $user->name = ($request->name) ? $request->name : $user->name;  
        $user->last_name = ($request->last_name) ? $request->last_name : $user->last_name;
        $user->phone = ($request->phone) ? $request->phone : $user->phone;
        $user->email = ($request->email) ? $request->email : $user->email;
        $user->password = ($request->password) ? Hash::make($request->password) : $user->password;

        $user->save();

        return $user;
    }

    public function deleteUser(User $user) : bool {

        $user->tokens()->delete();
        return $user->delete();

    }

    public function uploadImage(StoreImageRequest $request) : User {

        $user = User::where('id', $request->user_id)->first();
        $user->image_path = $request->file('image')->store('image', 'public');
        $user->save();

        return $user;
    
    }

    public function showImage(User $user) : array {
        
        $image = Storage::get('public/'.$user->image_path);
        $imageType = Storage::mimeType('public/'.$user->image_path);

        if (empty($image)) {
            return [];
        }
        
        return ['image' => $image, 'imageType' => $imageType];
    
    }

    public function loginUser(array $input) : string {

        if (!Auth::attempt($input)) {
            return '';
        }

        $user = User::where('email', $input['email'])->first();

        return $user->createToken('auth_token')->plainTextToken;
    }

    public function logoutUser(User $user) : bool {
        return $user->currentAccessToken()->delete();
    }
}
