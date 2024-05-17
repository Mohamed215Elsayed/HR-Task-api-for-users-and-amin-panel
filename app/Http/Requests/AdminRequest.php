<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use App\Http\Controllers\API\ApiRequest;
class AdminRequest extends ApiRequest
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
            'username' => 'required|min:3|max:255',
            'mobile_number' => 'required|unique:users,mobile_number|digits:11',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|min:8',
            'is_admin' => 'required',
        ];
            
        ];
    }
}
