<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Helpline extends Model
{
    protected $fillable = [
        'state_id', 'lga_id', 'agency_name', 'phone', 'phone_alt',
        'category', 'address', 'description',
        'is_national', 'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_national' => 'boolean',
            'is_active'   => 'boolean',
        ];
    }

    // ----------------------------------------------------------------
    // Constants
    // ----------------------------------------------------------------

    public const CATEGORIES = [
        'police'        => 'Police',
        'fire'          => 'Fire Service',
        'ambulance'     => 'Ambulance / Medical',
        'frsc'          => 'FRSC',
        'dss'           => 'DSS',
        'civil_defence' => 'Civil Defence',
        'military'      => 'Military',
        'nema'          => 'NEMA',
        'ngo'           => 'NGO',
        'other'         => 'Other',
    ];

    public const CATEGORY_ICONS = [
        'police'        => '🚔',
        'fire'          => '🔥',
        'ambulance'     => '🚑',
        'frsc'          => '🚗',
        'dss'           => '🛡️',
        'civil_defence' => '⚔️',
        'military'      => '🪖',
        'nema'          => '🆘',
        'ngo'           => '❤️',
        'other'         => '📞',
    ];

    // ----------------------------------------------------------------
    // Accessors
    // ----------------------------------------------------------------

    public function getCategoryLabelAttribute(): string
    {
        return self::CATEGORIES[$this->category] ?? 'Other';
    }

    public function getCategoryIconAttribute(): string
    {
        return self::CATEGORY_ICONS[$this->category] ?? '📞';
    }

    // ----------------------------------------------------------------
    // Scopes
    // ----------------------------------------------------------------

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeNational($query)
    {
        return $query->where('is_national', true)->whereNull('state_id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('agency_name');
    }

    // ----------------------------------------------------------------
    // Relationships
    // ----------------------------------------------------------------

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function lga(): BelongsTo
    {
        return $this->belongsTo(Lga::class);
    }
}
