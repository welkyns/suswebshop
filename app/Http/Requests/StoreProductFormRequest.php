<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductFormRequest extends FormRequest
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
            'name'      =>  'required|max:255',
            'sku'       =>  'required',
            'brand_id'  =>  'required|not_in:0',
            'price'     =>  'required|regex:/^\d+(\.\d{1,2})?$/',
            'special_price'     =>  'regex:/^\d+(\.\d{1,2})?$/',
            'quantity'  =>  'required|numeric',
        ];
    }
}
