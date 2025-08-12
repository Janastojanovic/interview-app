<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\DTOs\Responses\GenericResponse;

class MaxMindService
{
    public function simulateMaxMindCheck(string $email, string $ip): GenericResponse
    {
        $badPatterns = ['bad', 'fraud', 'test'];

        foreach ($badPatterns as $pattern) {
            if (stripos($email, $pattern) !== false || stripos($ip, $pattern) !== false) {
                return new GenericResponse(success: true);
            }
        }

        return new GenericResponse(success: false, errorMessage: 'MaxMind error');
    }
}
