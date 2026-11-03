<?php

namespace App\Controller;

use App\Core\Validation;
use App\User;
use PDO;

class AuthController
{
    public function register(PDO $pdo)
    {
    

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $role = trim($_POST['role'] ?? 'patient');
        if (empty($role)) {
            $role = 'patient';
        }
        
        $password = trim($_POST['password'] ?? '');
        $confirm_password = trim($_POST['confirm_password'] ?? '');
        $errors = Validation::validate_register_data($name, $email, $password, $confirm_password, $phone, $role);
///////1
        if (empty($errors['email'])) {
            $existingUser = User::findByEmail($pdo, $email);
            if ($existingUser) {
                $errors['email'] = "Email is already registered.";
            }
        }
///////2
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = [
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
            ];

            header("Location: index.php?page=register");
            exit;
        }
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        ///////////3
        $user = User::create($pdo, $name, $email, $role, $hashedPassword, $phone);

        if ($user) {
            unset($_SESSION['old']);
            setmessage("Registration successful Please login.", "success");
            header("Location: index.php?page=login");
            exit;
        } else {
            setmessage("Registration failed Please try again.", "danger");
            header("Location: index.php?page=register");
            exit;
        }
    }
///////////////////////////////////////////////////////////
    public function login(PDO $pdo)
    {


        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $errors = Validation::validate_login_data($email, $password);

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header("Location: index.php?page=login");
            exit;
        }

        $user = User::findByEmail($pdo, $email);

        if (!$user || !password_verify($password, $user->password)) {
            $_SESSION['errors'] = [
                'login' => 'Invalid email or password.'
            ];

            header("Location: index.php?page=login");
            exit;
        }
        session_regenerate_id(true);//دي مهمه هتغ id سيشن القديمه 

        $_SESSION['user'] = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
        ];
        if ($user->role === 'admin') {
        header("Location: index.php?page=admin-dashboard");
        } elseif ($user->role === 'doctor') {
        header("Location: index.php?page=doctor-dashboard");
        } else {
            header("Location: index.php?page=home");
        }  

        setmessage("Welcome back, " . htmlspecialchars($user->name), "success");
        header("Location: index.php?page=home");
        exit;
    }
/////////////////////////////////////////
    public function logout()
    {
        $_SESSION = [];
        if (session_status() === PHP_SESSION_ACTIVE) { 
            session_destroy();
        }

        header("Location: index.php?page=login");
        exit;
    }
}
