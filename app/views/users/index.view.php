<?php

use App\Core\Lang;

require base_path("app/views/inc/header.php") ?>
<?php require base_path("app/views/inc/nav.php") ?>
<style>
  .btn {
    border-radius: 8px;
    padding: 0.375rem 0.75rem;
    font-size: 0.9rem;
    font-weight: 500;
    border: none;
    transition: all 0.2s ease;
  }

  /* Card */
  .card {
    background-color: var(--bg-content);
    border: 1px solid var(--table-border);
    border-radius: 10px;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  }

  .card-header {
    background-color: var(--primary-color);
    color: #ffffff;
    font-weight: 600;
    font-size: 1.2rem;
  }

  .card-header h4 {
    color: var(--table-header-text);
  }

  /* Table */
  table {
    width: 100%;
    border-collapse: collapse;
    background-color: var(--bg-content);
    color: var(--table-row-text);
  }

  table thead {
    background-color: var(--table-row-alt-bg);
    color: var(--table-row-text);
  }

  table tbody tr {
    color: var(--table-row-text);
  }

  .action-buttons * {
    color: #212529;
  }

  .action-buttons a:hover {
    transform: scale(1.05);
  }

  th,
  td {
    padding: 12px 15px;
    border: 1px solid var(--table-border);
    text-align: center;
    vertical-align: middle;
  }

  tbody tr {
    background-color: var(--table-row-bg);
  }

  tbody tr:nth-child(even) {
    background-color: var(--table-row-alt-bg);
  }

  tbody tr:hover {
    background-color: var(--table-row-hover-bg);
  }

  /* Badges */
  .badge {
    padding: 0.35em 0.65em;
    font-size: 0.8rem;
    border-radius: 12px;
    font-weight: 500;
  }

  .badge.bg-success {
    background-color: var(--success-color);
    color: #ffffff;
  }

  .badge.bg-secondary {
    background-color: var(--secondary-color);
    color: #ffffff;
  }

  /* Text */
  .text-muted {
    color: var(--text-secondary);
  }

  /* Icons in table buttons */
  td a,
  td button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 0.35rem 0.65rem;
    border-radius: 6px;
    transition: all 0.2s ease;
  }

  td a:hover,
  td button:hover {
    opacity: 0.85;
  }

  button#delete-btn:hover,
  button.btn-danger:hover {
    background-color: var(--btn-danger-bg);
    transform: scale(1.05);
  }

  .modal-content {
    background-color: var(--modal-bg);
    color: var(--modal-text);
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  }

  /* Za header modala koji je danger (crveni) */
  .modal-header.bg-danger {
    background-color: var(--danger-color);
    color: #fff;
  }

  /* Za header ili body ako želiš tamnu modal verziju */
  .modal-dark .modal-content {
    background-color: var(--modal-bg-dark);
    color: var(--modal-text-dark);
  }

  /* Modal buttons */
  .modal-footer .btn-secondary {
    background-color: var(--text-secondary);
    color: #fff;
    border: none;
  }

  .modal-footer .btn-secondary:hover {
    background-color: #5a5a5a;
  }

  .modal-footer .btn-danger {
    background-color: var(--danger-color);
    color: #fff;
    border: none;
  }

  .modal-footer .btn-danger:hover {
    background-color: #b02a37;
  }
</style>


<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content border-danger">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="deleteUserModalLabel"><?= Lang::get("users.modal_delete.title") ?></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="<?= Lang::get('common.close') ?>"></button>
      </div>
      <div class="modal-body">
        <?= Lang::get("users.modal_delete.message") ?> <strong><span id="modalUser"></span></strong>?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= Lang::get("common.cancel") ?></button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn"><?= Lang::get("common.delete") ?></button>
      </div>
    </div>
  </div>
</div>

<div id="alertBox" class="mt-3"></div>
<div class="container mt-5">
  <div class="card shadow rounded" id="usersTable">
    <div class="card-header">
      <h4 class="mb-0"><?= Lang::get("users.page_title") ?></h4>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table align-middle text-center">
          <thead>
            <tr>
              <th><?= Lang::get("users.table.id") ?></th>
              <th><?= Lang::get("users.table.username") ?></th>
              <th><?= Lang::get("users.table.role") ?></th>
              <th><?= Lang::get("users.table.active") ?></th>
              <th><?= Lang::get("common.action") ?></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($users as $user): ?>
              <tr data-id="<?= htmlspecialchars($user['member_id']) ?>" data-username="<?= htmlspecialchars($user["username"]) ?>">
                <td><?= htmlspecialchars($user['member_id']) ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td>
                  <?= $user['admin']
                    ? '<span class="badge bg-success">' . Lang::get("users.roles.admin") . '</span>'
                    : '<span class="badge bg-secondary">' . Lang::get("users.roles.user") . '</span>' ?>
                </td>
                <td>
                  <?= $user['aktivan']
                    ? '<span class="badge bg-success">' . Lang::get("common.yes") . '</span>'
                    : '<span class="badge bg-secondary">' . Lang::get("common.no") . '</span>' ?>
                </td>
                <td style="display: flex; gap: 15px; justify-content: center;" class="action-buttons">
                  <a href="<?= url('/users/' . $user['member_id'] . '/edit') ?>" class="btn btn-warning"><i class="fa-solid fa-pencil"></i></a>
                  <button class="btn btn-danger" id="delete-btn"><i class="fa-solid fa-trash"></i></button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

        <?php if (empty($users)): ?>
          <p class="text-center text-muted"><?= Lang::get("users.table.empty") ?></p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php require base_path("app/views/inc/footer.php") ?>