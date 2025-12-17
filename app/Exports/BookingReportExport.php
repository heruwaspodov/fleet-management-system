<?php

namespace App\Exports;

use App\Models\Booking;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BookingReportExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $startDate;
    protected $endDate;
    protected $status;

    public function __construct($startDate, $endDate, $status = '')
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->status = $status;
    }

    public function query()
    {
        $query = Booking::query()
            ->with(['user', 'vehicle', 'driver'])
            ->whereBetween('created_at', [$this->startDate . ' 00:00:00', $this->endDate . ' 23:59:59']);

        if ($this->status) {
            $query->where('status', $this->status);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'Booking Code',
            'Date',
            'Requester',
            'Department',
            'Driver',
            'Vehicle Plate',
            'Vehicle Brand',
            'Vehicle Model',
            'Purpose',
            'Destination',
            'Start Date & Time',
            'End Date & Time',
            'Status',
            'Notes'
        ];
    }

    public function map($booking): array
    {
        return [
            $booking->booking_code,
            $booking->created_at->format('Y-m-d H:i:s'),
            $booking->user->name,
            $booking->user->department ?? '-',
            $booking->driver ? $booking->driver->name : '-',
            $booking->vehicle->plate_number,
            $booking->vehicle->brand,
            $booking->vehicle->model,
            $booking->purpose,
            $booking->destination,
            $booking->start_datetime->format('Y-m-d H:i:s'),
            $booking->end_datetime->format('Y-m-d H:i:s'),
            ucfirst(str_replace('_', ' ', $booking->status)),
            $booking->notes ?? '-',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // Make the header row bold
        ];
    }
}