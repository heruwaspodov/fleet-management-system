<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'booking_id',
        'approver_id',
        'level',
        'status',
        'comments',
        'approved_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'approved_at' => 'datetime',
        'level' => 'integer',
    ];

    /**
     * Relasi ke booking
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Relasi ke approver
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }

    /**
     * Scope untuk mencari approval berdasarkan status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk mencari approval berdasarkan level
     */
    public function scopeByLevel($query, $level)
    {
        return $query->where('level', $level);
    }

    /**
     * Scope untuk mencari approval berdasarkan approver
     */
    public function scopeByApprover($query, $approverId)
    {
        return $query->where('approver_id', $approverId);
    }

    /**
     * Cek apakah approval sedang menunggu
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Cek apakah approval telah disetujui
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Cek apakah approval ditolak
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }
}