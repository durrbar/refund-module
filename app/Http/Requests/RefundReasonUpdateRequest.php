<?php

declare(strict_types=1);

namespace Modules\Refund\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RefundReasonUpdateRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255'],
        ];
    }

    /**
     * Get the error messages that apply to the request parameters.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.string' => 'Name is not a valid string',
            'name.max:255' => 'Name can not be more than 255 character',
        ];
    }

    public function failedValidation(Validator ): void
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
