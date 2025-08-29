<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_super_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Role helper methods
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isInspector(): bool
    {
        return $this->role === 'inspector';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    public function canDelete(): bool
    {
        return $this->isAdmin();
    }

    public function canInspect(): bool
    {
        return $this->isInspector() || $this->isAdmin();
    }

    /**
     * Check if user is super admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->is_super_admin === true;
    }

    /**
     * Override password setter to protect super admin
     */
    public function setPasswordAttribute($value)
    {
        // Protect super admin password from being changed by others
        if ($this->email === 'superadmin@system.local' && $this->exists) {
            // Only allow password change if current user is also super admin
            if (auth()->check() && !auth()->user()->isSuperAdmin()) {
                // Silently ignore password change attempts from non-super admins
                return;
            }
        }
        
        // Normal password setting for other users
        $this->attributes['password'] = $value;
    }

    /**
     * Protect super admin from ANY modifications by non-super admins
     */
    public static function boot()
    {
        parent::boot();

        // Before updating any user
        static::updating(function ($user) {
            // If trying to update super admin
            if ($user->email === 'superadmin@system.local' || $user->getOriginal('email') === 'superadmin@system.local') {
                // Check if current user is super admin
                if (auth()->check() && !auth()->user()->isSuperAdmin()) {
                    // Prevent the update
                    return false;
                }
            }
        });

        // Before deleting any user
        static::deleting(function ($user) {
            // Never allow deletion of super admin
            if ($user->email === 'superadmin@system.local') {
                return false;
            }
        });
    }
}
