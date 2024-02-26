<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Str;

class Vacancy extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_category_id',
        'title',
        'description',
        'salary',
        'job_type_id',
        'experience_years',
        'slug',
        'vacancyable_id',
        'vacancyable_type',
    ];

    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function vacancyable(): MorphTo
    {
        return $this->morphTo();
    }

    public function jobType(): BelongsTo
    {
        return $this->belongsTo(JobType::class);
    }

    public function favorites(): MorphMany
    {
        return $this->morphMany(Favorite::class, 'favoritable');
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($vacancy) {
            $slug = Str::random(24);
            $vacancy->slug = $slug . '-' . Str::slug($vacancy->title);
        });
    }
}
