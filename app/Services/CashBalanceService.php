<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Support\Carbon;

class CashBalanceService
{
    /**
     * Saldo saat ini dari seluruh transaksi aktif.
     */
    public function getCurrentBalance(): float
    {
        return $this->calculateBalance();
    }

    /**
     * Saldo dari transaksi dengan tanggal < $date (exclusive).
     * Dipakai sebagai opening balance untuk custom date report.
     */
    public function getBalanceBeforeDate(string|Carbon $date): float
    {
        return $this->calculateBalance(function ($query) use ($date) {
            $query->where('transaction_date', '<', $date);
        });
    }

    /**
     * Saldo dari transaksi dengan tanggal <= $date (inclusive).
     * Dipakai sebagai closing balance.
     */
    public function getBalanceAtDate(string|Carbon $date): float
    {
        return $this->calculateBalance(function ($query) use ($date) {
            $query->where('transaction_date', '<=', $date);
        });
    }

    /**
     * Helper internal: hitung income - expense dengan filter opsional.
     * Soft-deleted transactions otomatis tidak ikut
     * (default Eloquent behavior).
     */
    private function calculateBalance(?\Closure $filter = null): float
    {
        $incomeQuery = Transaction::query()
            ->where('type', 'income');

        $expenseQuery = Transaction::query()
            ->where('type', 'expense');

        if ($filter) {
            $filter($incomeQuery);
            $filter($expenseQuery);
        }

        $totalIncome = (float) $incomeQuery->sum('amount');
        $totalExpense = (float) $expenseQuery->sum('amount');

        return $totalIncome - $totalExpense;
    }
}
