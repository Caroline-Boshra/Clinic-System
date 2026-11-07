<?php
require_once '..\core\functions.php';


$user    = requireLogin();

$age     = $user['birth_date'] ? (new DateTime($user['birth_date']))->diff(new DateTime())->y : null;
$appointments    = getPatientAppointments($user['id']);
$upcoming = count(array_filter($appointments, fn($a) => $a['status'] === 'confirmed' && $a['appointment_date'] > date('Y-m-d')));
$waiting  = count(array_filter($appointments, fn($a) => $a['status'] === 'pending'));
?>
<div class="topbar">
  <div>
    <h1>Welcome, <?= $user['first_name'] ?> 👋</h1>
    <p class="muted"><?= ucfirst($user['role']) ?> · <?= $user['email'] ?></p>
  </div>
  <div>
    <a class="btn" href="book.php">+ Book appointment</a>
    <a class="btn danger-btn" href="logout.php">Logout</a>
    <a class="btn danger-btn" href="cancel_appointment.php">Cancel appointment</a>
    <a class="btn danger-btn" href="profile.php">Profile</a>
    <a class="btn danger-btn" href="edit.php">Edit profile</a>
  </div>
</div>

<h2>My information</h2>
<div class="cards">
  <div class="card blue"><span>Upcoming appointments</span><strong><?= $upcoming ?></strong></div>
  <div class="card"><span>Waiting for doctor</span><strong><?= $waiting ?></strong></div>
  <div class="card"><span>Member since</span><strong><?= date('d M Y', strtotime($user['created_at'])) ?></strong></div>
  <div class="card"><span>Age</span><strong><?= $age !== null ?($age) : '-' ?></strong></div>
</div>

