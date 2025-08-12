<?php

declare(strict_types=1);

namespace App\Application\Validators;

use App\Application\DTOs\Responses\GenericResponse;

class PasswordValidator
{
    public function validate(string $password, string $password2): GenericResponse
    {
        $messages = [];

        if (empty($password) || empty($password2)) {

            return (new GenericResponse(success: false, errorMessage: "Passwords can't be empty"));
        }

        if (mb_strlen($password) < 8 || mb_strlen($password2) < 8) {
            $messages[] = "Passwords must be at least 8 characters long.";
        } elseif ($password != $password2) {
            $messages[] = "Passwords must be same.";
        }

        if (!empty($messages)) {
            return new GenericResponse(success: false, errorMessage: implode("|", $messages));
        }

        return new GenericResponse(success: true);
    }
}
