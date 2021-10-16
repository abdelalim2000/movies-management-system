<?php

namespace App\Interfaces\Auth;

interface AuthUserRepositoryInterface
{
    public function register($userCreateRequest);

    public function login($userLoginRequest);

    public function profile($user);

    public function update($userUpdateRequest, $user);

    public function logout();
}
