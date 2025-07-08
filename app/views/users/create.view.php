<?php

use App\Core\Lang;

require base_path("app/views/inc/header.php") ?>
<?php require base_path("app/views/inc/nav.php") ?>

<div id="alertBox" class="mt-3"></div>

<div class="container mt-5">
  <div class="card shadow-lg p-4 bg-light rounded" id="userCreateForm">
    <h3 class="mb-4 text-center"><?= Lang::get("users.form.create_title") ?></h3>
    <div class="row g-3 align-items-center justify-content-center">
      <div class="col-md-4">
        <label for="username" class="form-label"><?= Lang::get("users.form.labels.username") ?></label>
        <input type="text" class="form-control" id="username" name="username" required>
        <div class="form-text text-danger error-message" style="display: none;">
          <ul style="list-style-type: '* '; padding-left: 1rem;"></ul>
        </div>
      </div>

      <div class="col-md-4">
        <label for="password" class="form-label"><?= Lang::get("users.form.labels.password") ?></label>
        <input type="password" class="form-control" id="password" name="password" required>
        <div class="form-text text-danger error-message" style="display: none;">
          <ul style="list-style-type: '* '; padding-left: 1rem;"></ul>
        </div>
      </div>

      <div class="col-md-2">
        <label for="admin" class="form-label"><?= Lang::get("users.form.labels.role") ?></label>
        <select class="form-select" id="admin" name="admin">
          <option value="0"><?= Lang::get("users.roles.user") ?></option>
          <option value="1" selected><?= Lang::get("users.roles.admin") ?></option>
        </select>
      </div>
      <div class="col-md-auto d-flex align-items-center" style="padding-top: 30px;">
        <div class="form-check mb-0">
          <input class="form-check-input" type="checkbox" name="aktivan" id="aktivan" checked>
          <label for="aktivan" class="form-check-label"><?= Lang::get("users.form.labels.active") ?></label>
        </div>
      </div>

      <div class="form-text text-danger error-message" style="display: none;">
        <ul style="list-style-type: '* '; padding-left: 1rem;"></ul>
      </div>

      <div class="col-12 text-center mt-3">
        <button class="btn btn-primary px-5" id="addUserBtn"><?= Lang::get("users.form.buttons.save_user") ?></button>
      </div>
    </div>
  </div>
</div>

<?php require base_path("app/views/inc/footer.php") ?>