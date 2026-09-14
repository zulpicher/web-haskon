<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionReportExport implements FromArray, WithHeadings, WithStyles
{
    public function __construct(
        private array $report
    ) {}

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Keterangan',
            'Kas Masuk',
            'Kas Keluar',
            'Saldo',
        ];
    }

    public function array(): array
    {
        $rows = [];

        foreach ($this->report['rows'] as $i => $row) {
            $rows[] = [
                $i + 1,
                $row['date']->format('d/m/Y'),
                $row['description'],
                $row['income'] !== null ? $row['income'] : '',
                $row['expense'] !== null ? $row['expense'] : '',
                $row['balance'],
            ];
        }

        // Baris kosong
        $rows[] = ['', '', '', '', '', ''];

        // Ringkasan
        $rows[] = [
            '',
            '',
            'Total Kas Masuk',
            $this->report['total_income'],
            '',
            '',
        ];

        $rows[] = [
            '',
            '',
            'Total Kas Keluar',
            '',
            $this->report['total_expense'],
            '',
        ];

        $rows[] = [
            '',
            '',
            'Saldo Akhir Periode',
            '',
            '',
            $this->report['closing_balance'],
        ];

        return $rows;
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                ],
            ],
        ];
    }
}
