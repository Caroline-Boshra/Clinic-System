
<?php
require_once 'functions.php';

$user = requireLogin();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = bookAppointment($user['id'], (int)$_POST['doctor_id'], $_POST['date'], $_POST['type']);
    if ($result === true) {
        echo 'Request sent. It appears in "Confirmed" after the doctor accepts it.';
        header('Location: my_appointments.php');
        exit;
    }
    $error = $result;                       // error message from bookAppointment()
}
?>
