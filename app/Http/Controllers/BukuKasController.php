<?php

namespace App\Http\Controllers;

use App\Services\CashBalanceService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class BukuKasController extends Controller
{
    public function __construct(
        private CashBalanceService $balanceService
    ) {}

    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $currentBalance = $this->balanceService->getCurrentBalance();

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $monthlyIncome = $user->transactions()
            ->where('type', 'income')
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $monthlyExpense = $user->transactions()
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $recentTransactions = $user->transactions()
            ->latest('transaction_date')
            ->latest('id')
            ->take(5)
            ->get();

        $allTransactions = $user->transactions()
            ->latest('transaction_date')
            ->latest('id')
            ->get();

        return view('buku-kas.dashboard', [
            'currentBalance' => $currentBalance,
            'monthlyIncome' => $monthlyIncome,
            'monthlyExpense' => $monthlyExpense,
            'recentTransactions' => $recentTransactions,
            'allTransactions' => $allTransactions,
            'isNegative' => $currentBalance < 0,
        ]);
    }
}
