<?php
require_once __DIR__ . '/../layouts/header.php';
?>

<main class="container">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="fw-bold my-4 h4">
        <ol class="breadcrumb justify-content-center">
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="<?= $basePath ?>index.php?page=home">Home</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Add Doctor</li>
        </ol>
    </nav>

    <section class="admin-form mx-auto">
        <div class="admin-form__header">
            <span class="admin-form__icon" aria-hidden="true">+</span>
            <div>
                <h1 class="h3 fw-bold mb-1">Add Doctor</h1>
                <p class="text-muted mb-0">Add a doctor to the clinic directory.</p>
            </div>
        </div>

        <form class="form" action="<?= $basePath ?>index.php?page=add-doctor" method="POST">
            <div class="form-items">
                <div class="mb-3">
                    <label class="form-label required-label" for="doctor-name">Full name</label>
                    <input type="text" class="form-control" id="doctor-name" name="name"
                        placeholder="Dr. Sarah Ahmed" required>
                </div>
                <div class="mb-3">
                    <label class="form-label required-label" for="doctor-email">Email</label>
                    <input type="email" class="form-control" id="doctor-email" name="email"
                        placeholder="doctor@example.com" required>
                </div>
                <div class="mb-3">
                    <label class="form-label required-label" for="doctor-phone">Phone</label>
                    <input type="tel" class="form-control" id="doctor-phone" name="phone"
                        placeholder="+20 100 000 0000" required>
                </div>
                <div class="mb-3">
                    <label class="form-label required-label" for="doctor-major">Major</label>
                    <select class="form-select" id="doctor-major" name="major" required>
                        <option value="" selected disabled>Select a major</option>
                        <?php foreach ($majors as $major): ?>
                            <option value="<?= htmlspecialchars($major, ENT_QUOTES, 'UTF-8') ?>">
                                <?= htmlspecialchars($major, ENT_QUOTES, 'UTF-8') ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="doctor-experience">Years of experience</label>
                    <input type="number" class="form-control" id="doctor-experience" name="experience"
                        min="0" max="70" placeholder="5">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="doctor-image">Profile image</label>
                    <input type="url" class="form-control" id="doctor-image" name="image"
                        placeholder="https://example.com/doctor.jpg">
                </div>
                <div class="mb-3 form-item--full">
                    <label class="form-label" for="doctor-bio">Short biography</label>
                    <textarea class="form-control" id="doctor-bio" name="bio" rows="4"
                        placeholder="Write a short description about the doctor"></textarea>
                </div>
            </div>
            <div class="admin-form__actions">
                <a class="btn btn-outline-secondary" href="<?= $basePath ?>index.php?page=doctors">Cancel</a>
                <button type="submit" class="btn btn-primary">Add Doctor</button>
            </div>
        </form>
    </section>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
