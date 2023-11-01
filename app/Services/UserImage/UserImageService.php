<?php

namespace App\Services\UserImage;

use App\Models\UserImage\UserImage;
use Illuminate\Http\Request;
use Aws\S3\S3Client;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UserImageService
{
    public function uploadImage(Request $request)
    {
        $file = $request->file('file');
        $userId = $request->user_id;

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
            'Key' => env('FILE_PATH_USER').$userId.'/'.$fileName,
            'Body' => file_get_contents($file),
            'ACL' => env('AWS_PERMISSAO_ENVIO')
        ]);

        $url = $s3->getObjectUrl(env('AWS_NOME_BUCKET'), $fileName);

        $userImage = new UserImage;
        $userImage->user_id = $userId;
        $userImage->path = env('FILE_PATH_USER').$userId.'/'.$fileName;
        $userImage->register_date = Carbon::now();
        $userImage->save();

        return [
            'url' => $url,
            'user_image' => $userImage
        ];

    }

    public function getImage($id)
    {
        $userImage = UserImage::where('user_id', $id)->firstOrFail();
        if (!$userImage) {
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
        $url = $s3->getObjectUrl(env('AWS_NOME_BUCKET'), $userImage->path);

        return [
            'url' => $url,
            'user_image' => $userImage
        ];
    }

    public function updateImage(Request $request, $userId)
    {
        $file = $request->file('file');
        $userImage = UserImage::where('user_id', $userId)->firstOrFail();


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
            'Key' => $userImage->path
        ]);

        $fileName = uniqid('', true) . '.' . $file->getClientOriginalExtension();
        $s3->putObject([
            'Bucket' => env('AWS_NOME_BUCKET'),
            'Key' => env('FILE_PATH_USER').$userImage->user_id.'/'.$fileName,
            'Body' => file_get_contents($file),
            'ACL' => env('AWS_PERMISSAO_ENVIO')
        ]);
        $url = $s3->getObjectUrl(env('AWS_NOME_BUCKET'), $fileName);

        $userImage->path = env('FILE_PATH_USER').$userImage->user_id.'/'.$fileName;
        $userImage->save();
        return [
            'url' => $url,
            'user_image' => $userImage
        ];
    }

    public function deleteImage($id)
    {
        $userImage = UserImage::findOrFail($id);
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
            'Key' => $userImage->path
        ]);
        $userImage->delete();

        return ['message' => 'Image deleted successfully.'];
    }

    /**
     * @param int $userId
     * @param int $limit
     * @param array $orderBy
     * @return Collection
     */
    public function findByUser(int $userId, int $limit = 10, array $orderBy = []): Collection
    {
        return  DB::table('user_image')->where('user_id', $userId)->get();
    }
}
