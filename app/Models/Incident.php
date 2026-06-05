<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Incident extends Model
{
    use HasFactory, SoftDeletes;

    // ----------------------------------------------------------------
    // Constants
    // ----------------------------------------------------------------

    public const ATTACK_TYPES = [
        'banditry'          => 'Banditry',
        'terrorism'         => 'Terrorism',
        'kidnapping'        => 'Kidnapping',
        'armed_robbery'     => 'Armed Robbery',
        'communal_clash'    => 'Communal Clash',
        'herdsmen_attack'   => 'Herdsmen Attack',
        'cult_clash'        => 'Cult Clash',
        'cybercrime'        => 'Cybercrime',
        'police_brutality'  => 'Police Brutality',
        'missing_person'    => 'Missing Person',
        'fire_outbreak'     => 'Fire Outbreak',
        'other'             => 'Other',
    ];

    public const SEVERITIES = ['low', 'medium', 'high', 'critical'];

    public const STATUSES = ['pending', 'approved', 'rejected'];

    public const SEVERITY_COLORS = [
        'low'      => '#22c55e',
        'medium'   => '#f59e0b',
        'high'     => '#f97316',
        'critical' => '#ef4444',
    ];

    // ----------------------------------------------------------------
    // Fillable
    // ----------------------------------------------------------------

    protected $fillable = [
        'title', 'slug', 'state_id', 'lga_id', 'town',
        'attack_type', 'description', 'casualties', 'kidnapped_count',
        'latitude', 'longitude', 'incident_date', 'incident_time',
        'status', 'severity', 'source_url', 'images',
        'is_featured', 'is_anonymous', 'created_by',
        'approved_by', 'approved_at', 'rejection_reason',
    ];

    protected function casts(): array
    {
        return [
            'incident_date' => 'date',
            'approved_at'   => 'datetime',
            'images'        => 'array',
            'is_featured'   => 'boolean',
            'is_anonymous'  => 'boolean',
            'casualties'    => 'integer',
            'kidnapped_count' => 'integer',
            'latitude'      => 'float',
            'longitude'     => 'float',
        ];
    }

    // ----------------------------------------------------------------
    // Boot — auto slug
    // ----------------------------------------------------------------

    protected static function booted(): void
    {
        static::creating(function (Incident $incident) {
            $base = Str::slug($incident->title);
            $slug = $base . '-' . strtolower(Str::random(6));
            // Ensure uniqueness
            while (static::where('slug', $slug)->exists()) {
                $slug = $base . '-' . strtolower(Str::random(6));
            }
            $incident->slug = $slug;
        });
    }

    // ----------------------------------------------------------------
    // Route model binding
    // ----------------------------------------------------------------

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // ----------------------------------------------------------------
    // Accessors
    // ----------------------------------------------------------------

    public function getAttackTypeLabelAttribute(): string
    {
        return self::ATTACK_TYPES[$this->attack_type] ?? ucfirst(str_replace('_', ' ', $this->attack_type));
    }

    public function getSeverityColorAttribute(): string
    {
        return self::SEVERITY_COLORS[$this->severity] ?? '#6b7280';
    }

    public function getReporterNameAttribute(): string
    {
        if ($this->is_anonymous) {
            return 'Anonymous';
        }
        return $this->creator?->full_name ?? 'Unknown';
    }

    public function getFormattedDateAttribute(): string
    {
        return $this->incident_date?->format('D, d M Y') ?? '';
    }

    public function getShortDescriptionAttribute(): string
    {
        return Str::limit(strip_tags($this->description), 160);
    }

    // ----------------------------------------------------------------
    // Scopes
    // ----------------------------------------------------------------

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeRecent($query)
    {
        return $query->orderByDesc('incident_date')->orderByDesc('created_at');
    }

    public function scopeForHeatmap($query)
    {
        return $query->approved()
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->select(['id', 'title', 'attack_type', 'severity', 'latitude', 'longitude',
                       'incident_date', 'casualties', 'state_id']);
    }

    public function scopeFilter($query, array $filters)
    {
        if (!empty($filters['state_id'])) {
            $query->where('state_id', $filters['state_id']);
        }
        if (!empty($filters['lga_id'])) {
            $query->where('lga_id', $filters['lga_id']);
        }
        if (!empty($filters['attack_type'])) {
            $query->where('attack_type', $filters['attack_type']);
        }
        if (!empty($filters['severity'])) {
            $query->where('severity', $filters['severity']);
        }
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (!empty($filters['date_from'])) {
            $query->whereDate('incident_date', '>=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $query->whereDate('incident_date', '<=', $filters['date_to']);
        }
        if (!empty($filters['search'])) {
            $query->whereFullText(['title', 'description', 'town'], $filters['search']);
        }

        return $query;
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

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)
            ->whereNull('parent_id')
            ->where('status', 'approved')
            ->latest();
    }

    public function allComments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
