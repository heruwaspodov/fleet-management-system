<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'booking_code',
        'user_id',
        'vehicle_id',
        'driver_id',
        'purpose',
        'destination',
        'start_datetime',
        'end_datetime',
        'status',
        'estimated_fuel_cost',
        'estimated_distance',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'estimated_fuel_cost' => 'decimal:2',
        'estimated_distance' => 'integer',
    ];

    /**
     * Boot the model and set up event listeners
     */
    protected static function boot()
    {
        parent::boot();

        // Generate booking code before creating
        static::creating(function ($booking) {
            $booking->booking_code = self::generateUniqueBookingCode();
        });
    }

    /**
     * Generate unique booking code
     */
    private static function generateUniqueBookingCode()
    {
        $prefix = 'BK';
        $date = now()->format('Ymd');
        $random = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 6));
        
        return $prefix . $date . $random;
    }

    /**
     * Relasi ke user yang memesan
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke kendaraan yang dipesan
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Relasi ke driver yang ditugaskan
     */
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    /**
     * Relasi ke approval
     */
    public function approvals()
    {
        return $this->hasMany(Approval::class)->orderBy('level');
    }

    /**
     * Relasi ke log penggunaan kendaraan
     */
    public function usageLog()
    {
        return $this->hasOne(VehicleUsageLog::class);
    }

    /**
     * Scope untuk mencari booking berdasarkan status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk mencari booking berdasarkan rentang tanggal
     */
    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('start_datetime', [$startDate, $endDate])
                     ->orWhereBetween('end_datetime', [$startDate, $endDate]);
    }

    /**
     * Scope untuk mencari booking berdasarkan user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope untuk mencari booking berdasarkan kendaraan
     */
    public function scopeByVehicle($query, $vehicleId)
    {
        return $query->where('vehicle_id', $vehicleId);
    }

    /**
     * Cek apakah booking dalam status draft
     */
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    /**
     * Cek apakah booking menunggu persetujuan
     */
    public function isPendingApproval(): bool
    {
        return $this->status === 'pending_approval';
    }

    /**
     * Cek apakah booking telah disetujui
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Cek apakah booking ditolak
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Cek apakah booking sedang berlangsung
     */
    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }

    /**
     * Cek apakah booking telah selesai
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Cek apakah booking dibatalkan
     */
    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    /**
     * Cek apakah booking sedang aktif (sedang digunakan atau telah disetujui tapi belum selesai)
     */
    public function isActive(): bool
    {
        return in_array($this->status, ['approved', 'in_progress']);
    }
}