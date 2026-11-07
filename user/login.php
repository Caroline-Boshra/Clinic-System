<?php
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/../core/functions.php';


$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $user     = findUserByEmail($email);

    if ($user && password_verify($password, $user['password'])) {
        login($user['id']);
        header('Location: profile.php');
        exit;
    }
}
    $error = 'Wrong email or password.';  
?>
