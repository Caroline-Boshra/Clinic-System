<?php

use Clinic\{Database,UserFunctions,Auth,AppointmentService};
$pdo          = Database::connection();
$users        = new UserFunctions($pdo);
$auth         = new Auth($users);  
$user  = $auth->requireLogin();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $appointments->book(
            $user->getId(),
            (int)($_POST['doctor_id'] ?? 0),
            $_POST['date'] ?? '',
            $_POST['type'] ?? ''
        );
        echo 'Request sent. It appears in "Confirmed" after the doctor accepts it.';
        header('Location: my_appointments.php');
        exit;
    } catch (InvalidArgumentException $e) {
        $error = $e->getMessage();
    }
}

?>