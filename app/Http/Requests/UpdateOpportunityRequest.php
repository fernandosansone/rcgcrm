<?php

namespace App\Http\Requests;

use App\Enums\OpportunityStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOpportunityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('opportunities.update') ?? false;
    }

    public function rules(): array
    {
        return [
            'contact_id' => ['required','integer', 'exists:contacts,id'],
            'detail'     => ['required','string','max:255'],
            'quantity'   => ['nullable','numeric'],
            'unit'       => ['nullable','string','max:50'],
            'amount'     => ['nullable','numeric'],
            'status'     => ['required', Rule::in(OpportunityStatus::values())],
            'opened_at'  => ['nullable','date'],
            'closed_at'  => ['nullable','date'],
        ];
    }
}
