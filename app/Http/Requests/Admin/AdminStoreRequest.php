<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class AdminStoreRequest extends FormRequest
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
    public function rules() : array
    {
        return [
            'name' => 'nullable|string|max:30',
            'last_name' => 'nullable|string|max:50',
            'email' => 'required|string|email|unique:admins|max:255',
            'password' => 'required|string|confirmed|min:8',
            'active' => 'boolean'
        ];
    }

    public function getData(): array
    {
        return [
            'name' => $this->getName(),
            'last_name' => $this->getLastName(),
            'email' => $this->getEmail(),
            'password' => $this->getPass(),
            'active' => $this->getActive()
        ];
    }

    private function getName(): ?string
    {
        return $this->input('name');
    }

    private function getLastName(): ?string
    {
        return $this->input('last_name');
    }

    private function getEmail(): string
    {
        return $this->input('email');
    }

    private function getPass(): string
    {
        return Hash::make($this->input('password'));
    }

    private function getActive(): bool
    {
        return (bool) $this->input('active');
    }
}
