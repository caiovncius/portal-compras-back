<?php


namespace App\Traits\Models;


use App\State;

trait CityRelations
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
