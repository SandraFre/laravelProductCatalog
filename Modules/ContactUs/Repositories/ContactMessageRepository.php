<?php

declare(strict_types=1);

namespace Modules\ContactUs\Repositories;

use Modules\ContactUs\Entities\ContactMessage;
use Modules\Core\Repositories\Repository;

class ContactMessageRepository extends Repository
{
    public function model(): string
    {
        return ContactMessage::class;
    }
}
