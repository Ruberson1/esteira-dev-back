<?php
declare(strict_types=1);

namespace App\Http\Controllers\V1\User;

use App\Http\Controllers\AbstractController;
use App\Services\User\UserService;
use App\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class UserController
 * @package App\Http\Controllers\V1\User
 */
class UserController extends AbstractController
{
    /**
     * StatusController constructor.
     * @param UserService $service
     */
    public function __construct(UserService $service)
    {
        parent::__construct($service);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function findOneBy(Request $request, int $id): JsonResponse
    {
        try {

            $result = $this->service->findOneBy($id);
            $response = $this->successResponse($result);
        } catch (Exception $e) {
            $response = $this->errorResponse($e);
        }

        return response()->json($response, $response['status_code']);
    }

    /**
     * Write code on Method
     *
     * @return JsonResponse()
     */
    public function saveToken(Request $request)
    {
        try {
            $result = $this->service->saveToken($request);
            $response = $this->successResponse($result);
        } catch (Exception $e) {
            $response = $this->errorResponse($e);
        }
        return response()->json($response, $response['status_code']);
    }

}