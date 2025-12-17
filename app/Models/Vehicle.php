<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'plate_number',
        'type',
        'brand',
        'model',
        'year',
        'category',
        'ownership',
        'rental_company',
        'capacity',
        'fuel_type',
        'description',
        'status',
        'last_service_date',
        'last_service_mileage',
        'next_service_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'year' => 'integer',
        'last_service_date' => 'date',
        'next_service_date' => 'date',
        'last_service_mileage' => 'integer',
        'capacity' => 'integer',
        'estimated_fuel_cost' => 'decimal:2',
    ];

    /**
     * Relasi ke booking
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Relasi ke log penggunaan kendaraan
     */
    public function usageLogs()
    {
        return $this->hasMany(VehicleUsageLog::class);
    }

    /**
     * Scope untuk mencari kendaraan berdasarkan status
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    /**
     * Scope untuk mencari kendaraan berdasarkan kategori
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope untuk mencari kendaraan berdasarkan kategori (angkutan orang/barang)
     */
    public function scopeOfCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope untuk mencari kendaraan yang sedang maintenance
     */
    public function scopeUnderMaintenance($query)
    {
        return $query->whereIn('status', ['maintenance', 'out_of_service']);
    }

    /**
     * Cek apakah kendaraan tersedia
     */
    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    /**
     * Cek apakah kendaraan sedang dipakai
     */
    public function isInUse(): bool
    {
        return $this->status === 'booked';
    }

    /**
     * Cek apakah kendaraan sedang maintenance
     */
    public function isUnderMaintenance(): bool
    {
        return in_array($this->status, ['maintenance', 'out_of_service']);
    }
}