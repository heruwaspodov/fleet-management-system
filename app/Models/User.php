<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'approval_level',
        'position',
        'department',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relasi ke booking yang dibuat oleh user
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'user_id');
    }

    /**
     * Relasi ke approval yang dilakukan oleh user
     */
    public function approvals()
    {
        return $this->hasMany(Approval::class, 'approver_id');
    }

    /**
     * Relasi ke log penggunaan kendaraan sebagai driver
     */
    public function vehicleUsageLogs()
    {
        return $this->hasMany(VehicleUsageLog::class, 'driver_id');
    }

    /**
     * Relasi ke booking yang ditugaskan sebagai driver
     */
    public function assignedBookings()
    {
        return $this->hasMany(Booking::class, 'driver_id');
    }

    /**
     * Cek apakah user adalah admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Cek apakah user adalah approver
     */
    public function isApprover(): bool
    {
        return $this->role === 'approver';
    }

    /**
     * Cek apakah user adalah employee biasa
     */
    public function isEmployee(): bool
    {
        return $this->role === 'employee';
    }

    /**
     * Mendapatkan inisial dari nama pengguna
     */
    public function initials(): string
    {
        $words = explode(' ', $this->name);
        $initials = '';

        foreach ($words as $word) {
            if (strlen($word) > 0) {
                $initials .= strtoupper(substr($word, 0, 1));
            }
        }

        // Ambil hanya 2 karakter pertama
        return substr($initials, 0, 2);
    }

    /**
     * Determine if two-factor authentication has been enabled.
     */
    public function hasEnabledTwoFactorAuthentication(): bool
    {
        return ! is_null($this->two_factor_secret);
    }

    /**
     * Determine if two-factor authentication is confirmed.
     */
    public function hasConfirmedTwoFactorAuthentication(): bool
    {
        return ! is_null($this->two_factor_confirmed_at);
    }

    /**
     * Determine if the user is eligible for two factor authentication.
     */
    public function twoFactorConfimationEligible(): bool
    {
        return $this->hasEnabledTwoFactorAuthentication() &&
               $this->hasConfirmedTwoFactorAuthentication();
    }
}