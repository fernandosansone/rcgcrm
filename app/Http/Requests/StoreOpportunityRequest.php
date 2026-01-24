<?php

namespace App\Http\Requests;

use App\Enums\OpportunityStatus;
use App\Enums\UnitOfMeasure;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOpportunityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('opportunities.create') ?? false;
    }

    public function rules(): array
    {
        return [
            'contact_id' => ['required','integer', 'exists:contacts,id'],
            'detail'     => ['required','string','max:255'],
            'quantity'   => ['nullable','numeric'],
            'unit' => ['nullable', Rule::in(UnitOfMeasure::values())],
            'amount_display' => ['nullable','string','max:30'],
            'amount' => ['nullable','numeric'],
            'status'     => ['required', Rule::in(OpportunityStatus::values())],
            'opened_at'  => ['nullable','date'],
            'closed_at'  => ['nullable','date'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('amount') && is_string($this->amount)) {
            $a = str_replace(['.',' '], ['', ''], $this->amount); // por si viene con miles
            $a = str_replace(',', '.', $a); // por si viene con coma
            $this->merge(['amount' => $a]);
        }
    }
}
