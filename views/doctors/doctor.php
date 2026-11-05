<?php
require_once __DIR__ . '/../layouts/header.php';
?>

<main class="container">
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" class="fw-bold my-4 h4">
        <ol class="breadcrumb justify-content-center">
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="<?= $basePath ?>index.php?page=home">Home</a>
            </li>
            <li class="breadcrumb-item">
                <a class="text-decoration-none" href="<?= $basePath ?>index.php?page=doctors">Doctors</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Book an appointment</li>
        </ol>
    </nav>

    <section class="d-flex flex-column gap-3 details-card doctor-details mb-5">
        <div class="details d-flex gap-2 align-items-center">
            <img
                src="<?= $basePath ?>assets/images/major.jpg"
                alt="Doctor"
                class="img-fluid rounded-circle"
                height="150"
                width="150"
            >
            <div class="details-info d-flex flex-column gap-3">
                <h1 class="h4 card-title fw-bold">Dr. Sarah Ahmed</h1>
                <p class="mb-0">Cardiology specialist</p>
            </div>
        </div>
        <hr>
        <form class="form" action="<?= $basePath ?>index.php?page=doctor" method="POST">
            <div class="form-items">
                <div class="mb-3">
                    <label class="form-label required-label" for="booking-name">Name</label>
                    <input type="text" class="form-control" id="booking-name" name="name" required>
                </div>
                <div class="mb-3">
                    <label class="form-label required-label" for="booking-phone">Phone</label>
                    <input type="tel" class="form-control" id="booking-phone" name="phone" required>
                </div>
                <div class="mb-3">
                    <label class="form-label required-label" for="booking-email">Email</label>
                    <input type="email" class="form-control" id="booking-email" name="email" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Confirm Booking</button>
        </form>
    </section>
</main>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>
