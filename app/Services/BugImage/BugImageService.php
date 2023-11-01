<?php

namespace App\Services\BugImage;

use App\Models\BugImage\BugImage;
use Illuminate\Http\Request;
use Aws\S3\S3Client;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class BugImageService
{
    public function uploadImage(Request $request, $bugId, $files)
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
                'Key' => env('FILE_PATH_BUG').$bugId.'/'.$fileName,
                'Body' => file_get_contents($file),
                'ACL' => env('AWS_PERMISSAO_ENVIO')
            ]);
            $bugImage = new BugImage;
            $bugImage->bug_id = $bugId;
            $bugImage->path = env('FILE_PATH_BUG').$bugId.'/'.$fileName;
            $bugImage->register_date = Carbon::now();
            $bugImage->save();
        }
    }

    public function getImage($id)
    {
        $bugImage = BugImage::find($id);
        if (!$bugImage) {
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
        $url = $s3->getObjectUrl(env('AWS_NOME_BUCKET'), $bugImage->path);

        return [
            'url' => $url,
            'bug_image' => $bugImage
        ];
    }

    public function updateImage(Request $request, $id)
    {
        $bugImage = BugImage::where('task_id', $id);
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
            'Key' => $bugImage->path
        ]);
        $file = $request->file('files');
        $fileName = uniqid('', true) . '.' . $file->getClientOriginalExtension();
        $s3->putObject([
            'Bucket' => env('AWS_NOME_BUCKET'),
            'Key' => env('FILE_PATH_BUG').$bugImage->bug_id.'/'.$fileName,
            'Body' => file_get_contents($file),
            'ACL' => env('AWS_PERMISSAO_ENVIO')
        ]);
        $url = $s3->getObjectUrl(env('AWS_NOME_BUCKET'), $fileName);
        $bugImage->path = env('FILE_PATH_BUG').$bugImage->bug_id.'/'.$fileName;
        $bugImage->save();
        return [
            'url' => $url,
            'bug_image' => $bugImage
        ];
    }

    public function deleteImage($id)
    {
        $bugImage = BugImage::findOrFail($id);
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
            'Key' => $bugImage->path
        ]);
        $bugImage->delete();

        return ['message' => 'Image deleted successfully.'];
    }

    /**
     * @param int $bugId
     * @param int $limit
     * @param array $orderBy
     * @return Collection
     */
    public function findByBug(int $bugId, int $limit = 10, array $orderBy = []): Collection
    {
        return  DB::table('bug_image')->where('bug_id', $bugId)->get();
    }
}
