<?php


namespace App\Traits\Models;


use App\Profile;

trait FunctionalityRelations
{
    public function profiles()
    {
        return $this->belongsToMany(Profile::class, 'profile_functionalities', 'functionality_id')
            ->withPivot('access_type');
    }
}
