<?php


namespace App\Traits\Models;


use App\City;

trait StateRelations
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
