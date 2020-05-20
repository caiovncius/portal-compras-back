<?php


namespace App\Traits\Models;


use Illuminate\Database\Eloquent\Builder;

trait StateScopes
{
    /**
     * Get all states
     *
     * @param Builder $query
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function scopeAllStates(Builder $query)
    {
        return $query->get();
    }
}
