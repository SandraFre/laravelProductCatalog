<?php

declare(strict_types=1);

namespace Modules\Product\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class SupplyStoreRequest extends FormRequest
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
    public function rules()
    {
        return [
            'title' => 'required|string|max:100',
            'logo'=> 'nullable|image',
            'phone'=> 'required|max:30|min:4',
            'email'=> 'required|email|max:100',
            'address'=> 'nullable|max:255',
        ];
    }

    public function getData(): array
    {
        return [
            'title' => $this->getTitle(),
            'phone'=> $this->getPhone(),
            'email'=>$this->getEmail(),
            'address'=> $this->getAddress(),
            'logo' =>$this->getLogoPath(),
        ];
    }

    protected function getTitle(): string {
        return $this->input('title');
    }

    protected function getPhone(): string {
        return (string)$this->input('phone');
    }

    protected function getEmail(): string {
        return $this->input('email');
    }

    protected function getAddress(): ?string {
        return $this->input('address');
    }

    public function getLogoPath(): ?string
    {
        $image = $this->getLogo();

        if ($image == null){
            return null;
        }

        return $image->store('supply');

    }

    public function getLogo(): ?UploadedFile
    {
        return $this->file('logo');
    }

}
