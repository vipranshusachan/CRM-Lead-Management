<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Lead Management CRM</title>
    <!-- Inter Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('/assets/css/style.css') ?>">
</head>
<body style="display: flex; align-items: center; justify-content: center; min-height: 100vh; background-color: var(--bg-body); padding: 1.5rem;">

<div style="width: 100%; max-width: 440px; background-color: var(--bg-surface); border: 1px solid var(--border-color); border-radius: var(--radius-xl); padding: 2.25rem; box-shadow: var(--shadow-md);">
    
    <div style="text-align: center; margin-bottom: 2rem;">
        <div class="logo-badge" style="width: 44px; height: 44px; margin: 0 auto 0.75rem auto; font-size: 1.25rem;">
            <i class="fa-solid fa-chart-line"></i>
        </div>
        <h1 style="font-size: 1.4rem; font-weight: 700; color: var(--text-primary); letter-spacing: -0.02em;">Lead Management CRM</h1>
        <p style="color: var(--text-muted); font-size: 0.875rem; margin-top: 0.25rem;">Sign in to your sales workspace</p>
    </div>

    <?php if ($error = flash('error')): ?>
        <div style="background-color: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 0.75rem 1rem; border-radius: 8px; font-size: 0.85rem; margin-bottom: 1.25rem;">
            <i class="fa-solid fa-circle-exclamation"></i> <?= e($error) ?>
        </div>
    <?php endif; ?>

    <?php if ($success = flash('success')): ?>
        <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 0.75rem 1rem; border-radius: 8px; font-size: 0.85rem; margin-bottom: 1.25rem;">
            <i class="fa-solid fa-circle-check"></i> <?= e($success) ?>
        </div>
    <?php endif; ?>

    <!-- Login Form -->
    <form action="<?= base_url('/login') ?>" method="POST">
        <?= csrf_field() ?>

        <div class="form-group">
            <label class="form-label" for="email">Work Email</label>
            <input type="email" id="email" name="email" class="form-control" value="<?= e(old('email')) ?>" placeholder="name@company.com" required autofocus>
        </div>

        <div class="form-group">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <label class="form-label" for="password">Password</label>
            </div>
            <input type="password" id="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 0.5rem; padding: 0.75rem;">
            Sign In
        </button>
    </form>

    <!-- Demo Credentials Box -->
    <div style="margin-top: 1.75rem; padding-top: 1.25rem; border-top: 1px solid var(--border-color);">
        <div style="font-size: 0.8rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.04em; margin-bottom: 0.75rem; text-align: center;">
            Demo Login Accounts (Click to Quick-Fill)
        </div>
        
        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
            <div onclick="fillCredentials('admin@crm.com', 'password')" style="padding: 0.65rem 0.85rem; background-color: var(--bg-subtle); border: 1px solid var(--border-color); border-radius: var(--radius-md); cursor: pointer; display: flex; justify-content: space-between; align-items: center; transition: all var(--transition-fast);">
                <div>
                    <div style="font-weight: 600; font-size: 0.85rem; color: var(--text-primary);">
                        <i class="fa-solid fa-shield-halved" style="color: #6b21a8; margin-right: 0.3rem;"></i> Admin Account
                    </div>
                    <div style="font-size: 0.8rem; color: var(--text-muted);">admin@crm.com | password</div>
                </div>
                <span class="badge-role badge-admin">ADMIN</span>
            </div>

            <div onclick="fillCredentials('sarah@crm.com', 'password')" style="padding: 0.65rem 0.85rem; background-color: var(--bg-subtle); border: 1px solid var(--border-color); border-radius: var(--radius-md); cursor: pointer; display: flex; justify-content: space-between; align-items: center; transition: all var(--transition-fast);">
                <div>
                    <div style="font-weight: 600; font-size: 0.85rem; color: var(--text-primary);">
                        <i class="fa-solid fa-user-tie" style="color: #0369a1; margin-right: 0.3rem;"></i> Sales Member Account
                    </div>
                    <div style="font-size: 0.8rem; color: var(--text-muted);">sarah@crm.com | password</div>
                </div>
                <span class="badge-role badge-member">MEMBER</span>
            </div>
        </div>
    </div>

    <!-- Assessment Link Footer -->
    <div style="margin-top: 1.5rem; text-align: center; font-size: 0.8rem; color: var(--text-muted);">
        <a href="https://digitalheroesco.com" target="_blank" rel="noopener noreferrer" style="color: var(--text-muted);">
            Built for Digital Heroes Training Task
        </a>
    </div>

</div>

<script src="<?= base_url('/assets/js/main.js') ?>"></script>
</body>
</html>
