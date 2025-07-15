<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgjaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nama_progja' => 'required|string|max:255',
            'tanggal_pelaksanaan' => 'required|date',
            'sasaran' => 'required|string|max:255',
            'hasil' => 'nullable|string',
            'indikator' => 'nullable|string',
            'penanggung_jawab' => 'required|string|max:255',
            'kategori' => 'required|in:RAB,NON RAB,Biasa',
            'anggaran' => 'required|numeric|min:0',
            'status_id' => 'required|exists:statuses,id',
            'proposal' => 'nullable|file|mimes:pdf|max:10240',
            'lpj' => 'nullable|file|mimes:pdf|max:10240',
        ];
    }
} 