<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Integration;
use Illuminate\Database\Eloquent\Builder;

class IntegrationsRepository
{
    private Integration $model;

    /**
     * @param Integration $model
     */
    public function __construct(Integration $model)
    {
        $this->model = $model;
    }

    /**
     * @param int $userId
     *
     * @return Integration|Builder
     */
    public function getAvailableFor(int $userId): Integration|Builder
    {
        return $this->model::where('owner_id', $userId)
                           ->orWhere('status', Integration::STATUS_AVAILABLE);
    }
}
