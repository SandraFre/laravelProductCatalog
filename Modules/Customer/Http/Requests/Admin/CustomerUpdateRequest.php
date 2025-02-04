<?php

declare(strict_types = 1);

namespace Modules\Customer\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CustomerUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->route()->parameter('customer')->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
        ];
    }

    public function getName(): string
    {
        return $this->input('name');
    }

    public function getEmail(): string
    {
        return $this->input('email');
    }

    public function getHashPassword(): ?string
    {
        $pass = $this->input('password');

        if ($pass !==null) {
           $pass = Hash::make($pass);
        }

        return $pass;
    }

}
