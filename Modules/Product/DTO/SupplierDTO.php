<?php

declare(strict_types=1);

namespace Modules\Product\DTO;

use Modules\Product\Entities\Supply;
use Modules\Core\DTO\DTO;
use Illuminate\Support\Facades\Storage;

/**
 * Class CategoryDTO
 * @package App\DTO
 */
class SupplierDTO extends DTO
{
    private $supply;

    public function __construct(Supply $supply)
    {
        $this->supply = $supply;
    }

    protected function jsonData(): array
    {
        return [
            'title' => $this->supply->title,
            'logo' => $this->supply->logo ? Storage::url($this->supply->logo) : null,
        ];
    }
}
