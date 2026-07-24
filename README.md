# Production-Ready Lead Management CRM (Core PHP 8.2+)

A modern, enterprise-grade Lead Management CRM written in **pure Core PHP 8.2+** without third-party frameworks (No Laravel, Symfony, or CodeIgniter). Designed using Clean Architecture, strict MVC, OOP SOLID principles, and PSR-12 coding standards.

> **Assessment Submission**: Built for Digital Heroes Training Task — [digitalheroesco.com](https://digitalheroesco.com)

---

## 🌟 Key Features

- **Strict Core MVC Framework**: Custom Router, PDO Database abstraction, Request & Response pipeline, Server-side Validator, Session Guard, and Auth system.
- **Authentication & Role Authorization**:
  - **ADMIN**: Full access (View, Create, Edit, Delete, Assign Leads, User Management, Activity Logs).
  - **MEMBER**: Assigned leads only (View assigned leads, Update status, Add notes).
- **Lead Lifecycle & Audit Trail**: Track leads across 7 stages (`New`, `Contacted`, `Qualified`, `Proposal Sent`, `Negotiation`, `Won`, `Lost`). Every action automatically logs an immutable activity audit entry with JSON metadata.
- **Unlimited Lead Notes**: Add notes with author avatars and timestamps.
- **RESTful API**: Clean JSON REST API supporting full CRUD, status changes, assignments, notes, and activity timeline retrieval.
- **Modern SaaS UI**: Glassmorphism accents, dark/light mode toggle, Chart.js visual analytics (Pipeline bar chart & Status doughnut chart), responsive data tables with pagination and multi-parameter filtering.
- **Security Best Practices**: PDO prepared statements (SQL injection protection), HTML escaping (XSS prevention), CSRF token verification, and session fixation defense.
- **Automated Testing**: Dedicated test harness for Auth, Lead CRUD, Authorization, Status transitions, Activity logging, Notes, and REST API.

---

## 📁 Folder Structure

```text
lead-management/
├── app/
│   ├── Controllers/       # HTTP Request Handlers (Web & REST API)
│   │   ├── ActivityController.php
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── LeadController.php
│   │   ├── NoteController.php
│   │   └── UserController.php
│   ├── Core/              # Custom Core Framework
│   │   ├── Auth.php
│   │   ├── Database.php
│   │   ├── Request.php
│   │   ├── Response.php
│   │   ├── Router.php
│   │   ├── Session.php
│   │   └── Validator.php
│   ├── Helpers/           # Global Helper Utilities
│   │   └── functions.php
│   ├── Middleware/        # Route Authorization Middleware Stack
│   │   ├── AdminMiddleware.php
│   │   ├── AuthMiddleware.php
│   │   └── MemberMiddleware.php
│   ├── Models/            # Database Access Layer
│   │   ├── Activity.php
│   │   ├── Lead.php
│   │   ├── Note.php
│   │   └── User.php
│   └── Services/          # Core Business Logic Layer
│       ├── ActivityService.php
│       ├── AuthService.php
│       └── LeadService.php
├── config/                # Environment & System Configurations
│   ├── app.php
│   └── database.php
├── database/              # Schema & Seeding SQL Scripts
│   ├── schema.sql
│   └── seed.sql
├── public/                # Public Web Document Root
│   ├── index.php          # Front Controller Entry Point
│   ├── .htaccess          # URL Rewriting
│   └── assets/
│       ├── css/style.css
│       └── js/main.js
├── routes/                # Route Definitions
│   ├── api.php
│   └── web.php
├── storage/               # Logs & Temporary Files
│   ├── cache/
│   └── logs/
├── tests/                 # Automated Unit & Integration Tests
│   ├── ApiTest.php
│   ├── AuthTest.php
│   ├── LeadTest.php
│   ├── run_all.php
│   └── runner.php
├── api-docs.md            # Comprehensive REST API Documentation
└── README.md              # Project Documentation
```

---

## 🛠️ Installation & Setup

### Prerequisites
- **PHP**: 8.2 or higher
- **Web Server**: Apache with `mod_rewrite` enabled (e.g., XAMPP, WAMP, Nginx, or built-in PHP server)
- **Database**: MySQL 5.7+ / MariaDB 10.4+

### 1. Database Setup
Import the schema and initial seed data into MySQL:

```bash
mysql -u root -p < database/schema.sql
mysql -u root -p < database/seed.sql
```

Alternatively, run the queries in phpMyAdmin or your MySQL GUI tool.

### 2. Configuration
Update `config/database.php` if your local MySQL settings differ:

```php
return [
    'host' => '127.0.0.1',
    'port' => 3306,
    'database' => 'lead_crm',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4'
];
```

### 3. Local Server Execution
If using XAMPP/WAMP:
- Place the directory under `htdocs` (e.g., `C:/xampp/htdocs/PROJECT A`).
- Navigate to: `http://localhost/PROJECT%20A/public/`

If using PHP's built-in web server:

```bash
php -S localhost:8000 -t public
```

---

## 🔑 Default Login Credentials

| Role | Email | Password | Access Level |
| :--- | :--- | :--- | :--- |
| **ADMIN** | `admin@crm.com` | `password` | Full system control, all leads, user management |
| **MEMBER** | `sarah@crm.com` | `password` | Assigned leads view/update, notes, status changes |
| **MEMBER** | `michael@crm.com` | `password` | Assigned leads view/update, notes, status changes |

---

## 🧪 Running Automated Tests

Execute the built-in test runner via CLI:

```bash
php tests/run_all.php
```

Sample Output:
```text
--- Running Auth Test Suite ---
 [PASS] - Find Admin user by email
 [PASS] - Successful Auth::attempt with valid credentials
 [PASS] - Auth::check returns true after login
 [PASS] - Auth::isAdmin identifies admin role
 [PASS] - Auth::attempt fails with invalid password
 [PASS] - Auth::check returns false after logout

--- Running Lead CRUD & Lifecycle Test Suite ---
 [PASS] - Lead creation via LeadService succeeds
 [PASS] - Activity log created for lead creation
 [PASS] - Status transition to Qualified succeeds
 [PASS] - Activity logged for status change
 [PASS] - Lead assignment to user 2 succeeds
 [PASS] - Note added to lead
 [PASS] - Note verified in database
 [PASS] - Search filter returns newly created lead
 [PASS] - Test lead cleaned up / deleted

--- Running REST API Test Suite ---
 [PASS] - API User existence check
 [PASS] - Admin API authorization privilege verified
 [PASS] - Member API authorization privilege verified

==========================================
TEST SUMMARY:
 Passed: 18
 Failed: 0
 Total:  18
==========================================
```

---

## 🚀 Deployment Guidelines

1. **Document Root**: Point Apache `DocumentRoot` or Nginx `root` directly to the `public/` directory.
2. **Environment**: Update `config/app.php` setting `'env' => 'production'` and `'debug' => false`.
3. **Database Permissions**: Ensure the production database user has standard `SELECT, INSERT, UPDATE, DELETE` permissions.
4. **File Permissions**: Ensure `storage/logs` and `storage/cache` have write permissions.

---

## 📜 Footer Assessment Requirement

Every page footer in the CRM contains:
> Built for Digital Heroes Training Task — [https://digitalheroesco.com](https://digitalheroesco.com)
