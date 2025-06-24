<?php require base_path("app/views/inc/header.php") ?>
<?php require base_path("app/views/inc/nav.php") ?>

<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content border-danger">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="deleteUserModalLabel">Potvrda brisanja</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Zatvori"></button>
      </div>
      <div class="modal-body">
        Da li ste sigurni da želite da obrišete korisnika <strong><span id="modalUser"></span></strong>?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Otkaži</button>
        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Obriši</button>
      </div>
    </div>
  </div>
</div>


<div id="alertBox" class="mt-3"></div>
<div class="container mt-5">
  <div class="card shadow rounded">
    <div class="card-header bg-primary text-white">
      <h4 class="mb-0">Lista korisnika</h4>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover align-middle text-center">
          <thead class="table-light">
            <tr>
              <th>ID</th>
              <th>Korisničko ime</th>
              <th>Admin</th>
              <th>Akcija</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($users as $user): ?>
              <tr>
                <td><?= htmlspecialchars($user['member_id']) ?></td>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td>
                  <?= $user['admin'] ? '<span class="badge bg-success">Da</span>' : '<span class="badge bg-secondary">Ne</span>' ?>
                </td>
                <td>
                  <a href="<?= url('/users/' . $user['member_id'] . '/edit') ?>" class="btn btn-sm btn-outline-warning">Izmeni</a>
                  <button data-id="<?= htmlspecialchars($user['member_id']) ?>" data-username="<?= htmlspecialchars($user["username"]) ?>"
                    class="btn btn-sm btn-outline-danger delete-btn">Obriši</button>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>

        <?php if (empty($users)): ?>
          <p class="text-center text-muted">Nema korisnika za prikaz.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>


<?php require base_path("app/views/inc/footer.php") ?>