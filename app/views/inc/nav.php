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
</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="/">Admin Panel</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav me-auto">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
            Korisnici
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/users">Lista korisnika</a></li>
            <li><a class="dropdown-item" href="/users/create">Dodaj novog korisnika</a></li>
          </ul>
        </li>
      </ul>
      <button class="btn btn-outline-light" type="button" id="logoutBtn">Logout</button>
    </div>
  </div>
</nav>
