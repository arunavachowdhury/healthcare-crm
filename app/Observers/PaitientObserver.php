<?php

declare(strict_types=1);

namespace App\Observers;

use App\Models\Paitient;
use App\Models\PaitientAudit;
use Illuminate\Support\Facades\Auth;

final class PaitientObserver
{
    /**
     * Handle the Paitient "created" event.
     */
    public function created(Paitient $paitient): void {
        $oldValues = $paitient->getOriginal();

        $newValues = $paitient->getDirty();

        // Save to your audit table
        PaitientAudit::create([
            'user_id' => Auth::id(),
            'paitient_id' => $paitient->id,
            'action' => 'created',
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(), // optional
        ]);
    }

    public function saving(Paitient $paitient): void {}

    public function saved(Paitient $paitient): void {}

    /**
     * Handle the Paitient "updated" event.
     */
    public function updated(Paitient $paitient): void {
        $oldValues = $paitient->getOriginal();

        $newValues = $paitient->getDirty();

        // Save to your audit table
        PaitientAudit::create([
            'user_id' => Auth::id(),
            'paitient_id' => $paitient->id,
            'action' => 'updated',
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(), // optional
        ]);
    }

    /**
     * Handle the Paitient "deleted" event.
     */
    public function deleted(Paitient $paitient): void {
        //
    }

    /**
     * Handle the Paitient "restored" event.
     */
    public function restored(Paitient $paitient): void {
        //
    }

    /**
     * Handle the Paitient "force deleted" event.
     */
    public function forceDeleted(Paitient $paitient): void {
        //
    }
}
