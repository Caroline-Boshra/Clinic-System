<?php
require_once __DIR__ . '/../layouts/header.php';
?>

<main class="container py-5">
    <div class="text-center">
        <h1 class="h2 fw-bold">Doctor Dashboard</h1>
        <p class="text-muted">
            Welcome, <?= htmlspecialchars($_SESSION['user']['name'], ENT_QUOTES, 'UTF-8') ?>.
        </p>
    </div>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
