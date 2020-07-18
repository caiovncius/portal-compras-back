<?php


namespace App\Traits\Models;


use App\Profile;

trait UserRelations
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function pharmacies()
    {
        return $this->belongsToMany(Pharmacy::class);
    }
}
