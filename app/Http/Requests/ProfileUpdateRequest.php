<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
{
    return [
        'name' => ['required', 'string', 'max:255'],
        'email' => [
            'required',
            'string',
            'lowercase',
            'email',
            'max:255',
            Rule::unique(User::class)->ignore($this->user()->id),
        ],
        'alamat' => [
            'required',
            'string',
            'max:500',
        ],
        'tgl_lahir' => [
            'required',
            'date', 
            'before_or_equal:today',
        ],
        'no_hp' => [
            'required',
            'string',
            'min:10',
            'max:15',
            'regex:/^[0-9\+\-\(\)\s]*$/',
        ],
    ];
}

}