<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;

class AdminUpdateRequest extends AdminStoreRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
         return [
            'name' => 'nullable|string|max:30',
            'last_name' => 'nullable|string|max:50',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('admins')->ignore($this->route()->parameter('admin')->id)
            ],
            'password' => 'required|string|confirmed|min:8',
            'active' => 'boolean'
        ];
    }
}
