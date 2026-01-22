<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('contacts.create') ?? false;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required','string','max:100'],
            'last_name'  => ['required','string','max:100'],
            'phone_1'    => ['nullable','string','max:30'],
            'phone_2'    => ['nullable','string','max:30'],
            'email_1'    => ['nullable','email','max:191'],
            'email_2'    => ['nullable','email','max:191'],
            'company_name' => ['nullable','string','max:191'],
        ];
    }
}
