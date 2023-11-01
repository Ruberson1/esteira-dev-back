<?php

namespace App\Services\TaskImage;

use App\Models\TaskImage\TaskImage;
use Illuminate\Http\Request;
use Aws\S3\S3Client;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class TaskImageService
{
    public function uploadImage($taskId, $files)
    {

        foreach ($files as $file) {
            $fileName = uniqid('', true) . '.' . $file->getClientOriginalExtension();

            $s3 = new S3Client([
                'version' => env('AWS_VERSION'),
                'region' => env('AWS_REGION'),
                'credentials' => [
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
            ]);

            $s3->putObject([
                'Bucket' => env('AWS_NOME_BUCKET'),
                'Key' => env('FILE_PATH_TASK').$taskId.'/'.$fileName,
                'Body' => file_get_contents($file),
                'ACL' => env('AWS_PERMISSAO_ENVIO')
            ]);

            $taskImage = new TaskImage;
            $taskImage->task_id = $taskId;
            $taskImage->path = env('FILE_PATH_TASK').$taskId.'/'.$fileName;
            $taskImage->register_date = Carbon::now();
            $taskImage->save();
        }
    }

    public function getImage($id)
    {
        $taskImage = TaskImage::find($id);
        if (!$taskImage) {
            return response()->json(['error' => 'Imagem não encontrada'], 404);
        }

        // Recupera a URL da imagem do S3
        $s3 = new S3Client([
            'version' => env('AWS_VERSION'),
            'region' => env('AWS_REGION'),
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);
        $url = $s3->getObjectUrl(env('AWS_NOME_BUCKET'), $taskImage->path);

        return [
            'url' => $url,
            'task_image' => $taskImage
        ];
    }

    public function updateImage(Request $request, $id)
    {
        $taskImages = TaskImage::where('task_id', $id)->get();
        $files = $request->file('files');
        foreach ($taskImages as $taskImage) {
            $s3 = new S3Client([
                'version' => env('AWS_VERSION'),
                'region' => env('AWS_REGION'),
                'credentials' => [
                    'key' => env('AWS_ACCESS_KEY_ID'),
                    'secret' => env('AWS_SECRET_ACCESS_KEY'),
                ],
            ]);
            $s3->deleteObject([
                'Bucket' => env('AWS_NOME_BUCKET'),
                'Key' => $taskImage->path
            ]);
            $taskImage->delete();
        }

        $this->uploadImage($id, $files);
    }

    public function deleteImage($id)
    {
        $taskImage = TaskImage::findOrFail($id);
        $s3 = new S3Client([
            'version' => env('AWS_VERSION'),
            'region' => env('AWS_REGION'),
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
        ]);
        $s3->deleteObject([
            'Bucket' => env('AWS_NOME_BUCKET'),
            'Key' => $taskImage->path
        ]);
        $taskImage->delete();

        return ['message' => 'Image deleted successfully.'];
    }

    /**
     * @param int $taskId
     * @param int $limit
     * @param array $orderBy
     * @return Collection
     */
    public function findBytask(int $taskId, int $limit = 10, array $orderBy = []): Collection
    {
        return  DB::table('task_image')->where('task_id', $taskId)->get();
    }
}
