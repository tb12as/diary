<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveProfilePictureReequest extends FormRequest
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
            'profile_img' => 'required|image|max:2024'
        ];
    }

    public function messages()
    {
        return [            
            'profile_img.max' => "Maximum file size to upload is 2MB (2024 KB)"
        ];
    }
}
