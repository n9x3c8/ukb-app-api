<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private UserService $userService;

    /**
     * UserController Constructor
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * index function
     * 
     * @param Request $request
     */
    public function index(Request $request)
    {
        $users = $this->userService->getUsers();
        if($request->wantsJson()) {
            return $this->responseSuccess($users, 'get users list successfully');
        }
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('ukb-api-token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token
        ], 200);
    }
}
