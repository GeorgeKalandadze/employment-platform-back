<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialNetwork extends Model
{
    protected $fillable = ['company_id', 'link'];

    public function companies(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
