<?php
class SessionManager
{
    public function startSession()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function getSessionValue($key)
    {
        $this->startSession();
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public function setSessionValue($key, $value)
    {
        $this->startSession();
        $_SESSION[$key] = $value;
    }

    public function destroySession()
    {
        $this->startSession();
        session_unset();
        session_destroy();
    }
}
