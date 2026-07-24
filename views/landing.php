<?php
$title = "LeadFlow CRM - Intelligent Sales & Lead Management Platform";
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title) ?></title>
    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= base_url('/assets/css/style.css') ?>">
    <style>
        body {
            background-color: #0b0f19;
            color: #f3f4f6;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        .landing-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 5%;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            position: sticky;
            top: 0;
            z-index: 100;
            background-color: rgba(11, 15, 25, 0.85);
        }

        .hero-section {
            padding: 6rem 5% 4rem 5%;
            text-align: center;
            max-width: 1000px;
            margin: 0 auto;
            position: relative;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.4rem 1rem;
            border-radius: 9999px;
            background: rgba(99, 102, 241, 0.15);
            border: 1px solid rgba(99, 102, 241, 0.3);
            color: #818cf8;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 800;
            line-height: 1.15;
            letter-spacing: -0.03em;
            background: linear-gradient(135deg, #ffffff 0%, #94a3b8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1.5rem;
        }

        .hero-subtitle {
            font-size: 1.2rem;
            color: #94a3b8;
            line-height: 1.6;
            max-width: 750px;
            margin: 0 auto 2.5rem auto;
        }

        .cta-buttons {
            display: flex;
            justify-content: center;
            gap: 1.25rem;
            flex-wrap: wrap;
        }

        .btn-glow {
            background: linear-gradient(135deg, #6366f1, #4f46e5);
            color: white;
            padding: 0.9rem 2rem;
            font-weight: 600;
            border-radius: 12px;
            font-size: 1rem;
            box-shadow: 0 0 25px rgba(99, 102, 241, 0.4);
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-glow:hover {
            box-shadow: 0 0 35px rgba(99, 102, 241, 0.6);
            transform: translateY(-2px);
            color: white;
        }

        .btn-glass {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: white;
            padding: 0.9rem 2rem;
            font-weight: 600;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-glass:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateY(-2px);
            color: white;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            padding: 4rem 5%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .feature-card {
            background: rgba(30, 41, 59, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 16px;
            padding: 2rem;
            transition: all 0.3s ease;
        }

        .feature-card:hover {
            border-color: rgba(99, 102, 241, 0.4);
            transform: translateY(-4px);
        }

        .feature-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(168, 85, 247, 0.2));
            color: #818cf8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            margin-bottom: 1.25rem;
        }

        .demo-box {
            background: rgba(15, 23, 42, 0.8);
            border: 1px solid rgba(99, 102, 241, 0.25);
            border-radius: 16px;
            padding: 2.5rem;
            max-width: 700px;
            margin: 2rem auto 5rem auto;
            text-align: left;
        }
    </style>
</head>
<body>

    <!-- Top Navigation Header -->
    <header class="landing-header">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <div class="logo-badge" style="width: 38px; height: 38px; font-size: 1.1rem; background: linear-gradient(135deg, #6366f1, #a855f7);">
                <i class="fa-solid fa-chart-line"></i>
            </div>
            <span style="font-weight: 700; font-size: 1.25rem; letter-spacing: -0.02em; color: white;">LeadFlow CRM</span>
        </div>

        <div style="display: flex; gap: 1rem; align-items: center;">
            <?php if (\App\Core\Auth::check()): ?>
                <a href="<?= base_url('/dashboard') ?>" class="btn-glow" style="padding: 0.65rem 1.25rem; font-size: 0.9rem;">
                    Go to Dashboard <i class="fa-solid fa-arrow-right" style="margin-left: 0.4rem;"></i>
                </a>
            <?php else: ?>
                <a href="<?= base_url('/login') ?>" class="btn-glow" style="padding: 0.65rem 1.5rem; font-size: 0.9rem;">
                    Sign In <i class="fa-solid fa-right-to-bracket" style="margin-left: 0.4rem;"></i>
                </a>
            <?php endif; ?>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="hero-badge">
            <i class="fa-solid fa-shield-halved"></i> Production-Ready Core PHP CRM
        </div>
        <h1 class="hero-title">Streamline Leads, Accelerate Sales & Convert Deals</h1>
        <p class="hero-subtitle">
            An enterprise-grade Lead Management CRM built with pure Core PHP 8.2+. Featuring 7-stage lead lifecycle pipelines, automated activity audit trails, role-based access control, and real-time visual analytics.
        </p>

        <div class="cta-buttons">
            <a href="<?= base_url('/login') ?>" class="btn-glow">
                Explore Demo CRM <i class="fa-solid fa-rocket" style="margin-left: 0.5rem;"></i>
            </a>
            <a href="https://digitalheroesco.com" target="_blank" class="btn-glass">
                Built for Digital Heroes
            </a>
        </div>
    </section>

    <!-- Feature Grid -->
    <section class="features-grid">
        <div class="feature-card">
            <div class="feature-icon"><i class="fa-solid fa-diagram-project"></i></div>
            <h3 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 0.5rem;">7-Stage Pipeline</h3>
            <p style="color: #94a3b8; font-size: 0.9rem; line-height: 1.5;">
                Track every opportunity seamlessly through New, Contacted, Qualified, Proposal Sent, Negotiation, Won, and Lost stages.
            </p>
        </div>

        <div class="feature-card">
            <div class="feature-icon"><i class="fa-solid fa-user-lock"></i></div>
            <h3 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 0.5rem;">Role Authorization</h3>
            <p style="color: #94a3b8; font-size: 0.9rem; line-height: 1.5;">
                ADMINs get full lead control, member assignment, and system auditing. MEMBERS focus strictly on their assigned leads.
            </p>
        </div>

        <div class="feature-card">
            <div class="feature-icon"><i class="fa-solid fa-clock-rotate-left"></i></div>
            <h3 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 0.5rem;">Audit & Activity Trail</h3>
            <p style="color: #94a3b8; font-size: 0.9rem; line-height: 1.5;">
                Immutable activity logging captures status updates, assignments, and notes with complete JSON metadata histories.
            </p>
        </div>
    </section>

    <!-- Instant Demo Credentials Box -->
    <section style="padding: 0 5%;">
        <div class="demo-box">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 1rem;">
                <h3 style="font-size: 1.2rem; font-weight: 700;">Instant Demo Credentials</h3>
                <span class="badge-role badge-admin">PRE-CONFIGURED</span>
            </div>

            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <div style="background: rgba(255,255,255,0.03); padding: 1rem; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div style="font-weight: 600; color: #38bdf8;"><i class="fa-solid fa-user-shield"></i> Admin Access</div>
                        <div style="font-size: 0.85rem; color: #94a3b8; margin-top: 0.2rem;">admin@crm.com &nbsp;|&nbsp; password</div>
                    </div>
                    <a href="<?= base_url('/login') ?>" class="btn-glass" style="padding: 0.4rem 0.9rem; font-size: 0.8rem;">Login</a>
                </div>

                <div style="background: rgba(255,255,255,0.03); padding: 1rem; border-radius: 10px; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div style="font-weight: 600; color: #a855f7;"><i class="fa-solid fa-user-tie"></i> Sales Representative Access</div>
                        <div style="font-size: 0.85rem; color: #94a3b8; margin-top: 0.2rem;">sarah@crm.com &nbsp;|&nbsp; password</div>
                    </div>
                    <a href="<?= base_url('/login') ?>" class="btn-glass" style="padding: 0.4rem 0.9rem; font-size: 0.8rem;">Login</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer style="text-align: center; padding: 2rem 5%; border-top: 1px solid rgba(255,255,255,0.08); font-size: 0.85rem; color: #64748b;">
        Built for Digital Heroes Training Task &nbsp;&bull;&nbsp; <a href="https://digitalheroesco.com" target="_blank" style="color: #818cf8; text-decoration: none;">digitalheroesco.com</a>
    </footer>

</body>
</html>
