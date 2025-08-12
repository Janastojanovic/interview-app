<?php

declare(strict_types=1);

namespace App\Data\Models;

class User
{
    private int $id;
    private string $email;
    private string $password;

    public function __construct(int $id, string $email, string $password)
    {
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}
