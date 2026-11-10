<?php
use Clinic\{Database,Auth};

$auth = new Auth($users);         
 

$error = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($auth->attempt($email, $password)) {
        header('Location: profile.php');
        exit;
    }
    $error = 'Wrong email or password.';   
}
?>