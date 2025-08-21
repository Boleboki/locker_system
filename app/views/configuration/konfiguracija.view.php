<?php

use App\Core\Lang;

require base_path("app/views/inc/header.php") ?>
<?php require base_path("app/views/inc/nav.php") ?>

<style>
    .config-container {
        max-width: 90%;
        width: 100%;
        margin: 20px auto;
    }

    .config-title {
        text-align: center;
        font-weight: bold;
        margin-bottom: 20px;
        color: var(--text-primary);
    }

    .config-table-wrapper {
        max-height: 70vh;
        overflow-y: auto;
        overflow-x: hidden;
        border-radius: 8px;
    }

    table.config-table {
        width: 100%;
        border-collapse: collapse;
        table-layout: fixed;
        word-wrap: break-word;
    }

    table.config-table thead {
        background-color: var(--table-header-bg);
        color: var(--table-header-text);
    }

    table.config-table th,
    table.config-table td {
        border: 1px solid var(--table-border);
        padding: 10px;
        text-align: left;
    }

    table.config-table tbody tr:nth-child(even) {
        background-color: var(--table-row-alt-bg);
    }

    table.config-table tbody tr:nth-child(odd) {
        background-color: var(--table-row-bg);
    }

    table.config-table tbody tr:hover {
        background-color: var(--table-row-hover-bg);
    }

    /* Modal */
    .modal {
        display: none;
        position: fixed;
        z-index: 1050;
        inset: 0;
        background-color: rgba(0, 0, 0, 0.5);
        overflow-y: auto;
    }

    .modal-content {
        background-color: var(--modal-bg);
        color: var(--modal-text);
        border-radius: 10px;
        padding: 20px;
        margin: 5% auto;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: bold;
    }

    .close-btn {
        font-size: 1.5rem;
        font-weight: bold;
        cursor: pointer;
        line-height: 1;
        color: var(--text-secondary);
    }

    #modalValue {
        display: block;
        width: 100%;
        background-color: var(--input-bg);
        color: var(--input-text);
        padding: 8px;
        border: 1px solid var(--input-border);
        min-height: 35px;
        border-radius: 5px;
        word-break: break-word;
    }

    #modalValue:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    .modal-footer {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    #editBtn {
        background-color: #198754;
        color: var(--white);
        padding: 8px 16px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    #editBtn:hover {
        transform: scale(1.05);
    }
</style>


<div id="alertBox" class="mt-3"></div>

<div class="config-container">
    <h2 class="config-title"><?= Lang::get('configuration.page_title') ?></h2>

    <div class="config-table-wrapper" id="configTableContainer">
        <table class="config-table">
            <thead>
                <tr>
                    <th><?= Lang::get('configuration.table_name') ?></th>
                    <th><?= Lang::get('configuration.table_value') ?></th>
                    <th><?= Lang::get('configuration.table_description') ?></th>
                    <th><?= Lang::get('configuration.table_type') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($config as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td><?= htmlspecialchars($item['par']) ?></td>
                        <td><?= htmlspecialchars($item['opis']) ?></td>
                        <td><?= htmlspecialchars($item['tip']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>


<!-- Modal -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3><?= Lang::get('configuration.modal_title') ?></h3>
            <span class="close-btn">&times;</span>
        </div>
        <div class="modal-body">
            <p><strong><?= Lang::get('configuration.modal_name') ?>:</strong> <span id="modalKey"></span></p>
            <p>
                <strong><?= Lang::get('configuration.modal_value') ?>:</strong>
                <span id="modalValue" contenteditable="true"></span>
            </p>
            <p><strong><?= Lang::get('configuration.modal_description') ?>:</strong> <span id="modalDescription"></span></p>
        </div>
        <div class="modal-footer">
            <button id="editBtn"><?= Lang::get('common.edit') ?></button>
        </div>
    </div>
</div>


<?php require base_path("app/views/inc/footer.php") ?>