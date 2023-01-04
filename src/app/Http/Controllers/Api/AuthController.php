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

    /**
     * Function to show all users.
     *
     * @param User || null $user
     * 
     * @return EloquentCollection | User
     * 
     */
	public function index(User $user = null) : EloquentCollection | User {
        
        if ($user) {
        	return $user;
        }

        $users = $this->userService->getAllUsers();

        return $users;
    }

    /**
     * Function to create new user.
     *
     * @param StoreUserRequest $request
     * 
     * @return User
     * 
     */
	public function create(StoreUserRequest $request) : User {
		
        $user = $this->userService->createNewUser($request->all());
        $user->token = $user->createToken("auth_token")->plainTextToken;

        return $user;

    }

    /**
     * Function to update user.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * 
     * @return User
     * 
     */
    public function update(UpdateUserRequest $request, User $user) : User {
        
        $user = $this->userService->updateUser($user, $request->all());
        
        return $user;
    }

    /**
     * Function to login user.
     *
     * @param LoginUserRequest $request
     * 
     * @return JsonResponse
     * 
     */
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

    /**
     * Function to logout user.
     *
     * @param Request $request
     * 
     * @return JsonResponse
     * 
     */
	public function logout(Request $request) : JsonResponse {
        
        $this->userService->logoutUser($request->user());

		return response()->json([
	        'message' => 'Current User Logged Out !',
	    ]);

	}

    /**
     * Function to delete user.
     *
     * @param User $user
     * 
     * @return JsonResponse
     * 
     */
    public function delete(User $user) : JsonResponse {
        
        $this->userService->deleteUser($user);

        return response()->json([
	        'message' => 'Current User Deleted !',
	    ]);
    }

    /**
     * Function to upload image.
     *
     * @param StoreImageRequest $request
     * 
     * @return JsonResponse
     * 
     */
    public function uploadImage(StoreImageRequest $request) : JsonResponse {

    	$this->userService->uploadImage($request->all());
    	
    	return response()->json([
	        'message' => 'Successfully Image uploaded!',
	    ]);
    }

    /**
     * Function to upload image.
     *
     * @param User $user
     * 
     * @return JsonResponse | Response
     * 
     */
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
