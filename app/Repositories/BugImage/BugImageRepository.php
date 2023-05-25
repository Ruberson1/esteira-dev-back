<?php
namespace App\Repositories\BugImage;

use App\Models\BugImage\BugImage;

class BugImageRepository
{
    public function save($bugId, $path)
    {
        return BugImage::create([
            'bug_id' => $bugId,
            'path' => $path,
        ]);
    }
}