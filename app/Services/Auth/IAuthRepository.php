<?php

namespace App\Services\Auth;

interface IAuthRepository
{
    public function registerUser(object $request);

    public function loginUser(array $credentials);

    public function refresh();
}