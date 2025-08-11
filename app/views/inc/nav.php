<?php

use App\Models\User;
use App\Core\Lang;
use App\Core\LangKey;
?>

<style>
  .nav-link {
    position: relative;
    transition: all 0.2s ease-in-out;
  }

  .nav-link:hover {
    transform: scale(1.1);
    color: #fff !important;
  }

  .nav-link::after {
    display: none !important;
  }

  .dropdown-menu {
    background-color: #212529;
    border: none;
    border-radius: 8px;
    padding: 0.5rem 0;
  }

  .dropdown-menu .dropdown-item {
    color: #fff;
    transition: background-color 0.25s ease, color 0.25s ease;
  }

  .dropdown-menu .dropdown-item:hover,
  .dropdown-menu.show .dropdown-item {
    background-color: rgba(255, 255, 255, 0.1);
    color: #fff;
  }

  .btn-outline-light:hover {
    background-color: #dc3545;
    border-color: #dc3545;
  }

  .dropdown-submenu {
    position: relative;
  }

  .dropdown-submenu>.dropdown-menu {
    top: 0;
    left: 100%;
    margin-left: 0.1rem;
    margin-right: 0.1rem;
    display: none;
    position: absolute;
  }

  .dropdown-submenu:hover>.dropdown-menu {
    display: block;
  }

  .version {
    text-align: right;
    font-size: 0.6rem;
    margin: 0;
  }
</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="<?= url('/') ?>">Ormarići <br>
      <p class="version"></p>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav me-auto">
        <?php if ((new User)->isAdmin()): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              <?= Lang::get('nav.admin') ?>
            </a>
            <ul class="dropdown-menu">
              <li class="dropdown-submenu">
                <a class="dropdown-item dropdown-toggle" href="<?= url('/users') ?>">
                  <?= Lang::get('nav.users') ?>
                </a>
                <ul class="dropdown-menu">
                  <li>
                    <a class="dropdown-item" href="<?= url('/users') ?>">
                      <?= Lang::get('nav.users_list') ?>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="<?= url('/users/create') ?>">
                      <?= Lang::get('nav.users_create') ?>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              <?= Lang::get('nav.settings') ?>
            </a>
            <ul class="dropdown-menu">
              <li>
                <a class="dropdown-item" href="<?= url('/podesavanja') ?>">
                  <?= Lang::get('nav.settings_general') ?>
                </a>
              </li>
              <li class="dropdown-submenu">
                <a class="dropdown-item dropdown-toggle" href="<?= url('/citaci') ?>">
                  <?= Lang::get('nav.settings_readers') ?>
                </a>
                <ul class="dropdown-menu">
                  <li>
                    <a class="dropdown-item" href="<?= url('/citaci') ?>">
                      <?= Lang::get('nav.readers_list') ?>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="<?= url('/citaci/create') ?>">
                      <?= Lang::get('nav.readers_create') ?>
                    </a>
                  </li>
                </ul>
              </li>

              <li class="dropdown-submenu">
                <a class="dropdown-item dropdown-toggle" href="#">
                  <?= Lang::get('nav.language') ?>
                </a>
                <ul class="dropdown-menu">
                  <li>
                    <a class="dropdown-item lang-select" href="#" data-lang="sr"><?= Lang::get('nav.languages.sr') ?></a>
                  </li>
                  <li>
                    <a class="dropdown-item lang-select" href="#" data-lang="en"><?= Lang::get('nav.languages.en') ?></a>
                  </li>
                </ul>
              </li>

            </ul>
          </li>
        <?php endif; ?>
      </ul>

      <button class="btn btn-outline-light" type="button" id="logoutBtn">
        <?= Lang::get('nav.logout') ?>
      </button>
    </div>
  </div>
</nav>


<script>
  fetch("<?= BASE_URL ?>/version.json")
    .then(res => res.json())
    .then(data => {
      document.querySelector(".navbar-brand p").textContent = data.version;
    });
</script>