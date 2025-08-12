<?php

declare(strict_types=1);

namespace App\Application\Services;

use App\Application\DTOs\Responses\GenericResponse;
use App\Application\DTOs\UserRegisterDto;
use App\Application\Interfaces\UserServiceInterface;
use App\Application\Validators\EmailValidator;
use App\Application\Validators\PasswordValidator;
use App\Core\Enums\UserLogAction;
use App\Domain\Interfaces\UserRepositoryInterface;
use App\Domain\Interfaces\UserLogRepositoryInterface;
use DateTime;

class UserService implements UserServiceInterface
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly UserLogRepositoryInterface $userLogRepository,
        private readonly EmailValidator $emailValidator,
        private readonly PasswordValidator $passwordValidator,
        private readonly MaxMindService $maxMindService,
    ) {}

    public function register(UserRegisterDto $user): GenericResponse
    {
        //Dodala sam jer nemam logout
        $_SESSION['userId'] = null;

        $emailCheck = $this->emailValidator->validate($user->email);
        if (!$emailCheck->success) {
            return new GenericResponse(success: false, errorMessage: $emailCheck->errorMessage);
        }

        $maxMindCheck = $this->maxMindService->simulateMaxMindCheck($user->email, $user->ipAddress);
        if (!$maxMindCheck->success) {
            return new GenericResponse(success: false, errorMessage: $maxMindCheck->errorMessage);
        }

        $passwordCheck = $this->passwordValidator->validate($user->password, $user->password2);
        if (!$passwordCheck->success) {
            return new GenericResponse(success: false, errorMessage: $passwordCheck->errorMessage);
        }

        $userId = $this->userRepository->register($user);

        if (!$userId) {
            return new GenericResponse(success: false, errorMessage: 'Registration error');
        }

        mail(
            $user->email,
            'Dobro došli',
            'Dobro dosli na nas sajt. Potrebno je samo da potvrdite email adresu ...',
            'adm@kupujemprodajem.com'
        );

        $this->userLogRepository->whriteLog($userId, UserLogAction::Register);
        $_SESSION['userId'] = $userId;

        return new GenericResponse(success: true);
    }

    public function getLogsForUser(int $userId): array
    {
        return $this->userLogRepository->getByUserId($userId);
    }

    public function filterByLogTime(string|DateTime $condition): array
    {
        return $this->userLogRepository->filterByLogTime($condition);
    }
}
