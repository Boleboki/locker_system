<?php

use App\Core\Lang;

require base_path("app/views/inc/header.php") ?>
<?php require base_path("app/views/inc/nav.php") ?>
<style>
  /* Card */
  #userCreateForm {
    background-color: var(--bg-content);
    color: var(--text-primary);
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    padding: 30px;
  }

  /* Form labels */
  .form-label {
    font-weight: 500;
    color: var(--text-primary);
  }

  /* Inputs */
  input.form-control,
  select.form-select {
    background-color: var(--input-bg);
    color: var(--input-text);
    border: 1px solid var(--input-border);
    border-radius: 8px;
    padding: 0.5rem 0.75rem;
    transition: all 0.2s ease;
    width: 100%;
  }

  input.form-control:focus,
  select.form-select:focus {
    background-color: var(--input-bg);
    color: var(--input-text);
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
  }

  /* Checkbox */
  .form-check-input {
    background-color: var(--input-bg);
    border: 1px solid var(--input-border);
    width: 1.2rem;
    height: 1.2rem;
  }

  .form-check-label {
    color: var(--text-primary);
    margin-left: 0.3rem;
  }

  /* Buttons */
  #addUserBtn {
    background-color: var(--primary-color);
    color: #ffffff;
    border-radius: 10px;
    padding: 0.5rem 2rem;
    font-size: 1rem;
    font-weight: 500;
    border: none;
    transition: all 0.3s ease;
    cursor: pointer;
  }

  #addUserBtn:hover {
    background-color: var(--primary-hover);
    transform: scale(1.03);
  }
</style>

<div id="alertBox" class="mt-3"></div>

<div class="container mt-5">
  <div class="card shadow-lg p-4 rounded" id="userCreateForm">
    <h3 class="mb-4 text-center"><?= Lang::get("users.form.create_title") ?></h3>
    <div class="row g-3 align-items-start justify-content-center">
      <div class="col-md-4">
        <label for="username" class="form-label"><?= Lang::get("users.form.labels.username") ?></label>
        <input type="text" class="form-control" id="username" name="username" required>
        <div class="form-text text-danger error-message">
          <ul></ul>
        </div>
      </div>

      <div class="col-md-4">
        <label for="password" class="form-label"><?= Lang::get("users.form.labels.password") ?></label>
        <input type="password" class="form-control" id="password" name="password" required>
        <div class="form-text text-danger error-message">
          <ul></ul>
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
        <div class="form-check mb-0 mt-2">
          <input class="form-check-input" type="checkbox" name="aktivan" id="aktivan" checked>
          <label for="aktivan" class="form-check-label"><?= Lang::get("users.form.labels.active") ?></label>
        </div>
      </div>

      <div class="col-12 text-center mt-4">
        <button class="px-5" id="addUserBtn"><?= Lang::get("users.form.buttons.save_user") ?></button>
      </div>
    </div>
  </div>
</div>

<?php require base_path("app/views/inc/footer.php") ?>