<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:50'],
            'description' => ['string', 'max:2000'],
            'image' => ['mimes:jpeg, jpg, png'],
            'buying_price' => ['required'],
            'selling_price' => ['required'],
            'count' => ['required'],
            'category' => ['required'],
            'code' => ['required', 'unique:products']
        ];
    }
}
