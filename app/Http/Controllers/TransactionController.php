<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\CashBalanceService;

class TransactionController extends Controller
{
    public function __construct(
        private CashBalanceService $balanceService
    ) {}

    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $query = $user->transactions()
            ->latest('transaction_date')
            ->latest('id');

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('transaction_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('transaction_date', '<=', $request->end_date);
        }

        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%');
        }

        $transactions = $query->paginate(10)->withQueryString();

        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now()->endOfMonth();

        $currentBalance = $this->balanceService->getCurrentBalance();

        $monthlyIncome = $user->transactions()
            ->where('type', 'income')
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        $monthlyExpense = $user->transactions()
            ->where('type', 'expense')
            ->whereBetween('transaction_date', [$startOfMonth, $endOfMonth])
            ->sum('amount');

        return view('transactions.index', [
            'transactions' => $transactions,
            'currentBalance' => $currentBalance,
            'monthlyIncome' => $monthlyIncome,
            'monthlyExpense' => $monthlyExpense,
        ]);
    }

    public function create()
    {
        return view('transactions.create');
    }

    public function store(TransactionRequest $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->transactions()->create($request->validated());

        return redirect()
            ->route('buku-kas.dashboard')
            ->with('success', 'Transaksi berhasil ditambahkan.');
    }

    public function show(Transaction $transaction)
    {
        $this->authorizeTransaction($transaction);

        return view('transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        $this->authorizeTransaction($transaction);

        return view('transactions.edit', compact('transaction'));
    }

    public function update(
        TransactionRequest $request,
        Transaction $transaction
    ) {
        $this->authorizeTransaction($transaction);

        $transaction->update($request->validated());

        return redirect()
            ->route('buku-kas.dashboard')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(Transaction $transaction)
    {
        $this->authorizeTransaction($transaction);

        $transaction->delete();

        return redirect()
            ->route('buku-kas.dashboard')
            ->with('success', 'Transaksi berhasil dihapus.');
    }

    private function authorizeTransaction(Transaction $transaction): void
    {
        abort_unless(
            $transaction->user_id === Auth::id(),
            403
        );
    }
}
