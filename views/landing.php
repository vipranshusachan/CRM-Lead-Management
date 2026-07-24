<?php
$title = "LeadFlow CRM - Manage Every Lead. Close More Deals.";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title) ?></title>
    <!-- Inter Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary: #2563EB;
            --primary-hover: #1D4ED8;
            --bg-white: #FFFFFF;
            --bg-light: #F8FAFC;
            --border-color: #E5E7EB;
            --text-primary: #111827;
            --text-secondary: #6B7280;
            --radius: 12px;
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            --shadow-lg: 0 10px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: var(--bg-white);
            color: var(--text-primary);
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* Container */
        .container {
            max-width: 1240px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* Sticky Navbar */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid var(--border-color);
            transition: all 0.2s ease;
        }

        .navbar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 72px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-weight: 700;
            font-size: 1.2rem;
            color: var(--text-primary);
        }

        .logo-icon {
            width: 34px;
            height: 34px;
            background-color: var(--primary);
            color: white;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            font-size: 0.95rem;
            font-weight: 500;
            color: var(--text-secondary);
            transition: color 0.2s ease;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.65rem 1.35rem;
            font-size: 0.95rem;
            font-weight: 600;
            border-radius: var(--radius);
            transition: all 0.2s ease;
            cursor: pointer;
            border: 1px solid transparent;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            box-shadow: var(--shadow-sm);
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            box-shadow: var(--shadow-md);
            transform: translateY(-1px);
        }

        .btn-outline {
            background-color: transparent;
            border-color: var(--border-color);
            color: var(--text-primary);
        }

        .btn-outline:hover {
            background-color: var(--bg-light);
            border-color: #D1D5DB;
        }

        .btn-text {
            color: var(--text-secondary);
            background: transparent;
        }

        .btn-text:hover {
            color: var(--text-primary);
        }

        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 1.4rem;
            color: var(--text-primary);
            cursor: pointer;
        }

        /* Hero Section */
        .hero {
            padding: 5rem 0 4rem 0;
            background-color: var(--bg-white);
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3.5rem;
            align-items: center;
        }

        .hero-title {
            font-size: 3.25rem;
            font-weight: 800;
            line-height: 1.15;
            color: var(--text-primary);
            letter-spacing: -0.025em;
            margin-bottom: 1.25rem;
        }

        .hero-subtitle {
            font-size: 1.125rem;
            color: var(--text-secondary);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .hero-ctas {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .trust-badges {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
        }

        .trust-badge {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-secondary);
        }

        .trust-badge i {
            color: #10B981;
        }

        /* Hero Mockup Frame */
        .mockup-container {
            background: var(--bg-white);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            overflow: hidden;
        }

        .mockup-header {
            background-color: #F1F5F9;
            padding: 0.75rem 1rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            display: inline-block;
        }
        .dot-red { background: #EF4444; }
        .dot-yellow { background: #F59E0B; }
        .dot-green { background: #10B981; }

        .mockup-body {
            display: flex;
            min-height: 320px;
            background: #FAFAFA;
        }

        .mockup-sidebar {
            width: 130px;
            background: var(--bg-white);
            border-right: 1px solid var(--border-color);
            padding: 1rem 0.5rem;
        }

        .mockup-nav-item {
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 500;
            color: var(--text-secondary);
            margin-bottom: 0.25rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .mockup-nav-item.active {
            background: #EFF6FF;
            color: var(--primary);
            font-weight: 600;
        }

        .mockup-content {
            flex: 1;
            padding: 1rem;
        }

        .mockup-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
            margin-bottom: 1rem;
        }

        .mockup-card {
            background: white;
            padding: 0.75rem;
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }

        .mockup-card-num {
            font-weight: 700;
            font-size: 1rem;
            color: var(--text-primary);
        }

        .mockup-card-label {
            font-size: 0.7rem;
            color: var(--text-secondary);
        }

        .mockup-table {
            width: 100%;
            background: white;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            border-collapse: collapse;
            font-size: 0.75rem;
        }

        .mockup-table th, .mockup-table td {
            padding: 0.5rem 0.75rem;
            text-align: left;
            border-bottom: 1px solid #F1F5F9;
        }

        .mockup-table th {
            background: #F8FAFC;
            color: var(--text-secondary);
            font-weight: 600;
        }

        .status-pill {
            display: inline-block;
            padding: 0.15rem 0.5rem;
            border-radius: 9999px;
            font-size: 0.65rem;
            font-weight: 600;
        }

        .pill-blue { background: #DBEAFE; color: #1E40AF; }
        .pill-green { background: #D1FAE5; color: #065F46; }
        .pill-yellow { background: #FEF3C7; color: #92400E; }

        /* Section Styling */
        .section {
            padding: 5rem 0;
        }

        .section-gray {
            background-color: var(--bg-light);
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
        }

        .section-header {
            text-align: center;
            max-width: 650px;
            margin: 0 auto 3.5rem auto;
        }

        .section-title {
            font-size: 2.25rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.75rem;
            letter-spacing: -0.02em;
        }

        .section-subtitle {
            font-size: 1.05rem;
            color: var(--text-secondary);
        }

        /* Features Grid */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .feature-card {
            background: var(--bg-white);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            padding: 2rem;
            transition: all 0.2s ease;
        }

        .feature-card:hover {
            box-shadow: var(--shadow-md);
            border-color: #CBD5E1;
            transform: translateY(-2px);
        }

        .feature-icon-box {
            width: 48px;
            height: 48px;
            background: #EFF6FF;
            color: var(--primary);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            margin-bottom: 1.25rem;
        }

        .feature-card h3 {
            font-size: 1.15rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .feature-card p {
            font-size: 0.925rem;
            color: var(--text-secondary);
            line-height: 1.5;
        }

        /* How it works */
        .steps-wrapper {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            position: relative;
        }

        .step-card {
            background: var(--bg-white);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            padding: 2.25rem;
            text-align: center;
        }

        .step-number {
            width: 42px;
            height: 42px;
            background: var(--primary);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.1rem;
            margin: 0 auto 1.25rem auto;
        }

        .step-card h3 {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .step-card p {
            font-size: 0.925rem;
            color: var(--text-secondary);
        }

        /* Dashboard Preview Big */
        .big-preview {
            background: var(--bg-white);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            box-shadow: var(--shadow-lg);
            padding: 1rem;
            margin-top: 1rem;
        }

        .dashboard-full {
            display: grid;
            grid-template-columns: 220px 1fr;
            min-height: 420px;
            background: var(--bg-light);
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid var(--border-color);
        }

        .dash-sidebar {
            background: white;
            border-right: 1px solid var(--border-color);
            padding: 1.25rem 1rem;
        }

        .dash-main {
            padding: 1.5rem;
        }

        .dash-grid-top {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .dash-stat-card {
            background: white;
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }

        .dash-grid-bottom {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1rem;
        }

        .dash-panel {
            background: white;
            padding: 1.25rem;
            border-radius: 8px;
            border: 1px solid var(--border-color);
        }

        /* Why Choose Us Grid */
        .why-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }

        .why-card {
            background: var(--bg-white);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            padding: 1.75rem;
            text-align: center;
        }

        .why-icon {
            font-size: 1.75rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .why-card h4 {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.4rem;
        }

        .why-card p {
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        /* Stats Bar */
        .stats-section {
            background: #1E293B;
            color: white;
            padding: 3.5rem 0;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            text-align: center;
        }

        .stat-val {
            font-size: 2.75rem;
            font-weight: 800;
            color: #60A5FA;
            margin-bottom: 0.25rem;
        }

        .stat-lbl {
            font-size: 0.95rem;
            color: #94A3B8;
            font-weight: 500;
        }

        /* Testimonials */
        .testi-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .testi-card {
            background: var(--bg-white);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            padding: 2rem;
        }

        .testi-quote {
            font-size: 0.95rem;
            color: var(--text-primary);
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .testi-author {
            display: flex;
            align-items: center;
            gap: 0.85rem;
        }

        .testi-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #DBEAFE;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        .testi-name {
            font-weight: 600;
            font-size: 0.95rem;
        }

        .testi-company {
            font-size: 0.825rem;
            color: var(--text-secondary);
        }

        /* CTA Section */
        .cta-section {
            background: var(--bg-light);
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
            padding: 5rem 0;
            text-align: center;
        }

        .cta-box {
            max-width: 650px;
            margin: 0 auto;
        }

        /* Footer */
        .footer {
            background: var(--bg-white);
            padding: 4rem 0 2rem 0;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 3rem;
            margin-bottom: 3rem;
        }

        .footer-desc {
            font-size: 0.9rem;
            color: var(--text-secondary);
            margin-top: 0.75rem;
            max-width: 320px;
        }

        .footer-head {
            font-size: 0.9rem;
            font-weight: 700;
            color: var(--text-primary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 1rem;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.6rem;
        }

        .footer-links a {
            font-size: 0.9rem;
            color: var(--text-secondary);
            transition: color 0.2s ease;
        }

        .footer-links a:hover {
            color: var(--primary);
        }

        .footer-bottom {
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.875rem;
            color: var(--text-secondary);
            flex-wrap: wrap;
            gap: 1rem;
        }

        /* Responsive Breakpoints */
        @media (max-width: 1024px) {
            .hero-grid { grid-template-columns: 1fr; gap: 2.5rem; }
            .features-grid { grid-template-columns: repeat(2, 1fr); }
            .steps-wrapper { grid-template-columns: 1fr; }
            .why-grid { grid-template-columns: repeat(2, 1fr); }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .testi-grid { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 768px) {
            .nav-links { display: none; }
            .mobile-toggle { display: block; }
            .hero-title { font-size: 2.25rem; }
            .features-grid { grid-template-columns: 1fr; }
            .dashboard-full { grid-template-columns: 1fr; }
            .dash-sidebar { display: none; }
            .dash-grid-top { grid-template-columns: 1fr 1fr; }
            .dash-grid-bottom { grid-template-columns: 1fr; }
            .footer-grid { grid-template-columns: 1fr; }
            .trust-badges { flex-wrap: wrap; }
        }
    </style>
</head>
<body>

    <!-- Sticky Navbar -->
    <nav class="navbar">
        <div class="container navbar-inner">
            <a href="<?= base_url('/') ?>" class="logo">
                <div class="logo-icon"><i class="fa-solid fa-chart-line"></i></div>
                <span>LeadFlow CRM</span>
            </a>

            <ul class="nav-links">
                <li><a href="#features">Features</a></li>
                <li><a href="#how-it-works">How It Works</a></li>
                <li><a href="#preview">Dashboard</a></li>
                <li><a href="#pricing">Pricing</a></li>
            </ul>

            <div class="nav-actions">
                <?php if (\App\Core\Auth::check()): ?>
                    <a href="<?= base_url('/dashboard') ?>" class="btn btn-primary">Dashboard</a>
                <?php else: ?>
                    <a href="<?= base_url('/login') ?>" class="btn btn-text">Login</a>
                    <a href="<?= base_url('/login') ?>" class="btn btn-primary">Get Started</a>
                <?php endif; ?>
                <button class="mobile-toggle" aria-label="Toggle Menu"><i class="fa-solid fa-bars"></i></button>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-grid">
            <div>
                <h1 class="hero-title">Manage Every Lead. Close More Deals.</h1>
                <p class="hero-subtitle">
                    The modern, business-focused CRM designed for small and medium sales teams. Organize pipeline stages, assign team members, and track activity audit trails effortlessly.
                </p>

                <div class="hero-ctas">
                    <a href="<?= base_url('/login') ?>" class="btn btn-primary" style="padding: 0.85rem 1.75rem; font-size: 1rem;">
                        Get Started
                    </a>
                    <a href="<?= base_url('/login') ?>" class="btn btn-outline" style="padding: 0.85rem 1.75rem; font-size: 1rem;">
                        Live Demo
                    </a>
                </div>

                <div class="trust-badges">
                    <div class="trust-badge">
                        <i class="fa-solid fa-circle-check"></i> Easy Setup
                    </div>
                    <div class="trust-badge">
                        <i class="fa-solid fa-circle-check"></i> Secure
                    </div>
                    <div class="trust-badge">
                        <i class="fa-solid fa-circle-check"></i> Team Collaboration
                    </div>
                </div>
            </div>

            <!-- Realistic SaaS CRM Dashboard Mockup -->
            <div class="mockup-container">
                <div class="mockup-header">
                    <span class="dot dot-red"></span>
                    <span class="dot dot-yellow"></span>
                    <span class="dot dot-green"></span>
                    <span style="font-size: 0.75rem; color: #94A3B8; margin-left: 0.5rem;">app.leadflowcrm.com/dashboard</span>
                </div>
                <div class="mockup-body">
                    <div class="mockup-sidebar">
                        <div class="mockup-nav-item active"><i class="fa-solid fa-house"></i> Dashboard</div>
                        <div class="mockup-nav-item"><i class="fa-solid fa-users"></i> Leads</div>
                        <div class="mockup-nav-item"><i class="fa-solid fa-diagram-project"></i> Pipeline</div>
                        <div class="mockup-nav-item"><i class="fa-solid fa-gear"></i> Settings</div>
                    </div>
                    <div class="mockup-content">
                        <div class="mockup-cards">
                            <div class="mockup-card">
                                <div class="mockup-card-num">26</div>
                                <div class="mockup-card-label">Total Leads</div>
                            </div>
                            <div class="mockup-card">
                                <div class="mockup-card-num">$42,500</div>
                                <div class="mockup-card-label">Pipeline Value</div>
                            </div>
                            <div class="mockup-card">
                                <div class="mockup-card-num">68%</div>
                                <div class="mockup-card-label">Win Rate</div>
                            </div>
                        </div>

                        <table class="mockup-table">
                            <thead>
                                <tr>
                                    <th>Lead Name</th>
                                    <th>Status</th>
                                    <th>Assignee</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Acme Corp Deal</td>
                                    <td><span class="status-pill pill-blue">New</span></td>
                                    <td>Sarah Jenkins</td>
                                </tr>
                                <tr>
                                    <td>TechSolutions Inc</td>
                                    <td><span class="status-pill pill-yellow">Contacted</span></td>
                                    <td>Sarah Jenkins</td>
                                </tr>
                                <tr>
                                    <td>Stark Industries</td>
                                    <td><span class="status-pill pill-green">Won</span></td>
                                    <td>Michael Scott</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="section section-gray" id="features">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Everything You Need to Scale Sales</h2>
                <p class="section-subtitle">Purpose-built features designed for high-velocity sales teams.</p>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon-box"><i class="fa-solid fa-address-book"></i></div>
                    <h3>Lead Management</h3>
                    <p>Centralize all incoming business leads with complete contact details, company profiles, and custom metadata.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon-box"><i class="fa-solid fa-chart-kanban"></i></div>
                    <h3>Pipeline Tracking</h3>
                    <p>Track leads across 7 lifecycle stages from New to Won/Lost with status tracking and instant filters.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon-box"><i class="fa-solid fa-user-shield"></i></div>
                    <h3>Role Based Access</h3>
                    <p>Granular ADMIN and MEMBER roles to ensure sensitive sales records are accessed securely.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon-box"><i class="fa-solid fa-timeline"></i></div>
                    <h3>Activity Timeline</h3>
                    <p>Automated, immutable audit trails logging every status change, reassignment, and lead action.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon-box"><i class="fa-solid fa-comments"></i></div>
                    <h3>Notes & Collaboration</h3>
                    <p>Team members can post notes, discussion highlights, and follow-up logs directly on lead files.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon-box"><i class="fa-solid fa-code"></i></div>
                    <h3>REST API</h3>
                    <p>Complete JSON REST API endpoints for seamless integrations with your existing web forms and tools.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="section" id="how-it-works">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">How LeadFlow Works</h2>
                <p class="section-subtitle">Three simple steps to organize your entire sales pipeline.</p>
            </div>

            <div class="steps-wrapper">
                <div class="step-card">
                    <div class="step-number">1</div>
                    <h3>Capture Leads</h3>
                    <p>Import leads seamlessly via web forms, CSV files, or REST API into a single structured database.</p>
                </div>

                <div class="step-card">
                    <div class="step-number">2</div>
                    <h3>Assign Team Members</h3>
                    <p>Distribute qualified prospects to specific sales representatives to ensure instant follow-ups.</p>
                </div>

                <div class="step-card">
                    <div class="step-number">3</div>
                    <h3>Track Progress</h3>
                    <p>Monitor deal stages, analyze conversion charts, and close revenue opportunities faster.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Dashboard Preview Section -->
    <section class="section section-gray" id="preview">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Designed for Modern Sales Workflows</h2>
                <p class="section-subtitle">An intuitive, distraction-free workspace for your sales team.</p>
            </div>

            <div class="big-preview">
                <div class="dashboard-full">
                    <div class="dash-sidebar">
                        <div style="font-weight: 700; color: var(--primary); margin-bottom: 1.5rem; font-size: 0.95rem;">
                            <i class="fa-solid fa-chart-line"></i> LeadFlow CRM
                        </div>
                        <div style="font-size: 0.85rem; font-weight: 600; color: var(--primary); padding: 0.5rem; background: #EFF6FF; border-radius: 6px; margin-bottom: 0.5rem;">
                            <i class="fa-solid fa-house"></i> Dashboard
                        </div>
                        <div style="font-size: 0.85rem; color: var(--text-secondary); padding: 0.5rem; margin-bottom: 0.5rem;">
                            <i class="fa-solid fa-users"></i> Leads
                        </div>
                        <div style="font-size: 0.85rem; color: var(--text-secondary); padding: 0.5rem;">
                            <i class="fa-solid fa-user-gear"></i> Team Users
                        </div>
                    </div>

                    <div class="dash-main">
                        <div class="dash-grid-top">
                            <div class="dash-stat-card">
                                <div style="font-size: 0.75rem; color: var(--text-secondary);">Total Leads</div>
                                <div style="font-size: 1.25rem; font-weight: 700;">26</div>
                            </div>
                            <div class="dash-stat-card">
                                <div style="font-size: 0.75rem; color: var(--text-secondary);">New Leads</div>
                                <div style="font-size: 1.25rem; font-weight: 700; color: var(--primary);">12</div>
                            </div>
                            <div class="dash-stat-card">
                                <div style="font-size: 0.75rem; color: var(--text-secondary);">Deals Won</div>
                                <div style="font-size: 1.25rem; font-weight: 700; color: #10B981;">8</div>
                            </div>
                            <div class="dash-stat-card">
                                <div style="font-size: 0.75rem; color: var(--text-secondary);">Conversion</div>
                                <div style="font-size: 1.25rem; font-weight: 700;">30.7%</div>
                            </div>
                        </div>

                        <div class="dash-grid-bottom">
                            <div class="dash-panel">
                                <div style="font-weight: 600; font-size: 0.9rem; margin-bottom: 0.75rem;">Recent Sales Prospects</div>
                                <table class="mockup-table">
                                    <thead>
                                        <tr>
                                            <th>Business</th>
                                            <th>Status</th>
                                            <th>Source</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Lush Garden & Cafe</td>
                                            <td><span class="status-pill pill-blue">New</span></td>
                                            <td>GeoLeads CSV</td>
                                        </tr>
                                        <tr>
                                            <td>Farzi Cafe Kanpur</td>
                                            <td><span class="status-pill pill-yellow">Contacted</span></td>
                                            <td>Website</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="dash-panel">
                                <div style="font-weight: 600; font-size: 0.9rem; margin-bottom: 0.75rem;">Activity Trail</div>
                                <div style="font-size: 0.75rem; color: var(--text-secondary); margin-bottom: 0.5rem;">
                                    <strong style="color: var(--text-primary);">Admin User</strong> changed status of <em>Acme Corp</em> to <strong>Won</strong>
                                </div>
                                <div style="font-size: 0.75rem; color: var(--text-secondary);">
                                    <strong style="color: var(--text-primary);">Sarah Jenkins</strong> added note on <em>TechSolutions</em>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose Us -->
    <section class="section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Why Business Teams Choose LeadFlow</h2>
                <p class="section-subtitle">Engineered for reliability, speed, and clean operational execution.</p>
            </div>

            <div class="why-grid">
                <div class="why-card">
                    <div class="why-icon"><i class="fa-solid fa-bolt"></i></div>
                    <h4>Fast</h4>
                    <p>Lightweight Core PHP structure delivers sub-50ms page load times without heavy framework bloat.</p>
                </div>

                <div class="why-card">
                    <div class="why-icon"><i class="fa-solid fa-lock"></i></div>
                    <h4>Secure</h4>
                    <p>Strict CSRF guards, PDO prepared queries, XSS protection, and role-based session isolation.</p>
                </div>

                <div class="why-card">
                    <div class="why-icon"><i class="fa-solid fa-wand-magic-sparkles"></i></div>
                    <h4>Simple</h4>
                    <p>Intuitive user experience requires zero team onboarding or complex training setups.</p>
                </div>

                <div class="why-card">
                    <div class="why-icon"><i class="fa-solid fa-chart-line"></i></div>
                    <h4>Scalable</h4>
                    <p>Robust MySQL database architecture designed to handle tens of thousands of active leads smoothly.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Statistics Section -->
    <section class="stats-section">
        <div class="container stats-grid">
            <div>
                <div class="stat-val">10K+</div>
                <div class="stat-lbl">Leads Managed</div>
            </div>
            <div>
                <div class="stat-val">98%</div>
                <div class="stat-lbl">Customer Satisfaction</div>
            </div>
            <div>
                <div class="stat-val">24/7</div>
                <div class="stat-lbl">Availability</div>
            </div>
            <div>
                <div class="stat-val">100%</div>
                <div class="stat-lbl">Secure</div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="section section-gray">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Trusted by Growth-Minded Teams</h2>
                <p class="section-subtitle">See how sales professionals manage their pipeline with LeadFlow.</p>
            </div>

            <div class="testi-grid">
                <div class="testi-card">
                    <p class="testi-quote">"LeadFlow eliminated our spreadsheet chaos. Our sales team now contacts every new lead within minutes instead of hours."</p>
                    <div class="testi-author">
                        <div class="testi-avatar">R</div>
                        <div>
                            <div class="testi-name">Rajesh Kumar</div>
                            <div class="testi-company">Sales Director, Apex Solutions</div>
                        </div>
                    </div>
                </div>

                <div class="testi-card">
                    <p class="testi-quote">"The activity audit trail is a game changer. I can track status updates and notes for our entire team in one clean dashboard."</p>
                    <div class="testi-author">
                        <div class="testi-avatar">P</div>
                        <div>
                            <div class="testi-name">Priya Sharma</div>
                            <div class="testi-company">Operations Lead, Digital Scale</div>
                        </div>
                    </div>
                </div>

                <div class="testi-card">
                    <p class="testi-quote">"Simple, fast, and no unnecessary bloat. It has everything a growing B2B sales team actually needs."</p>
                    <div class="testi-author">
                        <div class="testi-avatar">A</div>
                        <div>
                            <div class="testi-name">Ankit Verma</div>
                            <div class="testi-company">Founder, GrowthWorks</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="cta-section">
        <div class="container cta-box">
            <h2 class="section-title">Ready to Organize Your Sales Pipeline?</h2>
            <p class="section-subtitle" style="margin-bottom: 2rem;">Join hundreds of sales teams closing more deals with LeadFlow CRM today.</p>
            <a href="<?= base_url('/login') ?>" class="btn btn-primary" style="padding: 0.9rem 2.25rem; font-size: 1.05rem;">
                Start Free Today
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <a href="<?= base_url('/') ?>" class="logo">
                        <div class="logo-icon"><i class="fa-solid fa-chart-line"></i></div>
                        <span>LeadFlow CRM</span>
                    </a>
                    <p class="footer-desc">
                        A modern, professional Lead Management CRM for small and medium sales teams.
                    </p>
                </div>

                <div>
                    <div class="footer-head">Quick Links</div>
                    <ul class="footer-links">
                        <li><a href="#features">Features</a></li>
                        <li><a href="#how-it-works">How It Works</a></li>
                        <li><a href="#preview">Dashboard</a></li>
                    </ul>
                </div>

                <div>
                    <div class="footer-head">Resources</div>
                    <ul class="footer-links">
                        <li><a href="<?= base_url('/login') ?>">Login</a></li>
                        <li><a href="https://digitalheroesco.com" target="_blank">Digital Heroes</a></li>
                    </ul>
                </div>

                <div>
                    <div class="footer-head">Legal</div>
                    <ul class="footer-links">
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <div>&copy; <?= date('Y') ?> LeadFlow CRM. All rights reserved.</div>
                <div>
                    Built for Digital Heroes Training Task — <a href="https://digitalheroesco.com" target="_blank" style="color: var(--primary); font-weight: 600;">https://digitalheroesco.com</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
