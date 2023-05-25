<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\History;

use App\Helpers\OrderByHelper;
use App\Http\Controllers\AbstractController;
use App\Http\Resources\History\HistoryResource;
use App\Models\History\History;
use App\Services\History\HistoryService;
use Illuminate\Http\JsonResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class HistoryController
 * @package App\Http\Controllers\V1\History
 */
class HistoryController extends AbstractController
{
    /**
     * HistoryController constructor.
     * @param HistoryService $History
     */
    public function __construct(HistoryService $History)
    {
        parent::__construct($History);
    }

    /**
     * @param Request $request
     * @param int $task
     * @return JsonResponse
     */
    public function findByTask(Request $request, int $task): JsonResponse
    {
        try {
            $limit = (int) $request->get('limit', 10);
            $orderBy = $request->get('order_by', []);

            if (!empty($orderBy)) {
                $orderBy = OrderByHelper::treatOrderBy($orderBy);
            }

            $result = $this->service->findByTask($task, $limit, $orderBy);

            $response = $this->successResponse($result, Response::HTTP_PARTIAL_CONTENT);
        } catch (Exception $e) {
            $response = $this->errorResponse($e);
        }

        return response()->json($response, $response['status_code']);
    }
}
