<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\LoginUserRequest;
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
        	return $user;
        }

        $users = $this->userService->getAllUsers();

        return $users;
    }

	public function create(StoreUserRequest $request) {
		
        $user = $this->userService->createNewUser($request);
        $user->token = $user->createToken("auth_token")->plainTextToken;

        return $user;

    }

    public function update(UpdateUserRequest $request, User $user) {
        
        $this->userService->updateUser($user, $request);
        
        return $user;
    }

    public function login(LoginUserRequest $request) {
    	
	    $user = $this->userService->loginUser($request->all());

        if (empty($user)) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401); 
        }
       
	    return response()->json([
	        'access_token' => $user->token,
	    ]);
	}

	public function logout(Request $request) {
        
        $this->userService->logoutUser($request->user());

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
