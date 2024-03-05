<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string'],
            'description' => ['required', 'string', 'min:10'],
            'category_id' => ['required', 'exists:categories,id']
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $rules['status'] = ['required', 'in:completed,incomplete'];
        }


        return $rules;
    }
}
