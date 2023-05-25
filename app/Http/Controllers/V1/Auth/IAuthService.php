<?php

namespace App\Http\Controllers\V1\Auth;

interface IAuthService
{
    public function register(object $request);

    public function login(object $request);

    public function refresh();
}