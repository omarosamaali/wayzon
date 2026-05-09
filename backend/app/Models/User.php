<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
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
        'is_admin',
        'plan',
        'pending_plan',
        'pending_plan_token',
        'trial_ends_at',
        'subscription_ends_at',
        'bot_config',
        'wa_disconnected',
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
            'email_verified_at'    => 'datetime',
            'password'             => 'hashed',
            'trial_ends_at'        => 'datetime',
            'subscription_ends_at' => 'datetime',
            'bot_config'           => 'array',
        ];
    }

    public function hasActiveAccess(): bool
    {
        // Admins always have full access
        if (in_array($this->email, ['faisal@1212.com', 'omar@gmail.com'])) {
            return true;
        }
        // Active paid subscription with expiry date
        if ($this->subscription_ends_at && $this->subscription_ends_at->isFuture()) {
            return true;
        }
        // Legacy Salla subscribers: have plan but subscription_ends_at not yet set
        if ($this->plan && is_null($this->subscription_ends_at)) {
            return true;
        }
        // Free trial period
        if ($this->trial_ends_at && $this->trial_ends_at->isFuture()) {
            return true;
        }
        return false;
    }

    public function sallaStore()
    {
        return $this->hasOne(\App\Models\SallaStore::class, 'user_id');
    }

    public function planLabel(): string
    {
        return match($this->plan) {
            'basic' => '🚀 الأساسية',
            'smart' => '🧠 الذكية',
            'pro'   => '🏆 الاحترافية',
            default => '⚪ لا توجد باقة',
        };
    }

    public function planColor(): string
    {
        return match($this->plan) {
            'basic' => '#6366f1',
            'smart' => '#a5b4fc',
            'pro'   => '#d8b4fe',
            default => '#64748b',
        };
    }
}
