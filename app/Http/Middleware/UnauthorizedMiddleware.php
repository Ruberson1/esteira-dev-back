<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\User;

class UnauthorizedMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->profile->id != env('USER_PROFILE_MASTER') && $request->path() == 'api/v1/bug') {
            $user = $request->user();
            $unauthorizedAttempts = $user->unauthorized ?? 0;

            // Atualiza o número de tentativas não autorizadas
            $user->unauthorized = ++$unauthorizedAttempts;
            $user->save();

            // Verifica se o número de tentativas não autorizadas é maior ou igual a 3
            if ($unauthorizedAttempts > 3) {
                // Atualiza o campo "active" para falso e exibe a mensagem de inatividade
                $user->active = false;
                $user->save();
                return response()->json(['message' => 'Seu perfil foi inativado por uso inapropriado do sistema'], 403);
            }
            // Exibe a mensagem de tentativa não autorizada
            return response()->json(['message' => 'Seu perfil não pode acessar esta página. Tentativa '.$user->unauthorized.', Após 3 tentativas seu acesso será inativado'], 403);
        }

        return $next($request);
    }
}
