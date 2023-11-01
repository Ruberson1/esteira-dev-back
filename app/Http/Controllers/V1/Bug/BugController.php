<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Bug;

use App\Helpers\OrderByHelper;
use App\Http\Controllers\AbstractController;
use App\Models\Bug\Bug;
use App\Services\Bug\BugService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
/**
 * Class BugController
 * @package App\Http\Controllers\V1\Bug
 */
class BugController extends AbstractController
{
    /**
     * @var array|string[]
     */
    protected array $searchFields = [
        'title',
        'slug'
    ];

    /**
     * BugController constructor.
     * @param BugService $bug
     */
    public function __construct(BugService $bug)
    {
        parent::__construct($bug);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function findBugsDash(Request $request): JsonResponse
    {
        try {
            $result = $this->service->findBugsDashImp();
            $response = $this->successResponse($result, Response::HTTP_OK);
        } catch (Exception $e) {
            $response = $this->errorResponse($e);
        }

        return response()->json($response, $response['status_code']);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        try {
            $result = $this->service->createBug($request);
            $response = $this->successResponse($result, Response::HTTP_CREATED);
        } catch (Exception $e) {
            $response = $this->errorResponse($e);
        }
        return response()->json($response, $response['status_code']);
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

    /**
     * @param Request $request
     * @param string $param
     * @return JsonResponse
     */
    public function findBy(Request $request, string $param): JsonResponse
    {
        try {
            $result = $this->service->findBy($param);
            $response = new Bug();
            $response->status_code = Response::HTTP_OK;
            $response->data = $result;
        } catch (Exception $e) {
            $response = $this->errorResponse($e);
        }

        return response()->json($response, $response['status_code']);
    }

    /**
     * @param Request $request
     * @param int $task
     * @return JsonResponse
     */
    public function deleteByTask(Request $request, int $task): JsonResponse
    {
        try {
            $result['deletado'] = $this->service->deleteByTask($task);
            $response = $this->successResponse($result);
        } catch (Exception $e) {
            $response = $this->errorResponse($e);
        }

        return response()->json($response, $response['status_code']);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function deleteBug(Request $request, int $id): JsonResponse
    {
        try {
            $result['registro_deletado'] = $this->service->deleteBug($id);
            $response = $this->successResponse($result);
        } catch (Exception $e) {
            $response = $this->errorResponse($e);
        }

        return response()->json($response, $response['status_code']);
    }
}
