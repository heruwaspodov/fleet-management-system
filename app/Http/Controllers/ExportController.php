<?php

namespace App\Http\Controllers;

use App\Exports\BookingReportExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function exportBookingReport(Request $request)
    {
        // Handle both formats for date parameters
        $startDate = $request->get('start_date') ?? $request->get('startDate');
        $endDate = $request->get('end_date') ?? $request->get('endDate');
        $status = $request->get('status');

        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'startDate' => 'nullable|date',
            'endDate' => 'nullable|date',
            'status' => 'nullable|string|in:draft,pending_approval,approved,rejected,in_progress,completed,cancelled',
        ]);

        // Either startDate/endDate or start_date/end_date must be provided
        if (!$startDate && !$request->get('start_date')) {
            $startDate = now()->subDays(30)->format('Y-m-d');
        }

        if (!$endDate && !$request->get('end_date')) {
            $endDate = now()->format('Y-m-d');
        }

        $fileName = 'booking-report-' . date('Y-m-d') . '.xlsx';

        return Excel::download(
            new BookingReportExport($startDate, $endDate, $status),
            $fileName
        );
    }
}
