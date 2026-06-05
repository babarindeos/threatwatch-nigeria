<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Report extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'state_id', 'lga_id', 'town',
        'attack_type', 'title', 'description',
        'casualties', 'kidnapped_count',
        'latitude', 'longitude',
        'incident_date', 'incident_time',
        'evidence_files', 'is_anonymous',
        'reporter_name', 'reporter_phone',
        'status', 'admin_notes',
        'reviewed_by', 'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'incident_date'  => 'date',
            'reviewed_at'    => 'datetime',
            'evidence_files' => 'array',
            'is_anonymous'   => 'boolean',
            'latitude'       => 'float',
            'longitude'      => 'float',
        ];
    }

    // ----------------------------------------------------------------
    // Accessors
    // ----------------------------------------------------------------

    public function getAttackTypeLabelAttribute(): string
    {
        return Incident::ATTACK_TYPES[$this->attack_type]
            ?? ucfirst(str_replace('_', ' ', $this->attack_type));
    }

    public function getDisplayNameAttribute(): string
    {
        if ($this->is_anonymous) return 'Anonymous';
        if ($this->reporter_name) return $this->reporter_name;
        return $this->user?->full_name ?? 'Unknown';
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending'  => 'bg-yellow-100 text-yellow-800',
            'reviewed' => 'bg-blue-100 text-blue-800',
            'approved' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            default    => 'bg-gray-100 text-gray-800',
        };
    }

    // ----------------------------------------------------------------
    // Scopes
    // ----------------------------------------------------------------

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // ----------------------------------------------------------------
    // Relationships
    // ----------------------------------------------------------------

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function lga(): BelongsTo
    {
        return $this->belongsTo(Lga::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
