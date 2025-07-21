<?php

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
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'order_id' => ['required', 'exists:Modules\Ecommerce\Models\Order,id'],
            'title' => ['string'],
            'description' => ['string', 'nullable', 'max:10000'],
            'images' => ['array', 'nullable'],
            'refund_reason_id' => ['exists:Modules\Ecommerce\Models\RefundReason,id'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
