<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->can('contacts.update') ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
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
