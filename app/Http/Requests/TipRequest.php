<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TipRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        public function authorize()
        {
            if ($this->path() == 'payment/tip/done/{id}'){
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'price' => 'required',
        ];
    }
    public function messages(){
        return [
           'price.required' => '値段をご記入ください。',
        ];
    }
}
