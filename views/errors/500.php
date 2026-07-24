<?php
$title = "500 Internal Server Error - Digital Heroes CRM";
ob_start();
?>

<div style="text-align: center; padding: 4rem 1rem;">
    <h1 style="font-size: 5rem; font-weight: 800; color: var(--accent-red);">500</h1>
    <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 1rem; color: var(--text-main);">Server Error</h2>
    <p style="color: var(--text-muted); max-width: 500px; margin: 0 auto 1.5rem auto;">
        An internal server exception occurred while processing your request.
    </p>
    <?php if (isset($exception)): ?>
        <div style="background-color: var(--bg-card); border: 1px solid var(--border-color); padding: 1rem; border-radius: 8px; max-width: 600px; margin: 0 auto 2rem auto; text-align: left; font-family: monospace; font-size: 0.85rem; color: var(--accent-red);">
            <?= e($exception->getMessage()) ?>
        </div>
    <?php endif; ?>
    <a href="<?= base_url('/dashboard') ?>" class="btn btn-primary">Return to Safety</a>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/main.php';
?>
