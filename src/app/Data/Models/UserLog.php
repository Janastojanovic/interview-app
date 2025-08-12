<?php

declare(strict_types=1);

namespace App\Data\Models;

use App\Core\Enums\UserLogAction;

class UserLog
{
    private int $id;
    private UserLogAction $action;
    private int $userId;
    private \DateTime $logTime;

    public function __construct(int $id, UserLogAction $action, int $userId, \DateTime $logTime)
    {
        $this->id = $id;
        $this->action = $action;
        $this->userId = $userId;
        $this->logTime = $logTime;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
