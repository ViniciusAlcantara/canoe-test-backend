<?php

namespace App\Listeners;

use App\Actions\HandleDuplicateFundsAction;
use App\Events\DuplicatedFundWarningEvent;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class DuplicatedFundWarningListener
{
    /**
     * Create the event listener.
     */
    public function __construct(private HandleDuplicateFundsAction $handleDuplicateFundsAction)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(DuplicatedFundWarningEvent $event): void
    {
        $duplicates = json_decode($event->data);

        $this->handleDuplicateFundsAction->execute($duplicates);
    }
}
