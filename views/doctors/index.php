<?php
$basePath = '';
$pageTitle = 'Doctors';
require_once __DIR__ . '/../layouts/header.php';
?>

<main class="container">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="fw-bold my-4 h4">
        <ol class="breadcrumb justify-content-center">
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="<?= $basePath ?>index.php?page=home">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Doctors</li>
        </ol>
    </nav>

    <?php if (empty($doctors)): ?>
        <div class="alert alert-info text-center mb-5" role="status">
            No doctors are available at the moment.
        </div>
    <?php else: ?>
        <section class="doctors-grid" aria-label="Doctors">
            <?php foreach ($doctors as $doctor): ?>
                <article class="card p-2" style="width: 18rem;">
                    <img
                        src="<?= htmlspecialchars($basePath . $doctor['image'], ENT_QUOTES, 'UTF-8') ?>"
                        class="card-img-top rounded-circle card-image-circle"
                        alt="<?= htmlspecialchars($doctor['name'], ENT_QUOTES, 'UTF-8') ?>"
                    >
                    <div class="card-body d-flex flex-column gap-1 justify-content-center">
                        <h2 class="h4 card-title fw-bold text-center">
                            <?= htmlspecialchars($doctor['name'], ENT_QUOTES, 'UTF-8') ?>
                        </h2>
                        <h3 class="h6 card-title fw-bold text-center">
                            <?= htmlspecialchars($doctor['major'], ENT_QUOTES, 'UTF-8') ?>
                        </h3>
                        <a href="<?= $basePath ?>index.php?page=doctor" class="btn btn-outline-primary card-button">
                            Book an appointment
                        </a>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
