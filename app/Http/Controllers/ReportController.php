<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\TransactionReportExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function __construct(
        private ReportService $reportService
    ) {}

    public function index()
    {
        return view('reports.index');
    }

    public function generate(Request $request)
    {
        $report = $this->resolveReport($request);

        return view('reports.index', [
            'report' => $report,
        ]);
    }

    public function pdf(Request $request)
    {
        $report = $this->resolveReport($request);

        $pdf = Pdf::loadView('reports.pdf', [
            'report' => $report,
        ]);

        return $pdf->download(
            'laporan-buku-kas-' . now()->format('Ymd-His') . '.pdf'
        );
    }

    public function excel(Request $request)
    {
        $report = $this->resolveReport($request);

        $filename = 'laporan-buku-kas-' . now()->format('Ymd-His') . '.xlsx';

        return Excel::download(
            new TransactionReportExport($report),
            $filename
        );
    }

    private function resolveReport(Request $request): array
    {
        $request->validate([
            'report_type' => ['required', 'in:monthly,custom'],

            'month' => [
                'required_if:report_type,monthly',
                'date_format:Y-m',
            ],

            'start_date' => [
                'required_if:report_type,custom',
                'date',
            ],

            'end_date' => [
                'required_if:report_type,custom',
                'date',
                'after_or_equal:start_date',
            ],
        ]);

        if ($request->report_type === 'monthly') {
            [$year, $month] = explode('-', $request->month);

            return $this->reportService->generateMonthlyReport(
                (int) $year,
                (int) $month
            );
        }

        return $this->reportService->generateReport(
            $request->start_date,
            $request->end_date
        );
    }
}
