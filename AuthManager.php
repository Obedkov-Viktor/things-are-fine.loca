<?php
class AuthManager
{
    private $userRepository;
    private $sessionManager;

    public function __construct(UserRepository $userRepository, SessionManager $sessionManager)
    {
        $this->userRepository = $userRepository;
        $this->sessionManager = $sessionManager;
    }

    public function login($email, $password)
    {
        $user = $this->userRepository->getUserByEmail($email);
        if ($user && password_verify($password, $user['password'])) {
            $this->sessionManager->startSession();
            $this->sessionManager->setSessionValue('user_id', $user['id']);
            $this->sessionManager->setSessionValue('user_name', $user['name']);
            return true;
        }
        return false;
    }

    public function logout()
    {
        $this->sessionManager->destroySession();
    }

    public function isLoggedIn()
    {
        $this->sessionManager->startSession();
        return $this->sessionManager->getSessionValue('user_id') !== null;
    }

    public function getCurrentUser()
    {
        $userId = $this->sessionManager->getSessionValue('user_id');
        $userName = $this->sessionManager->getSessionValue('user_name');
        return ['id' => $userId, 'name' => $userName];
    }
}
