<?php
declare(strict_types=1);

namespace Modules\ContactUs\Tests\Unit\Services;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\ContactUs\Entities\ContactMessage;
use Modules\ContactUs\Services\ContactMessageService;

class ContactMessageServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @group contact_us
     * @group service
     * @group contact_us_service
     */
    public function testStoreData(): void
    {
        $data = factory(ContactMessage::class)->make();

        $contactMessage = $this->getTestClassInstance()->storeData($data->toArray());

        $this->assertInstanceOf(ContactMessage::class, $contactMessage);
        $this->assertDatabaseHas('contact_messages', $data->toArray());
    }

    private function getTestClassInstance(): ContactMessageService
    {
        return $this->app->make(ContactMessageService::class);
    }
}
