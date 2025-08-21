<?php

use App\Core\Lang;

require "inc/header.php" ?>
<style>
  /* Login card */
  #loginForm {
    background-color: var(--bg-content);
    color: var(--text-primary);
    border-radius: 10px;
    padding: 30px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  }

  /* Form labels */
  .form-label {
    color: var(--text-primary);
    font-weight: 500;
  }

  /* Inputs */
  input.form-control {
    background-color: var(--input-bg);
    color: var(--input-text);
    border: 1px solid var(--input-border);
    border-radius: 8px;
    padding: 0.5rem 0.75rem;
    transition: all 0.2s ease;
  }

  input.form-control:focus {
    outline: none;
    background-color: var(--input-bg);
    color: var(--input-text);
    border-color: var(--primary-color);
  }

  /* Buttons */
  #loginBtn {
    background-color: var(--primary-color);
    color: #ffffff;
    border: none;
    border-radius: 10px;
    font-weight: 500;
    padding: 0.5rem;
    margin-top: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  #loginBtn:hover {
    background-color: var(--primary-hover);
    transform: scale(1.03);
  }

  /* Error messages */
  .error-message {
    min-height: 0;
  }

  .auth_main_error ul,
  .error-message ul {
    margin: 0;
    padding-left: 1.2rem;
    color: var(--danger-color);
  }
</style>

<div id="alertBox" class="mt-3"></div>
<div class="container vh-100 d-flex justify-content-center align-items-center">
  <div class="card p-4 shadow" style="max-width: 400px; width: 100%;" id="loginForm">
    <h2 class="text-center mb-4"><?= Lang::get("login.page") ?></h2>

    <div>
      <label for="username" class="form-label"><?= Lang::get("login.username") ?></label>
      <input type="text" class="form-control" id="username" placeholder="<?= Lang::get("login.username-placeholder") ?>" />
      <div class="form-text text-danger error-message">
        <ul></ul>
      </div>
    </div>

    <div class="mt-2">
      <label for="password" class="form-label"><?= Lang::get("login.password") ?></label>
      <input type="password" class="form-control" id="password" placeholder="<?= Lang::get("login.password-placeholder") ?>" />
      <div class="form-text text-danger error-message">
        <ul></ul>
      </div>
    </div>

    <button type="button" id="loginBtn"><?= Lang::get("login.button") ?></button>
    <div class="form-text text-danger error-message auth_main_error">
      <ul></ul>
    </div>
  </div>
</div>

<?php require "inc/footer.php" ?>