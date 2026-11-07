<?php
require_once 'functions.php';


$user  = requireLogin();
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first = trim($_POST['first_name'] ?? '');
    $last  = trim($_POST['last_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $birth = trim($_POST['birth_date'] ?? '');

    if ($first === '' || $last === '' || $phone === ''){
       $error = 'Name and phone are required.';
    } else {
        updateUser($user['id'], $first, $last, $phone, $birth);
        echo 'Profile updated.';
        header('Location: dashboard.php');
        exit;
    }
    $user = array_merge($user, ['first_name' => $first, 'last_name' => $last, 'phone' => $phone, 'birth_date' => $birth]);
}
?>
<h1>Edit profile</h1>
<?php if ($error): ?><p class="error"><?= $error ?></p><?php endif; ?>

<div class="panel">
  <form method="post" action="edit.php">
    <label>First name <input name="first_name" value="<?= $user['first_name']?>" required></label>
    <label>Last name  <input name="last_name"  value="<?= $user['last_name'] ?>" required></label>
    <label>Email (cannot be changed) <input value="<?= $user['email'] ?>" disabled></label>
    <label>Phone <input name="phone" value="<?= $user['phone'] ?>" required></label>
    <label>Birth date <input type="date" name="birth_date" value="<?= $user['birth_date'] ?>"></label>
    <button type="submit">Save changes</button>
    <a class="btn light" href="dashboard.php">Cancel</a>
  </form>
</div>
