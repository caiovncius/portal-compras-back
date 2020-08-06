<?php


namespace App\Traits\Models;


use App\Functionality;
use App\User;

trait ProfileRelations
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'updated_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function functionalities()
    {
        return $this->belongsToMany(Functionality::class, 'profile_functionalities', 'profile_id')
            ->withPivot('access_type');
    }
}
