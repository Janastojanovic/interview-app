<?php

declare(strict_types=1);

namespace App\Presentation\Controllers;

use App\Application\DTOs\UserRegisterDto;
use App\Application\Interfaces\UserServiceInterface;
use App\Core\Attributes\Get;
use App\Core\Attributes\Post;
use App\Core\View;
use App\Presentation\Helpers\IPAddressHelper;
use App\Presentation\Helpers\JsonResponseHelper;
use DateTime;

class UserController
{
    public function __construct(private readonly UserServiceInterface $userService) {}

    #[Get('/')]
    public function create(): View
    {
        return View::make('/register');
    }

    #[Post('/register')]
    public function register()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];

        $id = IPAddressHelper::getUserIp();

        $response = $this->userService
            ->register(new UserRegisterDto(
                $email,
                $password,
                $password2,
                $id
            ));

        if ($response->success) {
            JsonResponseHelper::sendJsonresponse($response, 200);
        } else {
            JsonResponseHelper::sendJsonresponse($response, 400);
        }

    }

    #[Get('/user-logs-interval')]
    public function filterUserLogsByLogTime(): View
    {
        //za odredjeni datum
        //$condition = new DateTime('today');

        $condition = '> NOW() - INTERVAL 10 DAY';
        $userLogs = $this->userService->filterByLogTime($condition);
        return View::make('/user-logs', ['userLogs' => $userLogs]);
    }

    #[Get('/user-logs')]
    public function getLogsForUser(): View
    {
        $userId =  $_SESSION['userId'];
        $userLogs = $this->userService->getLogsForUser($userId);
        return View::make('/user-logs', ['userLogs' => $userLogs]);
    }
}
