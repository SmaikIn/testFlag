<?php
declare(strict_types=1);

namespace App\Domains\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
