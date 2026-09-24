<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'assigned_to' => [
                'required',
                'exists:users,id',
            ],

            'group_id' => [
                'required',
                'exists:groups,id',
            ],

            'status' => [
                'sometimes',
                'required',
                'in:todo,in_progress,completed,cancelled',
            ],

            'priority' => [
                'required',
                'in:low,medium,high,urgent',
            ],

            'due_date' => [
                'nullable',
                'date',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' =>
                'Judul task wajib diisi.',

            'title.max' =>
                'Judul task maksimal 255 karakter.',

            'assigned_to.required' =>
                'User yang ditugaskan wajib dipilih.',

            'assigned_to.exists' =>
                'User yang dipilih tidak ditemukan.',

            'group_id.required' =>
                'Group wajib dipilih.',

            'group_id.exists' =>
                'Group yang dipilih tidak ditemukan.',

            'status.in' =>
                'Status task tidak valid.',

            'priority.required' =>
                'Prioritas wajib dipilih.',

            'priority.in' =>
                'Prioritas task tidak valid.',

            'due_date.date' =>
                'Tanggal deadline tidak valid.',
        ];
    }
}