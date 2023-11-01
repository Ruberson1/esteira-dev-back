<?php

namespace App\Http\Controllers\V1\UserImage;

use App\Helpers\OrderByHelper;
use App\Services\UserImage\UserImageService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller as BaseController;


class UserImageController extends BaseController
{
    protected $UserImageService;

    public function __construct(UserImageService $userImageService)
    {
        $this->userImageService = $userImageService;
    }

    public function uploadImage(Request $request)
    {
        $image = $this->userImageService->uploadImage($request);
        return response()->json($image);
    }

    public function getImage($id)
    {
        $image = $this->userImageService->getImage($id);
        return response()->json($image);
    }

    public function updateImage(Request $request, $id)
    {

        $image = $this->userImageService->updateImage($request, $id);
        return response()->json($image);
    }

    public function deleteImage($id)
    {
        $this->userImageService->deleteImage($id);
        return response()->json(['message' => 'Image deleted successfully.']);
    }

    /**
     * @param Request $request
     * @param int $user
     * @return JsonResponse
     */
    public function findByuser(Request $request, int $user): JsonResponse
    {
        try {
            $limit = (int) $request->get('limit', 10);
            $orderBy = $request->get('order_by', []);

            if (!empty($orderBy)) {
                $orderBy = OrderByHelper::treatOrderBy($orderBy);
            }

            $result = $this->userImageService->findByUser($user, $limit, $orderBy);

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

