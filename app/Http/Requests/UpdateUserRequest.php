<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'=> ["required","max:255"],
            'password'=> ["required","max:255","min:6"],
            'avatar_image'=> ["nullable","mimes:jpg,png","size:4096"],
            'national_id'=> ["required","max:14","unique:users,national_id," . $this->user->id],
            'email'=> ["required","max:255","unique:users,email," . $this->user->id],
            'date_of_birth'=> ["required","date"],
            'gender'=> ["required",Rule::in(["1","2"])],
            'phone' => ["required"]
        ];
    }
}
