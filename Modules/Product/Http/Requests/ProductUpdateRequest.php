<?php

declare(strict_types=1);

namespace Modules\Product\Http\Requests;

use Modules\Product\Entities\Product;

class ProductUpdateRequest extends ProductStoreRequest
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
        return array_merge(
            parent::rules(),
            [
                'delete_images' => 'boolean',
            ]
        );
    }

    public function getData(): array
    {
        return array_merge(
            parent::getData(),
            [
                'categories'=>$this->getCategories(),
                'suppliers'=>$this->getSuppliers(),
                'images'=>$this->getImages(),
            ]
            );
    }

    /**
     * @return bool
     */
    protected function slugExists(): bool
    {
        return Product::query()
            ->where('slug', '=', $this->getSlug())
            ->where('id', '!=', $this->route()->parameter('product'))
            ->exists();
    }

    public function getDeleteImages(): bool
    {
        return (bool)$this->input('delete_images');
    }
}
