<?php

class TaskRepository
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getTasksByUserId($userId)
    {
        $sql = "SELECT * FROM tasks WHERE user_id = :userId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTasksByProjectId($projectId)
    {
        $sql = "SELECT * FROM tasks WHERE project_id = :projectId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':projectId', $projectId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createTask($userId, $projectId, $name, $file, $dateTerm, $status = 'new')
    {
        $sql = "INSERT INTO tasks (user_id, project_id, name, file, date_add, date_term, status)
            VALUES (:userId, :projectId, :name, :file, NOW(), :dateTerm, :status)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':projectId', $projectId, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':file', $file, PDO::PARAM_STR);
        $stmt->bindParam(':dateTerm', $dateTerm, PDO::PARAM_STR);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        if (empty($dateTerm)) {
            $stmt->bindValue(':dateTerm', null, PDO::PARAM_NULL);
        }

        return $stmt->execute();
    }

    public function countTasksByProjectId($projectId)
    {
        $sql = "SELECT COUNT(*) as task_count FROM tasks WHERE project_id = :projectId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':projectId', $projectId, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['task_count'];
    }

}