<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    public function routeDestination(): BelongsTo
    {
        return $this->belongsTo(RouteDestination::class);
    }

    public function routeSchedule(): BelongsTo
    {
        return $this->belongsTo(RouteSchedule::class);
    }
}
