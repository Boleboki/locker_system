<?php

use App\Core\Lang;

require base_path("app/views/inc/header.php") ?>
<?php require base_path("app/views/inc/nav.php") ?>

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
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0"><?= Lang::get("users.page_title") ?></h4>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover align-middle text-center">
          <thead class="table-light">
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
                <td style="display: flex; gap: 15px; justify-content: center;">
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