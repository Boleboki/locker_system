<?php require base_path("app/views/inc/header.php") ?>
<?php require base_path("app/views/inc/nav.php") ?>

<style>
    table {
        border-collapse: collapse;
        width: 50%;
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 8px;
        cursor: pointer;
    }

    th {
        background-color: #f2f2f2;
    }

    /* Modal stilovi */
    .modal {
        display: none;
        position: fixed;
        z-index: 10;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 20px;
        border-radius: 5px;
        width: 300px;
    }

    .close-btn {
        float: right;
        font-size: 20px;
        font-weight: bold;
        cursor: pointer;
    }

    button {
        margin-top: 10px;
    }

    .modal {
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
        background-color: #fff;
        padding: 20px;
        border-radius: 4px;
        margin-top: 10%;
    }

    table {
        table-layout: auto !important;
    }
</style>
<div id="alertBox" class="mt-3"></div>
<div class="d-flex justify-content-center align-items-start">
    <div class="mt-2" style="max-width: 1000px; width: 100%;">
        <h2 class="text-center">Konfiguraciona tabela</h2>
        <div style="max-height: 70vh; overflow-y: auto; overflow-x: hidden; width: 100%;" class="mt-3" id="configTableContainer">
            <table class="table table-bordered table-striped w-100" style="table-layout: fixed; word-wrap: break-word;">
                <thead class="table-dark">
                    <tr>
                        <th>Ime</th>
                        <th>Vrednost</th>
                        <th>Opis</th>
                        <th>Tip</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($config as $index => $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td><?= htmlspecialchars($item['par']) ?> </td>
                            <td style="word-break: break-word;"><?= htmlspecialchars($item['opis']) ?></td>
                            <td><?= htmlspecialchars($item['tip']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>


</div>

<!-- Modal -->
<div id="editModal" class="modal" style="display: none;">
    <div class="modal-content"
        style="width: 90%; max-width: 500px; margin: auto; word-wrap: break-word; overflow-wrap: break-word;">

        <span class="close-btn" style="float: right; cursor: pointer;">&times;</span>
        <h3>Detalji konfiguracije</h3>

        <div>
            <p><strong>Ime:</strong> <span id="modalKey"></span></p>
            <p><strong>Vrednost:</strong>
                <span id="modalValue" contenteditable="true"
                    style="display: block; width: 100%; background-color: #f8f9fa; padding: 5px;
                     border: 1px solid #ccc; min-height: 30px; word-break: break-word;">
                </span>
            </p>
            <p><strong>Opis:</strong> <span id="modalDescription"></span></p>
        </div>

        <div style="margin-top: 15px; display: flex; justify-content: space-between;">
            <button id="editBtn" style="background-color: #198754; color: white; padding: 5px 10px;">Izmeni</button>
            <button id="delBtn" style="background-color: #dc3545; color: white; padding: 5px 10px;">Obriši</button>
        </div>
    </div>
</div>


<?php require base_path("app/views/inc/footer.php") ?>