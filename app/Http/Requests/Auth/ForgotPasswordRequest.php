<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class ForgotPasswordRequest extends FormRequest
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
			'email' => 'required|string|email|max:50'
        ];
    }

	/**
	 * Get the error messages for the defined validation rules.
	 *
	 * @return array
	 */
	public function messages(): array
	{
		return [
			'email.required' => 'Email é obrigatório.',
			'email.string' => 'Email deve ser string.',
			'email.max' => 'Email deve ter no máximo 50 caracteres.',
			'email.email' => 'Email não é válido.',
		];
	}

	protected function failedValidation(Validator $validator)
	{
		$errors = (new ValidationException($validator))->errors();
		throw new HttpResponseException(
			response()->json(['message' => 'Dados fornecidos inválidos', 'errors' => $errors], JsonResponse::HTTP_UNPROCESSABLE_ENTITY)
		);
	}
}
