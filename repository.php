<?php
class TaskRepository
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getProjects($userId)
    {
//        $stmt = $this->pdo->prepare("
//            SELECT p.id, p.name
//            FROM projects p
//            WHERE p.created_by = :user_id
//        ");
//        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
//        $stmt->execute();
//        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTasks($userId, $projectId = null)
    {
//        $sql = "
//        SELECT
//            t.id,
//            t.created_date,
//            t.status,
//            t.title,
//            t.file_link,
//            t.due_date,
//            t.project_id
//        FROM tasks t
//        JOIN users u ON t.author_id = u.id
//        WHERE u.id = :user_id
//    ";
//
//        if ($projectId !== null) {
//            $sql .= " AND t.project_id = :project_id";
//        }
//
//        $stmt = $this->pdo->prepare($sql);
//        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
//        if ($projectId !== null) {
//            $stmt->bindValue(':project_id', $projectId, PDO::PARAM_INT);
//        }
//        $stmt->execute();
//        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getTasksByProject($userId, $projectId)
    {
//        return $this->getTasks($userId, $projectId);
    }

    public function countTasks($projectId, $authorId)
    {

    }
}
