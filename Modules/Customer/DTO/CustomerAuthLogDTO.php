<?php

declare(strict_types=1);

namespace  Modules\Customer\DTO;

use Modules\Core\DTO\DTO;
use Modules\Customer\Enum\CustomerAuthLogTypeEnum;
use Modules\Customer\Entities\UserAuthLog;

class CustomerAuthLogDTO extends DTO
{

    private UserAuthLog $authLog;

    public function __construct(UserAuthLog $authLog) {
        $this->authLog = $authLog;
    }

    protected function jsonData(): array
    {
        return [
            'token_id' => $this->authLog->token_id,
            'event_time' => $this->authLog->event_time->timestamp,
            'type' => CustomerAuthLogTypeEnum::from($this->authLog->type)->name() ,
        ];
    }

}
