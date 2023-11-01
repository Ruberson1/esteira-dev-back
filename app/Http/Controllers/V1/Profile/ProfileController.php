<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Profile;

use App\Http\Controllers\AbstractController;
use App\Services\Profile\ProfileService;

/**
 * Class ProfileController
 * @package App\Http\Controllers\V1\Profile
 */
class ProfileController extends AbstractController
{
    /**
     * ProfileController constructor.
     * @param ProfileService $profile
     */
    public function __construct(ProfileService $profile)
    {
        parent::__construct($profile);
    }
}
