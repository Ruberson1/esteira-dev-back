<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1\Status;

use App\Http\Controllers\AbstractController;
use App\Services\Status\StatusService;

/**
 * Class StatusController
 * @package App\Http\Controllers\V1\Status
 */
class StatusController extends AbstractController
{
    /**
     * StatusController constructor.
     * @param StatusService $status
     */
    public function __construct(StatusService $status)
    {
        parent::__construct($status);
    }
}
