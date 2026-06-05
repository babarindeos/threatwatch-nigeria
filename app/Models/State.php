<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    protected $fillable = ['name', 'slug', 'latitude', 'longitude'];

    protected function casts(): array
    {
        return [
            'latitude'  => 'float',
            'longitude' => 'float',
        ];
    }

    // ----------------------------------------------------------------
    // Route model binding by slug
    // ----------------------------------------------------------------

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // ----------------------------------------------------------------
    // Relationships
    // ----------------------------------------------------------------

    public function lgas(): HasMany
    {
        return $this->hasMany(Lga::class)->orderBy('name');
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

    // ----------------------------------------------------------------
    // Scopes
    // ----------------------------------------------------------------

    public function scopeWithIncidentCount($query)
    {
        return $query->withCount(['incidents' => fn ($q) => $q->where('status', 'approved')]);
    }
}
