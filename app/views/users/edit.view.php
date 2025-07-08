<?php

use App\Core\Lang;

require base_path("app/views/inc/header.php") ?>
<?php require base_path("app/views/inc/nav.php") ?>

<div id="alertBox" class="mt-3"></div>

<div class="container mt-5">
  <div class="card shadow-lg p-4 bg-light rounded" id="editUserForm">
    <h3 class="mb-4 text-center"><?= Lang::get("users.form.edit_title") ?></h3>
    <div class="row g-3 align-items-center justify-content-center">

      <div class="col-md-4">
        <label for="username" class="form-label"><?= Lang::get("users.form.labels.username") ?></label>
        <input type="text" class="form-control" id="username" name="username" value="<?= $user["username"] ?>" required>
        <div class="form-text text-danger error-message" style="display: none;">
          <ul style="list-style-type: '* '; padding-left: 1rem;"></ul>
        </div>
      </div>

      <div class="col-md-4">
        <label class="form-label d-block"><?= Lang::get("users.form.buttons.reset_password") ?></label>
        <button type="button"
          class="btn btn-danger w-100 d-flex align-items-center justify-content-center gap-2 shadow-sm"
          style="height: 42px;"
          data-bs-toggle="modal"
          data-bs-target="#resetPasswordModal">
          <i class="bi bi-key-fill"></i>
          <?= Lang::get("users.form.buttons.reset_password") ?>
        </button>
      </div>



      <div class="col-md-2">
        <label for="admin" class="form-label"><?= Lang::get("users.form.labels.role") ?></label>
        <select class="form-select" id="admin" name="admin">
          <option value="0" <?= !$user["admin"] ? "selected" : "" ?>><?= Lang::get("users.roles.user") ?></option>
          <option value="1" <?= $user["admin"] ? "selected" : "" ?>><?= Lang::get("users.roles.admin") ?></option>
        </select>
      </div>

      <div class="col-md-auto d-flex align-items-center" style="padding-top: 30px;">
        <div class="form-check mb-0">
          <input class="form-check-input" type="checkbox" name="aktivan" id="aktivan" <?= $user["aktivan"] ? "checked" : "" ?>>
          <label for="aktivan" class="form-check-label"><?= Lang::get("users.form.labels.active") ?></label>
        </div>
      </div>

      <div class="form-text text-danger error-message" style="display: none;">
        <ul style="list-style-type: '* '; padding-left: 1rem;"></ul>
      </div>

      <div class="col-12 text-center mt-3">
        <button class="btn btn-primary px-5" id="editUserBtn" data-id="<?= htmlspecialchars($user["member_id"]) ?>"><?= Lang::get("users.form.buttons.save_changes") ?></button>
      </div>

    </div>
  </div>
</div>


<!-- Modal za resetovanje lozinke -->
<div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content shadow">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="resetPasswordModalLabel"><?= Lang::get("users.form.modals.reset_password_title") ?></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Zatvori"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="new_password" class="form-label"><?= Lang::get("users.form.labels.new_password") ?></label>
          <input type="password" class="form-control" id="new_password">
          <div class="form-text text-danger error-message" style="display: none;">
            <ul style="list-style-type: '* '; padding-left: 1rem;"></ul>
          </div>
        </div>
        <div class="mb-3">
          <label for="confirm_password" class="form-label"><?= Lang::get("users.form.labels.confirm_password") ?></label>
          <input type="password" class="form-control" id="confirm_password">
          <div class="form-text text-danger error-message" style="display: none;">
            <ul style="list-style-type: '* '; padding-left: 1rem;"></ul>
          </div>
        </div>
        <div class="text-end">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= Lang::get("common.cancel") ?></button>
          <button type="button" class="btn btn-danger" id="confirmResetBtn" data-id="<?= $user["member_id"] ?>"><?= Lang::get("common.confirm") ?></button>
        </div>
      </div>
    </div>
  </div>
</div>



<?php require base_path("app/views/inc/footer.php") ?>