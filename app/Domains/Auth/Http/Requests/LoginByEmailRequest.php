<?php

declare(strict_types=1);

namespace App\Domains\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginByEmailRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
