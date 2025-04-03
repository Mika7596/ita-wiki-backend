<?php

declare (strict_types= 1);

namespace App\Observers;

use App\Models\Like;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class LikeObserver
{
    /**
     * Handle the Like "created" event.
     */
    public function created(Like $like): void
    {
        //
    }

    /**
     * Handle the Like "deleted" event.
     */
    public function deleted(Like $like): void
    {
        //
    }
}
