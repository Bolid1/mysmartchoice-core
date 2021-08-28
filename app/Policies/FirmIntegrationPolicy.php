<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Firm;
use App\Models\FirmIntegration;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FirmIntegrationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @param Firm $firm
     *
     * @return bool
     */
    public function viewAny(User $user, Firm $firm): bool
    {
        $firmId = $firm->id;

        return $user->noTokenOrTokenCan("view-firm-{$firmId}-firm_integrations")
               && $user->isInFirm($firmId);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param FirmIntegration $firmIntegration
     *
     * @return bool
     */
    public function view(User $user, FirmIntegration $firmIntegration): bool
    {
        $firmId = $firmIntegration->firm_id;

        return $user->noTokenOrTokenCan("view-firm-{$firmId}-firm_integrations")
               && $user->isInFirm($firmId);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @param Firm $firm
     *
     * @return bool
     */
    public function create(User $user, Firm $firm): bool
    {
        $firmId = $firm->id;

        return $user->noTokenOrTokenCan("create-firm-{$firmId}-firm_integrations")
               && $user->isInFirm($firmId);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User  $user
     * @param FirmIntegration  $firmIntegration
     *
     * @return bool
     */
    public function update(User $user, FirmIntegration $firmIntegration): bool
    {
        $firmId = $firmIntegration->firm_id;

        return $user->noTokenOrTokenCan("update-firm-{$firmId}-firm_integrations")
               && $user->isInFirm($firmId);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User  $user
     * @param FirmIntegration  $firmIntegration
     *
     * @return bool
     */
    public function delete(User $user, FirmIntegration $firmIntegration): bool
    {
        $firmId = $firmIntegration->firm_id;

        return $user->noTokenOrTokenCan("delete-firm-{$firmId}-firm_integrations")
               && $user->isInFirm($firmId);
    }
}
