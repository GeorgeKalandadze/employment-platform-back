<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialNetwork extends Model
{
    

    public function companies(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
