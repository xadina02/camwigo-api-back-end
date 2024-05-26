<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Translatable\HasTranslations;

class RouteSchedule extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $guarded = ['id'];
    protected $translatable = ['label'];

    public function route(): BelongsTo
    {
        return $this->belongsTo(Route::class);
    }
}
