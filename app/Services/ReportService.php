<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Support\Carbon;

class ReportService
{
    public function __construct(
        private CashBalanceService $balanceService
    ) {}

    /**
     * Generate laporan untuk custom date range.
     *
     * Return array yang bisa digunakan oleh:
     * - Web
     * - PDF
     * - Excel
     */
    public function generateReport(
        string|Carbon $startDate,
        string|Carbon $endDate
    ): array {
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();

        $openingBalance = $this->balanceService
            ->getBalanceBeforeDate($startDate);

        $transactions = Transaction::whereBetween(
            'transaction_date',
            [$startDate, $endDate]
        )
            ->orderBy('transaction_date')
            ->orderBy('id')
            ->get();

        $runningBalance = $openingBalance;

        $rows = [];

        foreach ($transactions as $transaction) {
            $runningBalance += $transaction->type === 'income'
                ? (float) $transaction->amount
                : -(float) $transaction->amount;

            $rows[] = [
                'date' => $transaction->transaction_date,
                'description' => $transaction->description,
                'income' => $transaction->type === 'income'
                    ? (float) $transaction->amount
                    : null,
                'expense' => $transaction->type === 'expense'
                    ? (float) $transaction->amount
                    : null,
                'balance' => $runningBalance,
            ];
        }

        $totalIncome = (float) $transactions
            ->where('type', 'income')
            ->sum('amount');

        $totalExpense = (float) $transactions
            ->where('type', 'expense')
            ->sum('amount');

        $closingBalance = $openingBalance
            + $totalIncome
            - $totalExpense;

        return [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'opening_balance' => $openingBalance,
            'rows' => $rows,
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'closing_balance' => $closingBalance,
            'is_negative' => $closingBalance < 0,
        ];
    }

    /**
     * Generate laporan bulanan.
     */
    public function generateMonthlyReport(
        int $year,
        int $month
    ): array {
        $startDate = Carbon::create($year, $month, 1)
            ->startOfMonth();

        $endDate = $startDate->copy()->endOfMonth();

        return $this->generateReport(
            $startDate,
            $endDate
        );
    }
}
