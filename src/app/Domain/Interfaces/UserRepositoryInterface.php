<?php

declare(strict_types=1);

namespace App\Domain\Interfaces;

use App\Application\DTOs\UserRegisterDto;
use App\Data\Models\User;

interface UserRepositoryInterface extends GenericRepositoryInterface
{
    public function findByEmail(string $email): ?User;
    public function register(UserRegisterDto $user): ?int;
    public function isMailTaken(string $email): bool;
}
