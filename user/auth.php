<?php
namespace Clinic;

// Replaces: login, logout, currentUser, requireLogin
class Auth
{
    public function __construct(private UserFunctions $users)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function login(int $userId): void
    {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $userId;
    }

    // Check email + password; log the user in on success
    public function attempt(string $email, string $password): bool
    {
        $user = $this->users->findByEmail($email);
        if ($user && $user->verifyPassword($password)) {
            $this->login($user->getId());
            return true;
        }
        return false;
    }

    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();
    }

    public function user(): ?User
    {
        if (empty($_SESSION['user_id'])) {
            return null;
        }
        return $this->users->findById((int)$_SESSION['user_id']);
    }

    public function requireLogin(): User
    {
        $user = $this->user();
        if (!$user) {
            header('Location: login.php');
            exit;
        }
        return $user;
    }
}