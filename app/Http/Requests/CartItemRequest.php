<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartItemRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => ['required', 'exists:users'],
            'product_id' => ['required', 'exists:products'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
