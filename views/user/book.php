<?php
require_once 'functions.php';
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Book appointment</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="box">
  <h1>Book appointment</h1>

  <?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>
<form method ="POST">
    <label>Doctor
      <select name="doctor_id" required>
        <option value="">-- choose a doctor --</option>
        <?php foreach (getDoctors() as $d): ?>
          <option value="<?= $d['id'] ?>" <?= ($_POST['doctor_id'] ?? '') == $d['id'] ? 'selected' : '' ?>>
            Dr. <?= $d['first_name'] . ' ' . $d['last_name'] ?> - <?= $d['major'] ?>
            (consultation <?= $d['consultation_price'] ?>, examination <?= $d['examination_price'] ?>)
          </option>
        <?php endforeach; ?>
      </select>
    </label>

    <label>Date
      <input type="date" name="date" min="<?= date('Y-m-d') ?>" value="<?= $_POST['date'] ?? '' ?>" required>
    </label>

    <label>Type
      <select name="type" required>
        <option value="consultation">Consultation</option>
        <option value="examination">Examination</option>
      </select>
    </label>

    <button type="submit">Send request</button>
  </form>

  <p><a href="dashboard.php">Dashboard</a> | <a href="my_appointments.php">My appointments</a></p>
</div>
</body>
</html>