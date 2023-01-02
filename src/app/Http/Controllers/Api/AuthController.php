<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\StoreImageRequest;
use App\Http\Resources\UserResource;
use App\Http\Services\UserService;

class AuthController extends Controller
{
	private $userService;

	function __construct(UserService $userService) {
        $this->userService = $userService;
    }

	public function index(User $user = null) {
        
        if ($user) {
        	return UserResource::collection(collect([$user]));
        }

        $users = $this->userService->getAllUsers();

        return UserResource::collection($users);
    }

	public function create(StoreUserRequest $request) {
		
        $user = $this->userService->createNewUser($request);

        return response()->json([
                'user' => $user,
                'token' => $user->createToken("auth_token")->plainTextToken
        ], 201);

    }

    public function update(UpdateUserRequest $request, User $user) {
        
        $this->userService->updateUser($user, $request);
        
        return response()->json([
	        'message' => 'Current User Updated !',
	    ]);
    }

    public function login(Request $request) {
    	
    	$credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

	    if (!Auth::attempt($credentials)) {
	        return response()->json([
	            'message' => 'Invalid login details'
	        ], 401);
	    }

	    $user = User::where('email', $request['email'])->first();
	    $token = $user->createToken('auth_token')->plainTextToken;

	    return response()->json([
	        'access_token' => $token,
	        'token_type' => 'Bearer',
	    ]);
	}

	public function logout(Request $request) {

		$request->user()->currentAccessToken()->delete();

		return response()->json([
	        'message' => 'Current User Logged Out !',
	    ]);

	}

    public function delete(User $user) {
        
        $this->userService->deleteUser($user);

        return response()->json([
	        'message' => 'Current User Deleted !',
	    ]);
    }

    public function uploadImage(StoreImageRequest $request) {

    	$this->userService->uploadImage($request);
    	
    	return response()->json([
	        'message' => 'Successfully Image uploaded!',
	    ]);
    }

    public function image(User $user) {
        
        $file = $this->userService->showImage($user);

        if (empty($file)) {
        	return response()->json([
	            'message' => 'File not found !'
	        ], 404);
        }

        return response($file['image'], 200)->header('Content-Type', $file['imageType']);

    }
}
