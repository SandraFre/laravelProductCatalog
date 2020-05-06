<?php

declare(strict_types=1);

namespace Modules\ContactUs\Services;

use Modules\ContactUs\Entities\ContactMessage;
use Modules\ContactUs\Repositories\ContactMessageRepository;

class ContactMessageService
{
    private ContactMessageRepository $messageRepository;

    public function __construct(ContactMessageRepository $messageRepository) {
        $this->messageRepository = $messageRepository;
    }

    public function storeData(array $data): ContactMessage
    {
        return $this->messageRepository->create($data);
    }


}
