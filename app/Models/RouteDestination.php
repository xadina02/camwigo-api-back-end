<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class RouteDestination extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $guarded = ['id'];
    protected $translatable = ['destination'];

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }

    public function routeSchedules(): HasMany
    {
        return $this->hasMany(RouteSchedule::class);
    }
}
