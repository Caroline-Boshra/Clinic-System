<?php
require_once 'functions.php';

$user = requireLogin();


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: Dashboard.php');
    exit;
}


$id = (int)($_POST['id'] ?? 0);

if (cancelAppointment($id, $user['id'])) {
    echo 'Appointment cancelled. The time is free again.';
} else {
    echo 'This appointment cannot be cancelled ';
}

header('Location: my_appointments.php');
exit;