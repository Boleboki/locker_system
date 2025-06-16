<?php require base_path("app/views/inc/header.php")?>
<?php require base_path("app/views/inc/nav.php") ?>

<div id="alertBox" class="mt-3"></div>

<div class="container mt-5">
  <div class="card shadow-lg p-4 bg-light rounded">
    <h3 class="mb-4 text-center">Dodavanje novog korisnika</h3>
    <div class="row g-3 align-items-center justify-content-center">
      <div class="col-md-4">
        <label for="username" class="form-label">Korisničko ime</label>
        <input type="text" class="form-control" id="username" name="username" required>
      </div>

      <div class="col-md-4">
        <label for="password" class="form-label">Lozinka</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>

      <div class="col-md-4">
        <label for="admin" class="form-label">Da li je admin?</label>
        <select class="form-select" id="admin" name="admin">
          <option value="0">Ne</option>
          <option value="1" selected>Da</option>
        </select>
      </div>

      <div class="col-12 text-center mt-3">
        <button class="btn btn-primary px-5" id="addUserBtn">Sačuvaj korisnika</button>
      </div>
</div>
  </div>
</div>


<?php require base_path("app/views/inc/footer.php")?>
