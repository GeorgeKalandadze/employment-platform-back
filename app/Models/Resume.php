<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Resume extends Model
{
    protected $fillable = [
        'file_path',
        'vacancy_id',
        'user_id',
        'resume',
        'first_name',
        'last_name',
        'email',
        'phone',
    ];

    use HasFactory;

    public function vacancy(): BelongsTo
    {
        return $this->belongsTo(Vacancy::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
