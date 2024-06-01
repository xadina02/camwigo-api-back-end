<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Route extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $guarded = ['id'];
    protected $translatable = ['origin'];

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }

    public function routeSchedules(): HasMany
    {
        return $this->hasMany(RouteSchedule::class);
    }

    public function routeDestinations(): HasMany
    {
        return $this->hasMany(RouteDestination::class);
    }
}
