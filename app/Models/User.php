<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'firstname',
        'surname',
        'email',
        'password',
        'role',
        'phone',
        'avatar',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    // ----------------------------------------------------------------
    // Accessors
    // ----------------------------------------------------------------

    public function getFullNameAttribute(): string
    {
        return trim("{$this->firstname} {$this->surname}");
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }

        $initials = urlencode(strtoupper(substr($this->firstname, 0, 1) . substr($this->surname, 0, 1)));

        return "https://ui-avatars.com/api/?name={$initials}&color=ffffff&background=009A44&bold=true&size=128";
    }

    public function getRoleLabelAttribute(): string
    {
        return match ($this->role) {
            'super_admin' => 'Super Admin',
            'moderator'   => 'Moderator',
            default       => 'User',
        };
    }

    // ----------------------------------------------------------------
    // Role helpers
    // ----------------------------------------------------------------

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isModerator(): bool
    {
        return in_array($this->role, ['super_admin', 'moderator'], true);
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    // ----------------------------------------------------------------
    // Relationships
    // ----------------------------------------------------------------

    public function incidents(): HasMany
    {
        return $this->hasMany(Incident::class, 'created_by');
    }

    public function approvedIncidents(): HasMany
    {
        return $this->hasMany(Incident::class, 'approved_by');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }
}
