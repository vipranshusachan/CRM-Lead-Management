<?php
$title = "Leads - Lead Management CRM";
$isAdmin = \App\Core\Auth::isAdmin();
ob_start();
?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
    <div>
        <h1 style="font-size: 1.5rem; font-weight: 700; color: var(--text-primary); letter-spacing: -0.02em;">Leads Directory</h1>
        <p style="color: var(--text-muted); font-size: 0.875rem;">Manage, search, and track sales pipeline leads</p>
    </div>
    <?php if ($isAdmin): ?>
        <a href="<?= base_url('/leads/create') ?>" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i>
            <span>Add Lead</span>
        </a>
    <?php endif; ?>
</div>

<!-- Filters Bar -->
<div class="table-card" style="padding: 1.25rem; margin-bottom: 1.5rem;">
    <form action="<?= base_url('/leads') ?>" method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; align-items: end;">
        <div>
            <label class="form-label" for="search"><i class="fa-solid fa-magnifying-glass"></i> Search</label>
            <input type="text" id="search" name="search" class="form-control" placeholder="Name, Email, Company..." value="<?= e($filters['search'] ?? '') ?>">
        </div>

        <div>
            <label class="form-label" for="status">Status</label>
            <select id="status" name="status" class="form-control">
                <option value="">All Statuses</option>
                <?php foreach ($statuses as $st): ?>
                    <option value="<?= e($st) ?>" <?= ($filters['status'] ?? '') === $st ? 'selected' : '' ?>><?= e($st) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <?php if ($isAdmin): ?>
        <div>
            <label class="form-label" for="assigned_to">Assigned User</label>
            <select id="assigned_to" name="assigned_to" class="form-control">
                <option value="">All Members</option>
                <?php foreach ($members as $m): ?>
                    <option value="<?= $m['id'] ?>" <?= ((string)($filters['assigned_to'] ?? '')) === (string)$m['id'] ? 'selected' : '' ?>>
                        <?= e($m['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php endif; ?>

        <div>
            <label class="form-label" for="date">Creation Date</label>
            <input type="date" id="date" name="date" class="form-control" value="<?= e($filters['date'] ?? '') ?>">
        </div>

        <div style="display: flex; gap: 0.5rem;">
            <button type="submit" class="btn btn-primary" style="flex: 1;">Filter</button>
            <a href="<?= base_url('/leads') ?>" class="btn btn-secondary"><i class="fa-solid fa-rotate-left"></i> Reset</a>
        </div>
    </form>
</div>

<!-- Data Table Card -->
<div class="table-card">
    <div class="table-header-bar">
        <span style="font-weight: 600; font-size: 0.875rem; color: var(--text-muted);">
            Showing <?= count($leadsData['data']) ?> of <?= $leadsData['total'] ?> Leads
        </span>
    </div>

    <div style="overflow-x: auto;">
        <table class="crm-table">
            <thead>
                <tr>
                    <th>Lead Name</th>
                    <th>Contact Information</th>
                    <th>Company</th>
                    <th>Status</th>
                    <th>Assigned Representative</th>
                    <th>Created Date</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($leadsData['data'])): ?>
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="fa-solid fa-folder-open"></i></div>
                                <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 0.25rem;">No leads found</h3>
                                <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1rem;">Try adjusting your filter search criteria.</p>
                                <?php if ($isAdmin): ?>
                                    <a href="<?= base_url('/leads/create') ?>" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Add First Lead</a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($leadsData['data'] as $lead): ?>
                        <?php 
                            $statusSlug = strtolower(str_replace(' ', '', $lead['status'])); 
                        ?>
                        <tr>
                            <td>
                                <a href="<?= base_url('/leads/' . $lead['id']) ?>" style="font-weight: 600; color: var(--text-primary);">
                                    <?= e($lead['name']) ?>
                                </a>
                            </td>
                            <td>
                                <div><a href="mailto:<?= e($lead['email']) ?>" style="color: var(--text-secondary);"><?= e($lead['email']) ?></a></div>
                                <div style="font-size: 0.8rem; color: var(--text-muted);"><?= e($lead['phone'] ?? '-') ?></div>
                            </td>
                            <td style="font-weight: 500;"><?= e($lead['company'] ?? '-') ?></td>
                            <td>
                                <span class="status-badge status-<?= $statusSlug ?>">
                                    <?= e($lead['status']) ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($lead['assigned_to_name']): ?>
                                    <span style="display: inline-flex; align-items: center; gap: 0.4rem; font-size: 0.85rem;">
                                        <span class="user-avatar-badge" style="width: 24px; height: 24px; font-size: 0.75rem;"><?= strtoupper(substr($lead['assigned_to_name'], 0, 1)) ?></span>
                                        <?= e($lead['assigned_to_name']) ?>
                                    </span>
                                <?php else: ?>
                                    <span style="color: var(--text-muted); font-style: italic;">Unassigned</span>
                                <?php endif; ?>
                            </td>
                            <td style="font-size: 0.85rem; color: var(--text-muted);">
                                <?= date('M d, Y', strtotime($lead['created_at'])) ?>
                            </td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; gap: 0.4rem;">
                                    <a href="<?= base_url('/leads/' . $lead['id']) ?>" class="btn btn-secondary" style="padding: 0.3rem 0.6rem; font-size: 0.8rem;" title="View Details">
                                        <i class="fa-solid fa-eye"></i> View
                                    </a>
                                    <a href="<?= base_url('/leads/' . $lead['id'] . '/edit') ?>" class="btn btn-secondary" style="padding: 0.3rem 0.6rem; font-size: 0.8rem;" title="Edit Lead">
                                        <i class="fa-solid fa-pen"></i> Edit
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if ($leadsData['last_page'] > 1): ?>
        <div style="padding: 0.9rem 1.5rem; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid var(--border-color); background-color: var(--bg-surface);">
            <div style="font-size: 0.85rem; color: var(--text-muted);">
                Page <?= $leadsData['page'] ?> of <?= $leadsData['last_page'] ?>
            </div>
            <div style="display: flex; gap: 0.5rem;">
                <?php if ($leadsData['page'] > 1): ?>
                    <a href="<?= base_url('/leads?' . http_build_query(array_merge($filters, ['page' => $leadsData['page'] - 1]))) ?>" class="btn btn-secondary" style="padding: 0.35rem 0.75rem; font-size: 0.8rem;">
                        <i class="fa-solid fa-chevron-left"></i> Previous
                    </a>
                <?php endif; ?>

                <?php if ($leadsData['page'] < $leadsData['last_page']): ?>
                    <a href="<?= base_url('/leads?' . http_build_query(array_merge($filters, ['page' => $leadsData['page'] + 1]))) ?>" class="btn btn-secondary" style="padding: 0.35rem 0.75rem; font-size: 0.8rem;">
                        Next <i class="fa-solid fa-chevron-right"></i>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/views/layouts/main.php';
?>
