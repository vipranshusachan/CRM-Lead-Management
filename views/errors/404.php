<?php
$title = "404 Page Not Found - Digital Heroes CRM";
ob_start();
?>

<div style="text-align: center; padding: 4rem 1rem;">
    <h1 style="font-size: 5rem; font-weight: 800; color: var(--accent-blue);">404</h1>
    <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem; color: var(--text-main);">Page Not Found</h2>
    <p style="color: var(--text-muted); max-width: 500px; margin: 0 auto 2rem auto;">
        The resource or lead record you were looking for does not exist or has been removed.
    </p>
    <a href="<?= base_url('/dashboard') ?>" class="btn btn-primary">Return to Dashboard</a>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/main.php';
?>
