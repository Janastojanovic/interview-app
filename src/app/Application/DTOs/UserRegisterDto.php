<?php

declare(strict_types=1);

namespace App\Application\DTOs;

class UserRegisterDto
{
    public string $email;
    public string $password;
    public ?string $password2;
    public ?string $ipAddress;

    public function __construct(string $email, string $password, string $password2, string $ipAddress)
    {
        $this->email = $email;
        $this->password = $password;
        $this->password2 = $password2;
        $this->ipAddress = $ipAddress;
    }
}
