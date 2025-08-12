<?php

declare(strict_types=1);

namespace App\Presentation\Helpers;

class JsonResponseHelper
{
    public static function sendJsonResponse($data, int $statusCode = 200): void
    {
        if ($_SESSION['userId'] != null) {

            if (is_object($data)) {
                $data = (array) $data;
                $data['userId'] = $_SESSION['userId'];
                unset($data['errorMessage']);
            }
        }

        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
    }
}
