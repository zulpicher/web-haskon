<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(TransactionRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();
        
        $user->transactions()->create($request->validated());

        return redirect()
            ->route('buku-kas.dashboard')
            ->with('success', 'Transaksi berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TransactionRequest $request, Transaction $transaction)
    {
        $this->authorizeTransaction();

        $transaction->update($request->validated());

        return redirect()
            ->route('buku-kas.dashboard')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $this->authorizeTransaction();

        $transaction->delete();

        return redirect()
            ->route('buku-kas.dashboard')
            ->with('success', 'Transaksi berhasil dihapus.');
    }

    /**
     * Pengecekan otorisasi global untuk modul Buku Kas
     */
    private function authorizeTransaction(): void
    {
        /** @var User $user */
        $user = Auth::user();

        abort_unless(
            $user && $user->canAccessBukuKas(),
            403
        );
    }
}