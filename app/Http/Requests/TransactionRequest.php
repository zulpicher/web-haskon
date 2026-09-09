<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class TransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'transaction_date' => [
                'required',
                'date',
            ],

            'type' => [
                'required',
                Rule::in(['income', 'expense']),
            ],

            'description' => [
                'required',
                'string',
                'max:1000',
            ],

            'amount' => [
                'required',
                'numeric',
                'gt:0',
            ],
        ];
    }
}
