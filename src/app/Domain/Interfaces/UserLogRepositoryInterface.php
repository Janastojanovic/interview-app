<?php

declare(strict_types=1);

namespace App\Domain\Interfaces;

use App\Core\Enums\UserLogAction;
use DateTime;

interface UserLogRepositoryInterface extends GenericRepositoryInterface
{
    public function whriteLog(int $userId, UserLogAction $action): int;
    public function getByUserId(int $userId): array;
    public function filterByLogTime(string|DateTime $condition): array;
}
