<?php

namespace App\Services\Auth;

use App\Http\Controllers\V1\Auth\IAuthService;
use App\Services\Auth\IAuthRepository;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;


class AuthService implements IAuthService
{
    private \App\Services\Auth\IAuthRepository $repository;

    public function __construct
    (
        IAuthRepository $repository
    )
    {
        $this->repository = $repository;
    }

    public function register(object $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:2|max:20',
            'email' => 'required|email|max:100|email:rfc,dns',
            'password' => 'required|between:6,12',
        ]);

        if (!$validator->fails()) {
            $response = response()->json($this->repository->registerUser(request()));

            if ($response->getData()->original->status_code !== 201) {
                return response()->json($this->repository->registerUser(request()), 400);
            } else {
                return $response;
            }
        } else {
            return response()->json(['message' => $validator->errors()->first()], 401);
        }
    }

    /**
     * @param object $request
     * @return JsonResponse
     * @throws AuthenticationException
     */
    public function login(object $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:100|email:rfc,dns',
            'password' => 'required|between:6,12'
        ]);

        if (!$validator->fails()) {
            $credentials = $request->only(['email', 'password']);
            $response = response()->json($this->repository->loginUser($credentials));
            if($response->original->getStatusCode() === 200){
                return $response;
            } else {
                return response()->json($this->repository->loginUser($credentials), 403);
            }
        } else {
            return response()->json(['message' => $validator->errors()->first()], 401);
        }
    }

    public function refresh()
    {
        return $this->repository->refresh();
    }
}