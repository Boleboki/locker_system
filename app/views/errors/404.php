<?php

use App\Core\Lang;

require base_path("app/views/inc/header.php") ?>

<div class="d-flex justify-content-center align-items-center" style="height: 80vh;">
    <div class="text-center">
        <h1 class="display-1 text-danger">404</h1>
        <p class="lead"> <?= Lang::get("errors.404") ?></p>
        <a href="<?= url('/') ?>" class="btn btn-primary"> <?= Lang::get("errors.back") ?></a>
    </div>
</div>

<?php require base_path("app/views/inc/footer.php") ?>