<?php

namespace App\Http\Controllers\V1\BugImage;

use App\Helpers\OrderByHelper;
use App\Services\BugImage\BugImageService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;


class BugImageController extends BaseController
{
    protected $bugImageService;

    public function __construct(BugImageService $bugImageService)
    {
        $this->bugImageService = $bugImageService;
    }

    public function uploadImage(Request $request, $bugId)
    {
        $image = $this->bugImageService->uploadImage($request, $bugId);
        return response()->json($image);
    }

    public function getImage($id)
    {
        $image = $this->bugImageService->getImage($id);
        return response()->json($image);
    }

    public function updateImage(Request $request, $id)
    {
        $image = $this->bugImageService->updateImage($request, $id);
        return response()->json($image);
    }

    public function deleteImage($id)
    {
        $this->bugImageService->deleteImage($id);
        return response()->json(['message' => 'Image deleted successfully.']);
    }

    /**
     * @param Request $request
     * @param int $bug
     * @return JsonResponse
     */
    public function findByBug(Request $request, int $bug): JsonResponse
    {
        try {
            $limit = (int) $request->get('limit', 10);
            $orderBy = $request->get('order_by', []);

            if (!empty($orderBy)) {
                $orderBy = OrderByHelper::treatOrderBy($orderBy);
            }

            $result = $this->bugImageService->findByBug($bug, $limit, $orderBy);

            $response = $this->successResponse($result, Response::HTTP_PARTIAL_CONTENT);
        } catch (Exception $e) {
            $response = $this->errorResponse($e);
        }

        return response()->json($response, $response['status_code']);
    }

    /**
     * @param array $data
     * @param int $statusCode
     * @return array
     */
    protected function successResponse(array $data, int $statusCode = Response::HTTP_OK)
    {
        return [
            'status_code' => $statusCode,
            'data' => $data
        ];
    }

    /**
     * @param Exception $e
     * @param int $statuCode
     * @return array
     */
    protected function errorResponse(Exception $e, int $statuCode = Response::HTTP_BAD_REQUEST): array
    {
        return [
            'status_code' => $statuCode,
            'error' => true,
            'error_description' => $e->getMessage()
        ];
    }
}

