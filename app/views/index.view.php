<?php

use App\Core\Lang;

require "inc/header.php" ?>

<div id="alertBox" class="mt-3"></div>
<div class="container vh-100 d-flex justify-content-center align-items-center">
  <div class="card p-4 shadow" style="max-width: 400px; width: 100%;" id="loginForm">
    <h2 class="text-center mb-4"><?= Lang::get("login.page") ?></h2>

    <div class="mb-3">
      <label for="username" class="form-label"><?= Lang::get("login.username") ?></label>
      <input type="text" class="form-control" id="username" placeholder="<?= Lang::get("login.username-placeholder") ?>" />
      <div class="form-text text-danger error-message" style="display: none;">
        <ul style="list-style-type: '* '; padding-left: 1rem;"></ul>
      </div>
    </div>

    <div class="mb-3">
      <label for="password" class="form-label"><?= Lang::get("login.password") ?></label>
      <input type="password" class="form-control" id="password" placeholder="<?= Lang::get("login.password-placeholder") ?>" />
      <div class="form-text text-danger error-message" style="display: none;">
        <ul style="list-style-type: '* '; padding-left: 1rem;"></ul>
      </div>
    </div>

    <button type="button" class="btn btn-primary w-100" id="loginBtn"><?= Lang::get("login.button") ?></button>
    <div class="form-text text-danger error-message auth_main_error" style="display: none;">
      <ul style="list-style-type: '* '; padding-left: 1rem;"></ul>
    </div>

  </div>
</div>
<?php require "inc/footer.php" ?>