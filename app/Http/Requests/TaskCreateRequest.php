<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class TaskCreateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'status' => 'required'
        ];
    }
}
