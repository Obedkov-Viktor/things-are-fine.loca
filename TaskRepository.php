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

    public function getTasksByFilter($userId, $filter)
    {
        $sql = "SELECT * FROM tasks WHERE user_id = :userId";
        if ($filter === 'today') {
            $sql .= " AND DATE(date_term) = CURDATE()";
        } elseif ($filter === 'tomorrow') {
            $sql .= " AND DATE(date_term) = CURDATE() + INTERVAL 1 DAY";
        } elseif ($filter === 'overdue') {
            $sql .= " AND DATE(date_term) < CURDATE()";
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateTaskStatus($taskId, $status)
    {
        $sql = "UPDATE tasks SET status = :status WHERE id = :taskId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':taskId', $taskId, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        return $stmt->execute();
    }
}