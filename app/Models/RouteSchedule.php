<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RouteSchedule extends Model
{
    use HasFactory;
    // Install a translate package and add the translatable trait here

    protected $guarded = ['id'];
    protected $translatable = ['label'];

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }
}
