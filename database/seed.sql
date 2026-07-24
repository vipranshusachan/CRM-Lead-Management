-- Lead Management CRM Seed Data

USE `lead_crm`;

-- Disable FK checks during truncation
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE `lead_activities`;
TRUNCATE TABLE `lead_notes`;
TRUNCATE TABLE `leads`;
TRUNCATE TABLE `users`;
SET FOREIGN_KEY_CHECKS = 1;

-- 1. SEED USERS (Password: 'password' for all accounts)
-- Hashing: password_hash('password', PASSWORD_BCRYPT)
INSERT INTO `users` (`id`, `name`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@crm.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ADMIN', NOW(), NOW()),
(2, 'Sarah Jenkins', 'sarah@crm.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'MEMBER', NOW(), NOW()),
(3, 'Michael Scott', 'michael@crm.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'MEMBER', NOW(), NOW());

-- 2. SEED LEADS
INSERT INTO `leads` (`id`, `name`, `email`, `phone`, `company`, `source`, `status`, `assigned_to`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'Acme Corp Deal', 'john@acme.com', '+1 555-0192', 'Acme Corporation', 'Website', 'New', 2, 1, NOW(), NOW()),
(2, 'TechSolutions Inc', 'contact@techsolutions.io', '+1 555-0384', 'TechSolutions Inc', 'LinkedIn', 'Contacted', 2, 1, NOW(), NOW()),
(3, 'Global Dynamics', 'sales@globaldyn.com', '+1 555-0482', 'Global Dynamics', 'Referral', 'Qualified', 3, 1, NOW(), NOW()),
(4, 'Stark Industries', 'pepper@stark.com', '+1 555-0999', 'Stark Industries', 'Conference', 'Proposal Sent', 2, 1, NOW(), NOW()),
(5, 'Wayne Enterprises', 'bruce@wayne.com', '+1 555-0777', 'Wayne Enterprises', 'Direct', 'Negotiation', 3, 1, NOW(), NOW()),
(6, 'Cyberdyne Systems', 'miles@cyberdyne.com', '+1 555-0101', 'Cyberdyne Systems', 'Website', 'Won', 2, 1, NOW(), NOW()),
(7, 'Umbrella Corp', 'albert@umbrella.com', '+1 555-0666', 'Umbrella Corp', 'Cold Call', 'Lost', 3, 1, NOW(), NOW());

-- 3. SEED NOTES
INSERT INTO `lead_notes` (`id`, `lead_id`, `user_id`, `note`, `created_at`) VALUES
(1, 1, 1, 'Initial inquiry received via website contact form.', NOW()),
(2, 2, 2, 'Had a 15 minute introduction call. Interested in Enterprise tier.', NOW()),
(3, 4, 2, 'Sent tailored proposal PDF via email. Awaiting feedback.', NOW()),
(4, 5, 3, 'Pricing negotiation underway with procurement team.', NOW()),
(5, 6, 2, 'Contract signed and payment processed!', NOW());

-- 4. SEED ACTIVITIES
INSERT INTO `lead_activities` (`id`, `lead_id`, `user_id`, `action`, `metadata`, `created_at`) VALUES
(1, 1, 1, 'Lead Created', '{"name":"Acme Corp Deal","status":"New"}', NOW()),
(2, 1, 1, 'Lead Assigned', '{"assigned_to":"Sarah Jenkins"}', NOW()),
(3, 2, 1, 'Lead Created', '{"name":"TechSolutions Inc","status":"New"}', NOW()),
(4, 2, 2, 'Status Changed', '{"from":"New","to":"Contacted"}', NOW()),
(5, 4, 2, 'Status Changed', '{"from":"Qualified","to":"Proposal Sent"}', NOW()),
(6, 6, 2, 'Status Changed', '{"from":"Negotiation","to":"Won"}', NOW());
