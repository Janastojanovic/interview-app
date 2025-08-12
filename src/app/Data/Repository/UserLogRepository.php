<?php

declare(strict_types=1);

namespace App\Data\Repository;

use App\Core\Enums\UserLogAction;
use App\Core\SqlExpression;
use App\Domain\Interfaces\UserLogRepositoryInterface;
use DateTime;

class UserLogRepository extends GenericRepository implements UserLogRepositoryInterface
{
    public function whriteLog(int $userId, UserLogAction $action): int
    {
        return $this->db->insert("user_logs", [
            "action" => $action->value,
            "user_id" => $userId,
            "log_time" => new SqlExpression("NOW()")
            //u slucaju da treba da se pamti u bazi u nasoj vremenskoj zoni:
            //"log_time" => new SqlExpression("CONVERT_TZ(NOW(), 'UTC', 'Europe/Belgrade')") 
        ]);
    }

    public function getByUserId(int $userId): array
    {
        return $this->db->selectWithCondition('user_logs', ["user_id" => $userId]);
    }

    public function filterByLogTime(string|DateTime $condition): array
    {
        if (is_string($condition)) {
            return $this->db->selectWithCondition('user_logs', ["log_time" => new SqlExpression($condition)]);
        }
        return $this->db->selectWithCondition('user_logs', ["log_time" => $condition]);
    }
}
