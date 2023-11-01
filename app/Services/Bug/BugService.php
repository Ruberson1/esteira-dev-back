<?php

declare(strict_types=1);

namespace App\Services\Bug;

use App\Http\Resources\Bug\BugResource;
use App\Services\AbstractService;
use App\Services\BugImage\BugImageService;
use Illuminate\Http\Request;

/**
 * Class BugService
 * @package App\Services\Bug
 */
class BugService extends AbstractService
{

    public function findBugsDashImp()
    {
        return $this->repository->findBugsDash();
    }

    /**
     * @param Request $request
     * @return array
     */
    public function createBug(Request $request): array
    {
        $bug = $this->repository->create($request->all());
        $files = $request->file('files');
        if ($files) {
            $bugImageService = new BugImageService;
            $bugImageService->uploadImage($request, $bug['id'], $files);
        }
        return $bug;
    }

    /**
     * @param int $userId
     * @param int $limit
     * @param array $orderBy
     * @return array
     */
    public function findByUser(int $userId, int $limit = 10, $orderBy = []): array
    {
        return $this->repository->findByUser($userId, $limit, $orderBy);
    }

    /**
     * @param int $taskId
     * @param int $limit
     * @param array $orderBy
     * @return array
     */
    public function findByTask(int $taskId, int $limit = 10, $orderBy = []): array
    {
        return $this->repository->findByTask($taskId, $limit, $orderBy);
    }

    /**
     * @param string $param
     * @return array
     */
    public function findBy(string $param): array
    {
        return $this->repository->findBy($param);
    }

    /**
     * @param int $taskId
     * @return bool
     */
    public function deleteByTask(int $taskId): bool
    {
        return $this->repository->deleteByTask($taskId);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteBug(int $id): bool
    {
        $bugImageService = new BugImageService;
        $image = $bugImageService->findByBug($id);
        foreach ($image as $img) {
            $bugImageService->deleteImage($img->id);
        }
        return $this->repository->delete($id);
    }
}
