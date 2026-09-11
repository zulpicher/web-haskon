<?php

namespace App\Http\Controllers;

use App\Services\CashBalanceService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct(
        private CashBalanceService $balanceService
    ) {}

    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $bukuKasSummary = [
            'balance' => $this->balanceService->getCurrentBalance(),

            'income' => $user->transactions()
                ->where('type', 'income')
                ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
                ->sum('amount'),

            'expense' => $user->transactions()
                ->where('type', 'expense')
                ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
                ->sum('amount'),
        ];

        return view('home', compact('bukuKasSummary'));
    }
}
