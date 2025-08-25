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
        cursor: pointer;

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

    #value {
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

    #value:focus {
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

    #editModal .error-message {
        min-height: 1rem;
    }

    #unsavedWarning {
        display: none;
        margin-top: 15px;
        padding: 12px 15px;
        border: 1px solid var(--danger-color);
        border-radius: 6px;
        background-color: rgba(220, 53, 69, 0.1);
        /* providna varijanta danger */
        color: var(--danger-color);
        font-size: 0.95rem;
        line-height: 1.4;
    }

    #unsavedWarning button {
        margin-top: 10px;
        margin-right: 8px;
        padding: 6px 12px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: all 0.2s ease;
        font-size: 0.9rem;
    }

    #discardBtn {
        background-color: var(--text-secondary);
        color: var(--btn-secondary-text);
    }

    #discardBtn:hover {
        transform: scale(1.1);
        /* tamnija nijansa secondary */
    }

    #saveBtn {
        background-color: var(--btn-primary-bg);
        color: var(--btn-primary-text);
    }

    #saveBtn:hover {
        transform: scale(1.1);
        background-color: var(--primary-hover);
    }

    #search-icon {
        cursor: pointer;
        background-color: var(--bg-content);
    }

    #citaciTableContainer table {
        width: 100%;
        table-layout: auto;
        word-wrap: break-word;
        border-collapse: collapse;
        border-spacing: 0;
    }

    #citaciTableContainer table thead {
        position: sticky;
        top: 0;
        background-color: var(--table-header-bg);
        color: var(--table-header-text);
        z-index: 10;
    }

    #citaciTableContainer table thead th {
        text-transform: uppercase;
        font-size: 1rem;
    }

    #searchInput,
    #poStranici {
        background-color: var(--bg-content);
        color: var(--text-secondary);
    }

    #search-icon i,
    #poStranici {
        color: var(--text-primary);
    }

    .pagination {
        display: flex;
        justify-content: center;
        gap: 5px;
        flex-wrap: wrap;
    }

    .page-btn {
        padding: 6px 12px;
        border: 1px solid var(--pagination-border);
        background: var(--pagination-bg);
        color: var(--text-primary);
        cursor: pointer;
        min-width: 36px;
        text-align: center;
        border-radius: 4px;
    }

    .page-btn:hover {
        background-color: var(--pagination-hover-bg);
    }

    .page-btn.active {
        background-color: var(--pagination-active-bg);
        color: var(--pagination-active-text);
        border-color: var(--pagination-active-bg);
    }

    .page-btn:disabled {
        cursor: not-allowed;
    }
</style>


<div id="alertBox" class="mt-3"></div>

<div class="config-container">
    <h2 class="config-title"><?= Lang::get('configuration.page_title') ?></h2>
    <div class="d-flex justify-content-center">

        <div class="input-group" style="max-width: 400px">
            <input
                type="text"
                id="searchInput"
                class="form-control border-end-0"
                placeholder="<?= Lang::get('common.search') ?>"
                aria-label="Search"
                aria-describedby="search-icon" />
            <span class="input-group-text border-start-0" id="search-icon">
                <i class="fas fa-search"></i>
            </span>
        </div>
    </div>
    <div class="config-table-wrapper mt-3" id="configTableContainer">

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
            </tbody>
        </table>
    </div>
    <div class="mt-3 flex-wrap row" id="paginationContainer">
        <div class="col-md-4">
            <label class="form-label mb-0">Prikaži po strani:
                <select id="poStranici" class="form-select d-inline w-auto">
                    <option value="5" selected>5</option>
                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
            </label>
        </div>
        <div class="col-md-4 text-center">
            <div class="pagination">

            </div>
        </div>
        <div class="col-md-4 text-end">
            <div class="table-info-summary text-lowercase">
                <span class="fw-bold" id="showedNumber"></span>
                <?= Lang::get("common.of") ?> <span id="totalNumber"></span>
            </div>
        </div>

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
            <div><strong><?= Lang::get('configuration.modal_name') ?>:</strong> <span id="modalKey"></span></div>
            <div class="mt-3">
                <strong><?= Lang::get('configuration.modal_value') ?>:</strong>
                <span id="value" contenteditable="true" class="mt-1"></span>
                <div class="form-text text-danger error-message">
                    <ul></ul>
                </div>
            </div>

            <div><strong><?= Lang::get('configuration.modal_description') ?>:</strong>
                <span id="modalDescription"></span>
            </div>

            <div id="unsavedWarning">
                <?= Lang::get('configuration.unsaved_changes') ?> <br>
                <button id="discardBtn"><?= Lang::get('common.discard') ?></button>
                <button id="saveBtn"><?= Lang::get('common.save') ?></button>
            </div>
        </div>
        <div class="modal-footer">
            <button id="editBtn"><?= Lang::get('common.save') ?></button>
        </div>
    </div>
</div>



<?php require base_path("app/views/inc/footer.php") ?>