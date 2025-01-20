<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:40'], // Each rule is a separate array element
            'description' => ['nullable', 'string'],
            'priority' => ['required', 'in:high,medium,low'],
            //'user_id' => 'required|exists:users,id'
        ];
    }

    // customize error message
    public function messages()
    {
        return [
            'title.required' => 'The title field is required from samih.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title must not exceed 40 characters.',

            'description.string' => 'The description must be a valid string.',

            'priority.required' => 'The priority field is required.',
            'priority.integer' => 'The priority must be a valid integer.',
            'priority.between' => 'The priority must be between 1 and 5.',
        ];
    }
}
