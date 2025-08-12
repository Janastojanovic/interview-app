<?php

declare(strict_types=1);

namespace App\Application\Interfaces;

use App\Application\DTOs\Responses\GenericResponse;
use App\Application\DTOs\UserRegisterDto;
use DateTime;

interface UserServiceInterface
{
    public function register(UserRegisterDto $user): GenericResponse;
    public function getLogsForUser(int $userId): array;
    public function filterByLogTime(string|DateTime $condition): array;
}
