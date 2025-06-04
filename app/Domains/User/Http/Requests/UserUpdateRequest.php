<?php

declare(strict_types=1);

namespace App\Domains\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'userId' => 'sometimes|int|exists:users,id',
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['userId' => $this->route('user')]);
    }

}
