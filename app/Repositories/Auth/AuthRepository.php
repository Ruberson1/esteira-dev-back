<?php

namespace App\Repositories\Auth;



use App\Services\Auth\IAuthRepository;
use App\User;
use Illuminate\Support\Facades\Auth;


class AuthRepository implements IAuthRepository
{

    public function registerUser(object $request): \Illuminate\Http\JsonResponse
    {
        try {

            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = app('hash')->make($request->input('password'));

            $user->save();
            return response()->json(['error' => '','user' => $user, 'message' => 'CREATED', 'status_code' => 201],201);

        } catch (\Exception $e) {

            return response()->json(['error' => 'Email já cadastrado.', 'status_code' => 400], 400);
        }
    }

    public function loginUser(array $credentials)
    {
        Auth::factory()->setTTL(720);
        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['error' => 'Dados Incorretos.'], 403);
        }
        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => Auth::factory()->getTTL() * 60 * 60 * 4,
            'user' => \auth()->user()
        ], 200);
    }

    public function refresh()
    {
        $token = Auth::refresh();
        return $this->respondWithToken($token);
    }

}