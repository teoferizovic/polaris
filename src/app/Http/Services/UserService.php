<?php

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class UserService
{
    /**
     * Function to get all users.
     *
     * @return EloquentCollection
     * 
     */
    public function getAllUsers() : EloquentCollection {
        return User::all();
    }

    /**
     * Function to create new user.
     *
     * @param Array $input
     * 
     * @return User
     * 
     */
    public function createNewUser(array $input) : User {
        
        $user = User::create([
            'name' => $input['name'],
            'last_name' => $input['last_name'],
            'phone' => $input['phone'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        return $user;
    }

    /**
     * Function to update user.
     *
     * @param User $user
     * @param Array $input
     * 
     * @return User
     * 
     */
    public function updateUser(User $user, array $input) : User {

        $user->name = ($input['name']) ? $input['name'] : $user->name;  
        $user->last_name = ($input['last_name']) ? $input['last_name'] : $user->last_name;
        $user->phone = ($input['phone']) ? $input['phone'] : $user->phone;
        $user->email = ($input['email']) ? $input['email'] : $user->email;
        $user->password = ($input['password']) ? Hash::make($input['password']) : $user->password;

        $user->save();

        return $user;
    }

    /**
     * Function to delete user.
     *
     * @param User $user
     * 
     * @return Bool
     * 
     */
    public function deleteUser(User $user) : bool {

        $user->tokens()->delete();
        return $user->delete();

    }

    /**
     * Function to upload image.
     *
     * @param Array $input
     * 
     * @return User
     * 
     */
    public function uploadImage(array $input) : User {

        $user = User::where('id', $input['user_id'])->first();
        $user->image_path = $input['image']->store('image', 'public');
        $user->save();

        return $user;
    
    }

    /**
     * Function to show image.
     *
     * @param User $user
     * 
     * @return Array
     * 
     */
    public function showImage(User $user) : array {
        
        $image = Storage::get('public/'.$user->image_path);
        $imageType = Storage::mimeType('public/'.$user->image_path);

        if (empty($image)) {
            return [];
        }
        
        return ['image' => $image, 'imageType' => $imageType];
    
    }

    /**
     * Function to login user.
     *
     * @param Array $input
     * 
     * @return String
     * 
     */
    public function loginUser(array $input) : ?User  {

        if (!Auth::attempt($input)) {
            return null;
        }

        $user = User::with('userRole.featurePermissions')->where('email', $input['email'])->first();

        return $user;
    }

    /**
     * Function to logout user.
     *
     * @param User $user
     * 
     * @return Bool
     * 
     */
    public function logoutUser(User $user) : bool {
        return $user->currentAccessToken()->delete();
    }
}
