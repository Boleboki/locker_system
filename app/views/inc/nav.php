<?php

use App\Models\User;
use App\Core\Lang;
use App\Core\LangKey;
?>

<style>
  /* ===============================
   Navbar CSS
=============================== */

  /* Osnovni navbar */
  #mainNav {
    background-color: var(--navbar-bg);
    color: var(--navbar-text);
  }

  /* Brand */
  #mainNav .navbar-brand {
    font-weight: bold;
    color: var(--navbar-text);
    transition: scale 0.2s ease-in-out, color 0.2s ease-in-out;
  }

  #mainNav .navbar-brand:hover {
    scale: 1.05;
    color: var(--white);
  }

  #mainNav .navbar-brand:hover .version {
    color: var(--white);
  }

  /* Version unutar branda */
  #mainNav .version {
    text-align: right;
    font-size: 0.6rem;
    margin: 0;
    color: var(--navbar-text);
    transition: color 0.2s ease-in-out;
  }

  /* Nav linkovi */
  #mainNav .nav-link {
    color: var(--navbar-text);
    position: relative;
    transition: all 0.2s ease-in-out;
  }

  #mainNav .nav-link:hover,
  #mainNav .nav-link:focus {
    color: var(--white);
    transform: scale(1.1);
  }

  /* Dropdown menu */
  #mainNav .dropdown-menu {
    background-color: var(--navbar-bg);
    border: none;
    border-radius: 8px;
    padding: 0.5rem 0;
  }

  /* Dropdown items */
  #mainNav .dropdown-item {
    color: var(--navbar-text);
    transition: background-color 0.25s ease, color 0.25s ease;
  }

  #mainNav .navbar-toggler i {
    color: var(--navbar-text);
    font-size: 1.5rem;
    transition: all 0.3s ease-in-out;
  }

  #mainNav .navbar-toggler:hover i,
  #mainNav .navbar-toggler:focus i {
    transform: scale(1.1);
  }

  #mainNav .dropdown-item:hover,
  #mainNav .dropdown-item:focus,
  #mainNav .dropdown-menu.show .dropdown-item {
    background-color: var(--navbar-bg-light);
    color: var(--white);
  }

  /* Submenu dropdown */
  #mainNav .dropdown-submenu {
    position: relative;
  }

  #mainNav .dropdown-submenu>.dropdown-menu {
    top: 0;
    left: 100%;
    margin-left: 0.1rem;
    margin-right: 0.1rem;
    display: none;
    position: absolute;
  }

  #mainNav .dropdown-submenu:hover>.dropdown-menu {
    display: block;
  }

  /* Dugmad u navbaru */
  #mainNav .btn-outline-light {
    color: var(--navbar-text);
    background-color: transparent;
    transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out, scale 0.2s ease-in-out;
  }

  #mainNav .btn-outline-light:hover {
    background-color: var(--danger-color);
    color: #fff;
    scale: 1.05;
  }

  /* Sakrivanje default ikonica u nav-link ako ima ::after */
  #mainNav .nav-link::after {
    display: none !important;
  }

  .btn-theme-toggle {
    border: none;
    background: var(--navbar-bg);
    color: var(--navbar-text);
    font-size: 1.2rem;
    padding: 8px 12px;
    border-radius: 50%;
    transition: all 0.3s ease-in-out;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-left: 10px;
  }

  .btn-theme-toggle:hover {
    background: var(--navbar-bg-light);
    color: var(--white);
    transform: scale(1.1);
  }

  .btn-theme-toggle i {
    transition: transform 0.3s ease, opacity 0.3s ease;
  }

  /* Animacija promene ikone */
  .rotate {
    transform: rotate(180deg);
    opacity: 0.5;
  }
</style>

<nav class="navbar navbar-expand-lg" id="mainNav">
  <div class="container">
    <a class="navbar-brand" href="<?= url('/') ?>">Ormarići <br>
      <p class="version"></p>
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
      <i class="fa-solid fa-bars"></i>
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
      <div class="d-flex align-items-center">
        <button id="toggleThemeBtn" class="btn btn-theme-toggle">
          <i id="themeIcon" class="fas fa-sun"></i>
        </button>
        <button class="btn btn-outline-light" type="button" id="logoutBtn">
          <?= Lang::get('nav.logout') ?>
        </button>
      </div>
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