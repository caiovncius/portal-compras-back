<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Builder;

trait LaboratoryScopes
{
    /**
     * Get all laboratories active
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive(Builder $query)
    {
        return $query->where('status', 'ACTIVE');
    }
}
