<?php

declare(strict_types=1);

namespace App\DTO\Abstracts;

use App\DTO\Abstracts\DTO;

class PaginateDTO extends DTO
{
    protected $content;

    public function __construct()
    {
        $this->content = collect();
    }

    public function setData(?DTO $data = null): PaginateDTO
    {
        if ($data === null) {
            $data = [];
        }

        $this->content->put('items', $data);

        return $this;
    }

    public function setCurrentPage(int $currentPage): PaginateDTO
    {
        $this->content->put('current_page', $currentPage);

        return $this;
    }

    public function setTotal(int $total): PaginateDTO
    {
        $this->content->put('total', $total);

        return $this;
    }

    public function setPerPage(int $perPage): PaginateDTO
    {
        $this->content->put('per_page', $perPage);

        return $this;
    }

    public function setFirstPageUrl(string $url): PaginateDTO
    {
        $this->content->put('first_page_url', $url);

        return $this;
    }

    public function setLastPageUrl(string $url): PaginateDTO
    {
        $this->content->put('last_page_url', $url);

        return $this;
    }

    public function setNextPageUrl(?string $url=null): PaginateDTO
    {
        $this->content->put('next_page_url', $url);

        return $this;
    }

    public function setPrevPageUrl(?string $url=null): PaginateDTO
    {
        $this->content->put('prev_page_url', $url);

        return $this;
    }



    protected function jsonData(): array
    {
        return $this->content->toArray();
    }
}
