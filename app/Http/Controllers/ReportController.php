<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

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

            $report = $this->reportService->generateMonthlyReport(
                (int) $year,
                (int) $month
            );
        } else {
            $report = $this->reportService->generateReport(
                $request->start_date,
                $request->end_date
            );
        }

        return view('reports.index', [
            'report' => $report,
        ]);
    }

    public function pdf(Request $request)
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

            $report = $this->reportService->generateMonthlyReport(
                (int) $year,
                (int) $month
            );

        } else {

            $report = $this->reportService->generateReport(
                $request->start_date,
                $request->end_date
            );
        }

        $pdf = Pdf::loadView('reports.pdf', [
            'report' => $report,
        ]);

        return $pdf->download(
            'laporan-buku-kas-' . now()->format('Ymd-His') . '.pdf'
        );
    }

}
