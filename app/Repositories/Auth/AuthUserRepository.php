<?php

namespace App\Repositories\Auth;

use App\Http\Resources\Auth\UserResource;
use App\Interfaces\Auth\AuthUserRepositoryInterface;
use App\Models\User;
use App\traits\UploadImageTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthUserRepository implements AuthUserRepositoryInterface
{
    use UploadImageTrait;

    protected $userModel;

    /**
     * @param User $userModel
     */
    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function register($userCreateRequest)
    {
        DB::beginTransaction();
        try {
            $user = $this->userModel->query()->create([
                'name' => $userCreateRequest->name,
                'email' => $userCreateRequest->email,
                'password' => Hash::make($userCreateRequest->password)
            ]);
            $token = $user->createToken('user_token')->plainTextToken;
            $this->uploadImage($userCreateRequest, 'image', 'users', 'user_', 'upload_image', $user->id, 'App\Models\User');
            DB::commit();
            return (new UserResource($user))
                ->additional(['status' => 'Success', 'token' => $token])
                ->response()
                ->setStatusCode(201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'Failed', 'error' => $e->getMessage()], 416);
        }
    }

    public function login($userLoginRequest): JsonResponse
    {
        if (!Auth::attempt($userLoginRequest->only(['email', 'password']), $userLoginRequest->remember)) {
            return response()->json(['status' => 'failed', 'message' => 'Please check your credentials'], 403);
        }
        $user = $this->userModel->query()->where('email', $userLoginRequest->email)->first();
        $token = $user->createToken('user_token')->plainTextToken;
        return response()->json(['status' => 'Success', 'token' => $token], 200);
    }

    public function profile($user)
    {
        return (new UserResource($user))
            ->additional(['status' => 'success'])
            ->response()
            ->setStatusCode(200);
    }

    public function update($userUpdateRequest, $user)
    {
        DB::beginTransaction();
        try {
            $user->update([
                'name' => $userUpdateRequest->name,
                'email' => $userUpdateRequest->email,
                'password' => $userUpdateRequest->password ? Hash::make($userUpdateRequest->password) : $user->password,
            ]);
            $this->deleteImage($userUpdateRequest, 'image', $user->image->path, $user->image->id);
            $this->uploadImage($userUpdateRequest, 'image', 'users', 'user_', 'upload_image', $user->id, 'App\Models\User');
            DB::commit();
            return (new UserResource($user))
                ->additional(['status' => 'Success'])
                ->response()
                ->setStatusCode(201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'Failed', 'error' => $e->getMessage()], 416);
        }
    }

    public function logout(): JsonResponse
    {
        DB::beginTransaction();
        try {
            auth()->user()->tokens()->delete();
            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'User Logged out successfully'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'Failed', 'error' => $e->getMessage()], 416);
        }
    }
}
