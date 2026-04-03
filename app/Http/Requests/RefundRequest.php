<?php

declare(strict_types=1);

namespace Modules\Refund\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RefundRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'order_id' => ['required', 'exists:Modules\Ecommerce\Models\Order,id'],
            'title' => ['string'],
            'description' => ['string', 'nullable', 'max:10000'],
            'images' => ['array', 'nullable'],
            'refund_reason_id' => ['exists:Modules\Ecommerce\Models\RefundReason,id'],
        ];
    }

    public function failedValidation(Validator ): void
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
