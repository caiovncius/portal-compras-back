<?php


namespace App\Traits\Models;


use App\State;
use Illuminate\Database\Eloquent\Builder;

trait CityScopes
{
    /**
     * Get all cities by state
     *
     * @param Builder $query
     * @param State $state
     * @return Builder
     */
    public function scopeByState(Builder $query, State $state)
    {
        return $query->where('state_id', $state->id);
    }
}
