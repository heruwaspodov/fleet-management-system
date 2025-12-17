<?php

namespace App\Livewire\Admin\Approval;

use App\Models\Booking;
use App\Models\Approval;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';
    public $levelFilter = '';
    public $startDate = '';
    public $endDate = '';
    public $perPage = 10;

    protected $paginationTheme = 'tailwind';

    public function mount()
    {
        // Untuk admin, bisa melihat semua booking yang menunggu approval
    }

    public function updated($field)
    {
        if ($field === 'search' || $field === 'statusFilter' || $field === 'levelFilter' || $field === 'startDate' || $field === 'endDate' || $field === 'perPage') {
            // Reset ke halaman pertama saat filter berubah
            $this->resetPage();
        }
    }

    public function approve($bookingId)
    {
        $booking = Booking::find($bookingId);
        $user = Auth::user();

        if (!$booking) {
            session()->flash('error', 'Booking not found');
            return;
        }

        // Untuk admin, bisa menyetujui booking yang statusnya pending_approval (tanpa memperhatikan level)
        if ($user->isAdmin()) {
            // Cek apakah booking masih dalam status pending
            if ($booking->status !== 'pending_approval') {
                session()->flash('error', 'This booking is not pending approval');
                return;
            }

            // Update semua approval menjadi approved
            $booking->approvals()->update([
                'status' => 'approved',
                'approved_at' => now(),
            ]);

            // Update status booking menjadi approved
            $booking->update(['status' => 'approved']);
        } else {
            // Untuk non-admin, proses seperti semula
            // Temukan approval record untuk user ini
            $approval = $booking->approvals()->where('approver_id', $user->id)->first();

            if (!$approval) {
                session()->flash('error', 'You are not authorized to approve this booking');
                return;
            }

            if ($approval->status !== 'pending') {
                session()->flash('error', 'This approval request has already been processed');
                return;
            }

            // Update status approval
            $approval->update([
                'status' => 'approved',
                'approved_at' => now(),
            ]);

            // Periksa apakah semua approval sudah disetujui
            $allApprovals = $booking->approvals;
            $allApproved = $allApprovals->every(function ($approval) {
                return $approval->status === 'approved';
            });

            if ($allApproved) {
                // Jika semua approval disetujui, ubah status booking
                $booking->update(['status' => 'approved']);
            }
        }

        session()->flash('message', 'Booking approved successfully');
        $this->resetPage(); // Reset pagination ke halaman pertama setelah approval
    }

    public function reject($bookingId)
    {
        $booking = Booking::find($bookingId);
        $user = Auth::user();

        if (!$booking) {
            session()->flash('error', 'Booking not found');
            return;
        }

        // Untuk admin, bisa menolak booking yang statusnya pending_approval (tanpa memperhatikan level)
        if ($user->isAdmin()) {
            // Cek apakah booking masih dalam status pending
            if ($booking->status !== 'pending_approval') {
                session()->flash('error', 'This booking is not pending approval');
                return;
            }

            // Update semua approval menjadi rejected
            $booking->approvals()->update([
                'status' => 'rejected',
                'approved_at' => now(),
            ]);

            // Update status booking menjadi rejected
            $booking->update(['status' => 'rejected']);
        } else {
            // Untuk non-admin, proses seperti semula
            // Temukan approval record untuk user ini
            $approval = $booking->approvals()->where('approver_id', $user->id)->first();

            if (!$approval) {
                session()->flash('error', 'You are not authorized to reject this booking');
                return;
            }

            if ($approval->status !== 'pending') {
                session()->flash('error', 'This approval request has already been processed');
                return;
            }

            // Update status approval
            $approval->update([
                'status' => 'rejected',
                'approved_at' => now(),
            ]);

            // Jika ada penolakan, ubah status booking menjadi rejected
            $booking->update(['status' => 'rejected']);
        }

        session()->flash('message', 'Booking rejected successfully');
        $this->resetPage(); // Reset pagination ke halaman pertama setelah rejection
    }

    public function render()
    {
        // Untuk admin, tampilkan semua booking yang statusnya pending_approval
        $query = Booking::with(['user', 'vehicle', 'driver', 'approvals'])
            ->where('status', 'pending_approval');

        // Tambahkan pencarian jika ada
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('booking_code', 'like', '%' . $this->search . '%')
                  ->orWhereHas('user', function ($userQuery) {
                      $userQuery->where('name', 'like', '%' . $this->search . '%');
                  })
                  ->orWhereHas('vehicle', function ($vehicleQuery) {
                      $vehicleQuery->where('plate_number', 'like', '%' . $this->search . '%');
                  });
            });
        }

        // Filter berdasarkan tanggal
        if ($this->startDate) {
            $query->whereDate('created_at', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $query->whereDate('created_at', '<=', $this->endDate);
        }

        // Filter berdasarkan status approval
        if ($this->statusFilter) {
            $query->whereHas('approvals', function ($q) {
                $q->where('status', $this->statusFilter);
            });
        }

        // Filter berdasarkan level approval
        if ($this->levelFilter) {
            $query->whereHas('approvals', function ($q) {
                $q->where('level', $this->levelFilter);
            });
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate($this->perPage);

        return view('livewire.admin.approval.index', [
            'bookings' => $bookings
        ]);
    }
}