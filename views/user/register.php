<?php 
require_once '../register.php';
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="box">
  <h1>Register</h1>

  <?php foreach ($errors as $err): ?>
    <p class="error"><?= $err ?></p>
  <?php endforeach; ?>

  <form method="post" action="register.php">
    <label>First name
      <input type="text" name="first_name" value="<?= $first ?>" required>
    </label>
    <label>Last name
      <input type="text" name="last_name" value="<?= $last ?>" required>
    </label>
    <label>Email
      <input type="email" name="email" value="<?= $email ?>" required>
    </label>
    <label>Phone
      <input type="text" name="phone" value="<?= $phone ?>" required>
    </label>
    <label>Birth date
      <input type="date" name="birth_date" value="<?= $birth ?>">
    </label>
    <label>Password
      <input type="password" name="password" required>
    </label>
    <label>Confirm password
      <input type="password" name="confirm" required>
    </label>
    <button type="submit">Register</button>
  </form>

  <p>Already have an account? <a href="login.php">Login</a></p>
</div>
</body>
</html>