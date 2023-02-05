<?php

namespace App\Repository;

use App\Models\Lead;

class LeadRepository
{
    public function updateOrCreate(Lead $lead): void {
        if (Lead::where('id', $lead->id)->exists()) {
            $lead->exists = true;
        }

        $lead->save();
    }
}
