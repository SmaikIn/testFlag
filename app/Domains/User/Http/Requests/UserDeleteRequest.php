<?php

declare(strict_types=1);

namespace App\Domains\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserDeleteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'userId' => 'sometimes|int|exists:users,id',
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
