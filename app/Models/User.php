<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'school_id',
        'transferred_from',
        'transferred_at',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'transferred_at'    => 'datetime',
            'password'          => 'hashed',
        ];
    }

    /** The school the user currently belongs to. */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    /** The school the user was last transferred from. */
    public function previousSchool(): BelongsTo
    {
        return $this->belongsTo(School::class, 'transferred_from');
    }

    /** Two-letter initials derived from the user's name. */
    public function initials(): string
    {
        return collect(explode(' ', $this->name))
            ->map(fn ($word) => strtoupper($word[0] ?? ''))
            ->filter()
            ->take(2)
            ->implode('');
    }
}
