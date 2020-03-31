<?php

declare(strict_types=1);


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
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
            'title' => 'required|string|max:255|min:3',
            'active' => 'nullable|boolean',
        ];
    }

    public function getData(): array
    {
        return [
            'title' => $this->getTitle(),
            'active' => $this->getActive(),
        ];
    }

    public function getTitle(): string
    {
        return $this->input('title');
    }

    public function getActive(): bool
    {
        return (bool) $this->input('active');
    }
}
