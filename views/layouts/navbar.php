<nav class="navbar navbar-expand-lg bg-blue sticky-top py-2">
    <div class="container">
        <div class="navbar-brand">
            <a class="fw-bold text-white m-0 text-decoration-none h3"
                href="<?= $basePath ?>index.php?page=home">VCare</a>
        </div>
        <button class="navbar-toggler btn-outline-light border-0 shadow-none" type="button"
            data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <div class="d-flex gap-3 flex-wrap justify-content-center" role="group">
                <a class="btn btn-outline-light navigation--button"
                    href="<?= $basePath ?>index.php?page=home">Home</a>
                <?php if (!empty($_SESSION['user'])): ?>
                    <a class="btn btn-outline-light navigation--button"
                        href="<?= $basePath ?>index.php?page=majors">Majors</a>
                    <a class="btn btn-outline-light navigation--button"
                        href="<?= $basePath ?>index.php?page=doctors">Doctors</a>
                <?php endif; ?>
                <a class="btn btn-outline-light navigation--button"
                    href="<?= $basePath ?>index.php?page=contact">Contact</a>
                <?php if (!empty($_SESSION['user'])): ?>
                    <?php if (($_SESSION['user']['role'] ?? null) === 'admin'): ?>
                        <a class="btn btn-outline-light navigation--button"
                            href="<?= $basePath ?>index.php?page=add-doctor">Add Doctor</a>
                        <a class="btn btn-outline-light navigation--button"
                            href="<?= $basePath ?>index.php?page=add-major">Add Major</a>
                    <?php endif; ?>
                    <a class="btn btn-outline-light navigation--button"
                        href="<?= $basePath ?>index.php?page=logout">Logout</a>
                <?php else: ?>
                    <a class="btn btn-outline-light navigation--button"
                        href="<?= $basePath ?>index.php?page=login">Login</a>
                    <a class="btn btn-outline-light navigation--button"
                        href="<?= $basePath ?>index.php?page=register">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>
