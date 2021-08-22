<?php

declare(strict_types=1);

namespace App\Managers;

use App\Models\FirmIntegration;

class FirmIntegrationsManager
{
    public function install(int $firmId, int $integrationId): FirmIntegration
    {
        $firmIntegration = new FirmIntegration();

        $firmIntegration->firm()->associate($firmId);
        $firmIntegration->integration()->associate($integrationId);
        $firmIntegration->status = FirmIntegration::STATUS_INSTALLED;

        return $firmIntegration;
    }
}
