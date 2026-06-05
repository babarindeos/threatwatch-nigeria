<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lga extends Model
{
    protected $fillable = ['state_id', 'name', 'slug', 'latitude', 'longitude'];

    protected function casts(): array
    {
        return [
            'latitude'  => 'float',
            'longitude' => 'float',
        ];
    }

    // ----------------------------------------------------------------
    // Relationships
    // ----------------------------------------------------------------

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function incidents(): HasMany
    {
        return $this->hasMany(Incident::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function helplines(): HasMany
    {
        return $this->hasMany(Helpline::class);
    }
}
