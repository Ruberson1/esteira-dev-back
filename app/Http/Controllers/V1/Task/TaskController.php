<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Task;

use App\Helpers\OrderByHelper;
use App\Http\Controllers\AbstractController;
use App\Http\Resources\Task\TaskResource;
use App\Models\Task\Task;
use App\Services\Task\TaskService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

/**
 * Class TaskController
 * @package App\Http\Controllers\V1\Task
 */
class TaskController extends AbstractController
{
    /**
     * @var array
     */
    protected array $searchFields = [];

    /**
     * TaskController constructor.
     * @param TaskService $task
     */
    public function __construct(TaskService $task)
    {
        parent::__construct($task);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        try {
            $result = $this->service->createTask($request);
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

            $searchString = $request->get('q', '');

            if (!empty($searchString)) {
                $result = $this->service->searchBy(
                    $searchString,
                    $this->searchFields,
                    $limit,
                    $orderBy
                );
            } else {
                $result = $this->service->findByUser($user, $limit, $orderBy);
            }

            $response = $this->successResponse($result, Response::HTTP_PARTIAL_CONTENT);
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
    public function findById(Request $request, int $id): JsonResponse
    {
        try {
            $limit = (int) $request->get('limit', 10);
            $orderBy = $request->get('order_by', []);

            if (!empty($orderBy)) {
                $orderBy = OrderByHelper::treatOrderBy($orderBy);
            }

            $searchString = $request->get('q', '');

            if (!empty($searchString)) {
                $result = $this->service->searchBy(
                    $searchString,
                    $this->searchFields,
                    $limit,
                    $orderBy
                );
            } else {
                $result = $this->service->findByIdImp($id, $limit, $orderBy);
            }

            $response = $this->successResponse($result, Response::HTTP_PARTIAL_CONTENT);
        } catch (Exception $e) {
            $response = $this->errorResponse($e);
        }

        return response()->json($response, $response['status_code']);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function findAllTasks(Request $request): JsonResponse
    {
        $filters = $request->query();
        try {
            $limit = (int) $request->get('limit', 10);
            $orderBy = $request->get('order_by', []);

            if (!empty($orderBy)) {
                $orderBy = OrderByHelper::treatOrderBy($orderBy);
            }

            $searchString = $request->get('q', '');

            if (!empty($searchString)) {
                $result = $this->service->searchBy(
                    $searchString,
                    $this->searchFields,
                    $limit,
                    $orderBy
                );
            } else {
                $result = $this->service->findAllTasksImp($limit, $orderBy, $filters);
            }

            $response = $this->successResponse($result, Response::HTTP_PARTIAL_CONTENT);
        } catch (Exception $e) {
            $response = $this->errorResponse($e);
        }

        return response()->json($response, $response['status_code']);
    }


    public function findAllStatus(Request $request): JsonResponse
    {
        try {
            $result = $this->service->findAllStatusImp();
            $response = $this->successResponse($result, Response::HTTP_OK);
        } catch (Exception $e) {
            $response = $this->errorResponse($e);
        }

        return response()->json($response, $response['status_code']);
    }

    public function findAllPeriod(Request $request): JsonResponse
    {
        try {
            $result = $this->service->findAllPeriodImp();
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
    public function update(Request $request): JsonResponse
    {
        try {
            $result['registro_alterado'] = $this->service->update($request);
            $response = $this->successResponse($result);
        } catch (Exception $e) {
            $response = $this->errorResponse($e);
        }

        return response()->json($response, $response['status_code']);
    }

}
