<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Firm;

class FirmObserver
{
    /**
     * Handle the Firm "deleted" event.
     *
     * @param Firm  $firm
     *
     * @return void
     */
    public function deleted(Firm $firm): void
    {
        $firm->accounts()->forceDelete();
        $firm->usersLinks()->forceDelete();
    }

    /**
     * Handle the Firm "force deleted" event.
     *
     * @param  Firm  $firm
     *
     * @return void
     */
    public function forceDeleted(Firm $firm): void
    {
        $this->deleted($firm);
    }
}
