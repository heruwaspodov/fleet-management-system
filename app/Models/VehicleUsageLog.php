<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleUsageLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'booking_id',
        'vehicle_id',
        'driver_id',
        'actual_start_datetime',
        'actual_end_datetime',
        'starting_odometer',
        'ending_odometer',
        'fuel_used',
        'fuel_cost',
        'condition_on_departure',
        'condition_on_return',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'actual_start_datetime' => 'datetime',
        'actual_end_datetime' => 'datetime',
        'starting_odometer' => 'integer',
        'ending_odometer' => 'integer',
        'fuel_used' => 'decimal:2',
        'fuel_cost' => 'decimal:2',
    ];

    /**
     * Relasi ke booking
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Relasi ke kendaraan
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Relasi ke driver
     */
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    /**
     * Hitung total jarak yang ditempuh
     */
    public function getTotalDistance(): int
    {
        if ($this->starting_odometer !== null && $this->ending_odometer !== null) {
            return max(0, $this->ending_odometer - $this->starting_odometer);
        }
        
        return 0;
    }

    /**
     * Hitung efisiensi bahan bakar (km/L)
     */
    public function getFuelEfficiency(): float
    {
        $distance = $this->getTotalDistance();
        
        if ($distance > 0 && $this->fuel_used > 0) {
            return round($distance / $this->fuel_used, 2);
        }
        
        return 0.0;
    }

    /**
     * Scope untuk mencari log berdasarkan rentang tanggal
     */
    public function scopeBetweenDates($query, $startDate, $endDate)
    {
        return $query->whereBetween('actual_start_datetime', [$startDate, $endDate])
                     ->orWhereBetween('actual_end_datetime', [$startDate, $endDate]);
    }

    /**
     * Scope untuk mencari log berdasarkan kendaraan
     */
    public function scopeByVehicle($query, $vehicleId)
    {
        return $query->where('vehicle_id', $vehicleId);
    }

    /**
     * Scope untuk mencari log berdasarkan driver
     */
    public function scopeByDriver($query, $driverId)
    {
        return $query->where('driver_id', $driverId);
    }
}