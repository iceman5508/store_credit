<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class NewCustomerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $store = Auth::user()->store->id;
        return [
            'name' => 'required|min:3',
            'email' => ['required', 'min:5', 'email', 'unique:users',
                        Rule::unique('users','email')->where('store_id', $store)],
            'credit' => 'required|numeric|between:0,99999999999999'
        ];
    }



    public function messages()
    {
       return[
           'email.unique' => 'A customer with this email already exists.'
       ];
    }
}
