<?php

namespace App\Traits\Models;

use Illuminate\Database\Eloquent\Builder;

trait ProfileScopes
{
    /**
     * Get all profiles by type
     *
     * @param Builder $query
     * @param $type
     * @return Builder
     */
    public function scopeByType(Builder $query, $type)
    {
        return $query->where('type', $type);
    }
}
