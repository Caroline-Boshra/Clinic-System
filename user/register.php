<?php
require_once  '../config/db.php';
require_once '../core/functions.php';

$errors = [];
$first = $last = $email = $phone = $birth = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first = trim($_POST['first_name'] ?? '');
    $last  = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $birth = trim($_POST['birth_date'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm  = $_POST['confirm'] ?? '';

    if ($first === '' || $last === ''){
        $errors[] = 'First and last name are required.';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)|| $email === ''){
        $errors[] = 'Enter a valid email.';
    }
    if ($phone === ''){
        $errors[] = 'Phone is required.';
    }
    if (strlen($password) < 6){
        $errors[] = 'Password must be at least 6 characters.';
    }
    if ($password !== $confirm){
        $errors[] = 'Passwords do not match.';
    }
    if (!$errors && userExists($email, $phone)){
        $errors[] = 'Email or phone already registered.';
    }
    if (!$errors) {
        $id = createUser($first, $last, $email, $phone, $password, $birth);
        login($id);                       
        header('Location: Dashboard.php');
        exit;
    }
}
?>
