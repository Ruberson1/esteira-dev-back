<?php

namespace App\Http\Controllers\V1\Auth;

use App\Http\Controllers\V1\Auth\IAuthService;
use App\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Http\Redirector;
use Laravel\Lumen\Routing\Controller;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * @var \App\Http\Controllers\V1\Auth\IAuthService
     */
    private $service;

    public function __construct
    (
        IAuthService $service
    )
    {
        $this->service = $service;
    }

    public function register(Request $request)
    {
        return $this->service->register($request);
    }

    public function login(Request $request)
    {
        return $this->service->login($request);
    }

    public function refresh()
    {
       return $this->service->refresh();
    }

    public function logout()
    {
        auth()->logout();
        return ['error' => ''];
    }

    public function unauthorized()
    {
        return response()->json(['error' => 'Não Autorizado'], 401);
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->stateless()->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Redirector|RedirectResponse
     */
    public function handleProviderCallback($provider)
    {
        $providerUser = Socialite::driver($provider)->stateless()->user();

        $user = User::firstOrCreate(['email' => $providerUser->getEmail()], [
            "name" => $providerUser->getName() ?? $providerUser->getNickName(),
            "provider_id" => $providerUser->getId(),
            "provider" => $provider,
        ]);

        Auth::login($user);

        return redirect(env('URL_REDIRECIONAMENTO'));
    }

}
