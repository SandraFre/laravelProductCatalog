<?php

declare(strict_types=1);

namespace  Modules\Customer\DTO;

use App\DTO\Abstracts\DTO;
use App\Enum\CustomerAuthLogTypeEnum;
use App\UserAuthLog;

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
