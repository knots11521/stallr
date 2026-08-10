<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [

            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
            ],

            'price' => [
                'sometimes',
                'required',
                'numeric',
                'min:1',
            ],

            'stock' => [
                'sometimes',
                'required',
                'integer',
                'min:0',
            ],

            'description' => [
                'sometimes',
                'required',
                'string',
            ],

            'categories' => [
                'sometimes',
                'array',
            ],

            'categories.*' => [
                'exists:categories,id',
            ],

            'images.*' => [
                'image',
                'max:2048',
            ],

        ];
    }
}
