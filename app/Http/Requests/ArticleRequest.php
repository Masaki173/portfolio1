<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    public function authorize()
    {
        if ($this->path() == 'store'){
            return true;
        } else {
            return false;
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
            'title' => 'required',
            'content' => 'required',
            'is_fee' => 'required',
        ];
    }
    public function messages(){
        return [
           'title.required' => 'タイトルをご記入ください。',
           'content.required' => '記事の本文をご記入ください。',
          'is_fee.required' => '無料記事と有料記事から記事の種類をお選びください。',
        ];
    }
}
