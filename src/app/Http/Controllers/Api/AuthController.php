<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\StoreImageRequest;
use App\Http\Requests\LoginUserRequest;
use App\Http\Services\UserService;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthController extends Controller
{
	private $userService;

	function __construct(UserService $userService) {
        $this->userService = $userService;
    }

	public function index(User $user = null) : EloquentCollection | User {
        
        if ($user) {
        	return $user;
        }

        $users = $this->userService->getAllUsers();

        return $users;
    }

	public function create(StoreUserRequest $request) : User {
		
        $user = $this->userService->createNewUser($request);
        $user->token = $user->createToken("auth_token")->plainTextToken;

        return $user;

    }

    public function update(UpdateUserRequest $request, User $user) : User {
        
        $user = $this->userService->updateUser($user, $request);
        
        return $user;
    }

    public function login(LoginUserRequest $request) : JsonResponse {
    	
	    $userToken = $this->userService->loginUser($request->all());

        if (empty($userToken)) {
            return response()->json([
                'message' => 'Invalid login details'
            ], 401); 
        }
       
	    return response()->json([
	        'access_token' => $userToken,
	    ]);
	}

	public function logout(Request $request) : JsonResponse {
        
        $this->userService->logoutUser($request->user());

		return response()->json([
	        'message' => 'Current User Logged Out !',
	    ]);

	}

    public function delete(User $user) : JsonResponse {
        
        $this->userService->deleteUser($user);

        return response()->json([
	        'message' => 'Current User Deleted !',
	    ]);
    }

    public function uploadImage(StoreImageRequest $request) : JsonResponse {

    	$this->userService->uploadImage($request);
    	
    	return response()->json([
	        'message' => 'Successfully Image uploaded!',
	    ]);
    }

    public function image(User $user) : JsonResponse  | Response {
        
        $file = $this->userService->showImage($user);

        if (empty($file)) {
        	return response()->json([
	            'message' => 'File not found !'
	        ], 404);
        }

        return response($file['image'], 200)->header('Content-Type', $file['imageType']);

    }
}
