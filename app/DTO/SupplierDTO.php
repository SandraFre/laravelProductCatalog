<?php

declare(strict_types=1);

namespace App\DTO;

use App\Supply;
use App\DTO\Abstracts\DTO;
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
