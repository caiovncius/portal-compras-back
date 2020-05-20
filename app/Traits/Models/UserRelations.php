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
}
