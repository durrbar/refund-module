<?php

namespace Modules\Refund\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Modules\Refund\Enums\RefundPolicyStatus;
use Modules\Refund\Enums\RefundPolicyTarget;
use Modules\Vendor\Models\Shop;

class UpdateRefundPolicyRequest extends FormRequest
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
            'title' => ['string', 'string', 'max  : 255'],
            'target' => ['string', 'max:255', Rule::in(RefundPolicyTarget::getValues())],
            'status' => ['string', 'max:255', Rule::in(RefundPolicyStatus::getValues())],
            'slug' => ['nullable', 'string', 'max: 255'],
            'description' => ['nullable', 'string', 'max:10000'],
            'shop_id' => ['nullable', 'exists:'.Shop::class.',id'],
            'language' => ['nullable', 'string'],
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
