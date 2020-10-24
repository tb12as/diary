<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class AdminRequest extends FormRequest
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
    public function rules(Request $request)
    {
        if ($request->admin_id) { // update
            return [
                'name' => 'required|min:3',
                'email' => 'required|email',
                'password' => $request->password ? 'min:4' : '',
            ];    
        } else {
            return [
                'name' => 'required|min:3',
                'email' => 'required|unique:users|email',
                'password' => 'required|min:4',
            ];
        }
    }
}
