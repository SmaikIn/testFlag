<?php
declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'order_payment_type_id' => ['required', 'exists:order_payment_types'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
