<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Route extends Model
{
    use HasFactory;
    // Install a translate package and add the translatable trait here

    protected $guarded = ['id'];
    protected $translatable = ['origin', 'destination'];

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }

    public function routeSchedules(): HasMany
    {
        return $this->hasMany(RouteSchedule::class);
    }
}
