<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class SocialNetwork extends Model
{
    
    public function companies(): MorphTo
    {
        return $this->belongsTo(Company::class);
    }
}
