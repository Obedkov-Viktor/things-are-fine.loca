<?php
class UserRegistration {
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function registerUser($email, $password, $name) {
        try {
            // Хеширование пароля (например, с помощью bcrypt)
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Получение текущей даты и времени
            $created_at = date('Y-m-d H:i:s');

            $stmt = $this->pdo->prepare("INSERT INTO users (email, password, name, created_at) VALUES (:email, :password, :name, :created_at)");
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':created_at', $created_at);

            if ($stmt->execute()) {
                return "Регистрация успешна!";
            } else {
                return "Ошибка: " . implode(", ", $stmt->errorInfo());
            }
        } catch(PDOException $e) {
            return "Ошибка: " . $e->getMessage();
        }
    }

}