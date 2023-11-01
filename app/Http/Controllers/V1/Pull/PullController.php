<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Pull;

use App\Helpers\OrderByHelper;
use App\Http\Controllers\AbstractController;
use App\Services\Pull\PullService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class PullController
 * @package App\Http\Controllers\V1\Pull
 */
class PullController extends AbstractController
{
    /**
     * @var array
     */
    protected array $searchFields = [];

    /**
     * PullController constructor.
     * @param PullService $pull
     */
    public function __construct(PullService $pull)
    {
        parent::__construct($pull);
    }

    /**
     * @param Request $request
     * @param int $user
     * @return JsonResponse
     */
    public function findByUser(Request $request, int $user): JsonResponse
    {
        try {
            $limit = (int) $request->get('limit', 10);
            $orderBy = $request->get('order_by', []);

            if (!empty($orderBy)) {
                $orderBy = OrderByHelper::treatOrderBy($orderBy);
            }

            $result = $this->service->findByUser($user, $limit, $orderBy);

            $response = $this->successResponse($result, Response::HTTP_PARTIAL_CONTENT);
        } catch (Exception $e) {
            $response = $this->errorResponse($e);
        }

        return response()->json($response, $response['status_code']);
    }

    /**
     * @param Request $request
     * @param int $statusId
     * @return JsonResponse
     */
    public function findByStatus(Request $request, int $statusId): JsonResponse
    {
        try {
            $limit = (int) $request->get('limit', 10);
            $orderBy = $request->get('order_by', []);

            if (!empty($orderBy)) {
                $orderBy = OrderByHelper::treatOrderBy($orderBy);
            }

            $result = $this->service->findByStatusImp($statusId, $limit, $orderBy);

            $response = $this->successResponse($result, Response::HTTP_PARTIAL_CONTENT);
        } catch (Exception $e) {
            $response = $this->errorResponse($e);
        }

        return response()->json($response, $response['status_code']);
    }

}
