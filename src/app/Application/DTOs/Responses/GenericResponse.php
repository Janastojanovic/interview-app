<?php

declare(strict_types=1);

namespace App\Application\DTOs\Responses;

class GenericResponse
{
    public bool $success;
    public ?string $errorMessage;

    public function __construct(bool $success = false, ?string $errorMessage = null)
    {
        $this->success = $success;
        $this->errorMessage = $errorMessage;
    }
}
