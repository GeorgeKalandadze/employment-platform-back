<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'logo',
        'address',
        'mobile_number',
        'email',
        'website',
        'description',
    ];

    public function vacancies(): MorphMany
    {
        return $this->morphMany(Vacancy::class, 'vacancyable');
    }

    public function courses(): MorphMany
    {
        return $this->morphMany(Course::class, 'courseable');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
