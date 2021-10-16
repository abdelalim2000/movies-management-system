<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\UserCreateRequest;
use App\Http\Requests\Auth\UserLoginRequest;
use App\Http\Requests\Auth\UserUpdateRequest;
use App\Interfaces\Auth\AuthUserRepositoryInterface;
use App\Models\User;
use Illuminate\Http\Request;

class AuthUserController extends Controller
{
    private $authUserInterface;

    /**
     * @param AuthUserRepositoryInterface $authUserInterface
     */
    public function __construct(AuthUserRepositoryInterface $authUserInterface)
    {
        $this->authUserInterface = $authUserInterface;
    }

    public function register(UserCreateRequest $userCreateRequest)
    {
        return $this->authUserInterface->register($userCreateRequest);
    }

    public function login(UserLoginRequest $userLoginRequest)
    {
        return $this->authUserInterface->login($userLoginRequest);
    }

    public function profile(User $user)
    {
        return $this->authUserInterface->profile($user);
    }

    public function update(UserUpdateRequest $userUpdateRequest, User $user)
    {
        return $this->authUserInterface->update($userUpdateRequest, $user);
    }

    public function logout()
    {
        return $this->authUserInterface->logout();
    }
}
