<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Lead Management CRM') ?></title>
    <!-- Inter Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Application Stylesheet -->
    <link rel="stylesheet" href="<?= base_url('/assets/css/style.css') ?>">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="app-wrapper">
        <?php require BASE_PATH . '/views/partials/sidebar.php'; ?>
        
        <div class="main-content">
            <?php require BASE_PATH . '/views/partials/navbar.php'; ?>

            <div class="content-container">
                <?php if ($success = flash('success')): ?>
                    <div class="toast-container" id="toastContainer">
                        <div class="toast">
                            <i class="fa-solid fa-circle-check" style="color: var(--color-success);"></i>
                            <span><?= e($success) ?></span>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($error = flash('error')): ?>
                    <div class="toast-container" id="toastContainer">
                        <div class="toast" style="border-left-color: var(--color-danger);">
                            <i class="fa-solid fa-triangle-exclamation" style="color: var(--color-danger);"></i>
                            <span><?= e($error) ?></span>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($errors = flash('errors')): ?>
                    <div style="background-color: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; padding: 1rem 1.25rem; margin-bottom: 1.5rem; color: #991b1b;">
                        <ul style="margin-left: 1.25rem;">
                            <?php foreach ((array)$errors as $fieldErrors): ?>
                                <?php foreach ((array)$fieldErrors as $err): ?>
                                    <li><?= e($err) ?></li>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?= $content ?? '' ?>
            </div>

            <?php require BASE_PATH . '/views/partials/footer.php'; ?>
        </div>
    </div>
    <script src="<?= base_url('/assets/js/main.js') ?>"></script>
</body>
</html>
