<?php
$error = '';
//require_once '../assets/style.css';
require_once   '../config/db.php';
require_once  '../core/functions.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
<div class="box">
  <h1>Login</h1>

  <?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>

  <form method="post" action="login.php">
    <label>Email
      <input type="email" name="email" required>
    </label>
    <label>Password
      <input type="password" name="password" required>
    </label>
    <button type="submit">Login</button>
  </form>

  <p>No account? <a href="register.php">Register</a></p>
</div>
</body>
</html>