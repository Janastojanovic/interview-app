<?php

declare(strict_types=1);

namespace App\Data;

use App\Core\SqlExpression;
use PDO;

/**
 * @mixin PDO
 */
class DB
{
    private PDO $pdo;

    public function __construct(array $config)
    {
        $defaultOptions = [
            PDO::ATTR_EMULATE_PREPARES   => false,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        try {
            $this->pdo = new PDO(
                $config['driver'] . ':host=' . $config['host'] . ';dbname=' . $config['database'],
                $config['user'],
                $config['pass'],
                $config['options'] ?? $defaultOptions
            );
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int) $e->getCode());
        }
    }

    public function __call(string $name, array $arguments)
    {
        return call_user_func_array([$this->pdo, $name], $arguments);
    }

    public function insert(string $table, array $data): int
    {
        $columns = [];
        $placeholders = [];
        $params = [];

        foreach ($data as $column => $value) {
            $columns[] = $column;

            if ($value instanceof SqlExpression) {
                $placeholders[] = $value->getExpression();
            } else {
                $placeholders[] = ':' . $column;
                $params[':' . $column] = $value;
            }
        }

        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            $table,
            implode(', ', $columns),
            implode(', ', $placeholders)
        );

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return (int)$this->pdo->lastInsertId();
    }

    public function selectWithCondition(string $table, array $conditions)
    {
        $whereParts = [];
        $params = [];

        foreach ($conditions as $column => $value) {
            if ($value instanceof SqlExpression) {
                $whereParts[] = "$column " . $value->getExpression();
            } elseif ($value instanceof \DateTimeInterface) {
                $whereParts[] = "DATE($column) = :$column";
                $params[":$column"] = $value->format('Y-m-d');
            } else {
                $whereParts[] = "$column = :$column";
                $params[":$column"] = $value;
            }
        }

        $sql = "SELECT * FROM $table WHERE " . implode(' AND ', $whereParts);
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
