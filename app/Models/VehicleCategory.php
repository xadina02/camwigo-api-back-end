<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class VehicleCategory extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $guarded = ['id'];
    protected $translatable = ['name'];

    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }
}
