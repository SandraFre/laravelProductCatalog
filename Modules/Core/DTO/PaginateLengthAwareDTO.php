<?php
declare(strict_types=1);

namespace Modules\Core\DTO;

use Modules\Core\DTO\PaginateDTO;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PaginateLengthAwareDTO extends PaginateDTO
{
    private $paginator;

    public function __construct(LengthAwarePaginator $paginator)
    {
        parent::__construct();

        $this->paginator = $paginator;

        $this->setDefaultData();
    }

    private function setDefaultData(): void
    {
        $lastPage = $this->paginator->lastPage();

        $this->setCurrentPage($this->paginator->currentPage())
        ->setData()
        ->setTotal($this->paginator->total())
        ->setPerPage($this->paginator->perPage())
        ->setFirstPageUrl($this->paginator->url(1))
        ->setLastPageUrl($this->paginator->url($lastPage))
        ->setNextPageUrl($this->paginator->nextPageUrl())
        ->setPrevPageUrl($this->paginator->previousPageUrl());
    }



}
