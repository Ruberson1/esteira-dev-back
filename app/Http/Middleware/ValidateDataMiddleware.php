<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Class ValidateDataMiddleware
 * @package App\Http\Middleware
 */
class ValidateDataMiddleware
{
    public function handle(Request $request, \Closure $next)
    {
        $validation = $this->validate($request);

        if ($validation->fails()) {
            $response = [
                'status_code' => 400,
                'error' => true,
                'error_message' => 'Dados Inválidos',
                'error_description' => $validation->getMessageBag()
            ];

            return response()->json($response, 400);
        }

        return $next($request);
    }

    private function defineModel(string $namespace): ?Model
    {
        $model = null;

        if (class_exists($namespace)) {
            $model = new $namespace();
        }

        return $model;
    }

    private function validate(Request $request): \Illuminate\Contracts\Validation\Validator
    {
        $alias = $request->route()[1]['as'];
        $model = $this->defineModel($alias);

        if (empty($model)) {
            throw new \InvalidArgumentException('A model ' . $alias . ' não existe');
        }

        return Validator::make(
            $request->toArray(),
            $model->rules
        );
    }
}
