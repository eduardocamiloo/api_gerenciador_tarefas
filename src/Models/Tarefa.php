<?php

namespace Src\Models;

use PDO;
use PDOException;
use Src\Models\Services\DbConnection;

final class Tarefa extends DbConnection
{
    public function all(): array|bool
    {
        try {
            $query = "SELECT * FROM tarefas";
            $stmt = $this->getConnection()->prepare($query);

            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getById(int $id): array|bool
    {
        try {
            $query = "SELECT * FROM tarefas WHERE id = :id LIMIT 1";
            $stmt = $this->getConnection()->prepare($query);

            $stmt->bindValue("id", $id, PDO::PARAM_INT);

            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function create(array $data): bool
    {
        try {
            $query = "INSERT INTO tarefas (title, description, isCompleted) VALUES (:title, :description, :isCompleted)";
            $stmt = $this->getConnection()->prepare($query);

            $stmt->bindValue("title", $data["title"], PDO::PARAM_STR);
            $stmt->bindValue("description", $data["description"], PDO::PARAM_STR);
            $stmt->bindValue("isCompleted", $data["isCompleted"], PDO::PARAM_BOOL);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update(int $id, string $selectedParams, array $data): bool
    {
        try {
            $query = "UPDATE tarefas SET $selectedParams WHERE id = :id";
            $stmt = $this->getConnection()->prepare($query);

            $stmt->bindValue("id", $id, PDO::PARAM_INT);

            if (isset($data["title"])) {
                $stmt->bindValue("title", $data["title"], PDO::PARAM_STR);
            }
            if (isset($data["description"])) {
                $stmt->bindValue("description", $data["description"], PDO::PARAM_STR);
            }
            if (isset($data["isCompleted"])) {
                $stmt->bindValue("isCompleted", $data["isCompleted"], PDO::PARAM_BOOL);
            }

            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete(int $id)
    {
        try {
            $query = "DELETE FROM tarefas WHERE id = :id";
            $stmt = $this->getConnection()->prepare($query);

            $stmt->bindValue("id", $id, PDO::PARAM_INT);

            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }
}
