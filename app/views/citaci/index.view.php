<?php

use App\Core\Lang;

require base_path("app/views/inc/header.php") ?>
<?php require base_path("app/views/inc/nav.php") ?>
<style>
    /* Kontejner sa scrollom */
    #citaciTableContainer {
        max-height: 75vh;
        overflow-x: auto;
        overflow-y: auto;
    }

    .table-hover tbody tr:hover {
        background-color: var(--table-row-hover-bg);
        cursor: pointer;
    }

    tbody td {
        padding: 8px;
        text-align: center;
        vertical-align: middle;
        box-sizing: border-box;
        color: var(--table-row-text);
    }

    th,
    td {
        padding: 12px 15px;
        text-align: center;
        vertical-align: middle;
    }

    tbody td {
        border: 1px solid var(--table-border);
    }

    tbody tr {
        background-color: var(--table-row-bg);
    }

    tbody tr:nth-child(even) {
        background-color: var(--table-row-alt-bg);
    }

    tbody tr:hover {
        background-color: var(--table-row-hover-bg);
        cursor: pointer;
    }

    tbody tr button i {
        background-color: transparent;
        border: none;
        color: #212529;
        cursor: pointer;
    }

    tbody td:first-child {
        position: sticky;
        left: 0;
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

    th[data-sort] {
        cursor: pointer;
        position: relative;
        padding-right: 20px;
        white-space: normal;
        word-wrap: break-word;
        text-align: center;
    }

    th[data-sort]::after {
        content: "⇅";
        position: absolute;
        right: 6px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 0.75rem;
        color: var(--text-secondary);
    }

    th[data-sort].sort-asc::after {
        content: "▲";
        color: var(--table-header-text);
    }

    th[data-sort].sort-desc::after {
        content: "▼";
        color: var(--table-header-text);
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
        border: none;
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

    /* 🎨 Modal stilovi */
    .modal-content {
        background-color: var(--bg-content);
        /* isti background kao ostatak */
        color: var(--text-primary);
        border-radius: 8px;
        border: 1px solid var(--input-border);
    }

    .modal-header {
        border-bottom: 1px solid var(--table-border);
        background-color: var(--bg-main);
        /* siva kao sekundarna */
        color: var(--text-primary);
    }

    .modal-title {
        font-weight: bold;
        font-size: 1.2rem;
    }

    .modal-footer {
        border-top: 1px solid var(--table-border);
        background-color: var(--bg-main);
    }

    #citacEditBtn {
        background-color: var(--primary-color);
        color: var(--btn-primary-text);
        padding: 0.5rem 1rem;
        border-radius: 10px;
        border: none;
        transition: all 0.3s ease;
    }

    #citacEditBtn:hover {
        scale: 1.05;
    }

    #citacModal input.form-control,
    #citacModal select.form-select,
    #citacModal textarea.form-control {
        background-color: var(--input-bg);
        color: var(--input-text);
        border: 1px solid var(--input-border);
    }

    #citacModal input.form-control:focus,
    #citacModal select.form-select:focus,
    #citacModal textarea.form-control:focus {
        outline: none;
        border-color: var(--primary-color);
    }
</style>

<div class="modal fade" id="deleteCitacModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteCitacModalLabel"><?= Lang::get("reader.modal_delete.title") ?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Zatvori"></button>
            </div>
            <div class="modal-body">
                <?= Lang::get("reader.modal_delete.message") ?> <strong><span id="modalCitac"></span></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= Lang::get("common.cancel") ?></button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn"><?= Lang::get("common.confirm") ?></button>
            </div>
        </div>
    </div>
</div>

<div id="alertBox" class="mt-3"></div>
<div class="d-flex justify-content-center align-items-start">
    <div class="mt-2" style="max-width: 95%; width: 100%;">
        <h2 class="text-center"><?= Lang::get("reader.page_title") ?></h2>
        <div class="d-flex justify-content-between align-items-center mb-3" style="max-width: 800px; margin: 0 auto;">
            <div class="input-group" style="max-width: 400px;">
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
            <a href="<?= url('/citaci/create') ?>" class="btn btn-success">
                <i class="fas fa-plus"></i> <?= Lang::get("reader.buttons.add_new") ?>
            </a>
        </div>


        <div class="mt-3" id="citaciTableContainer">
            <table class="table w-100" id="citaciTable">
                <thead class="text-center align-middle">
                    <tr>
                        <th rowspan="3" colspan="1" data-sort="id_citaca"><?= Lang::get("reader.table.id") ?> <span class="sort-icon"></span></th>
                        <th rowspan="3" colspan="1" data-sort="opis_citaca"><?= Lang::get("reader.table.description") ?></th>
                        <th rowspan="3" colspan="1" data-sort="tip_citaca"><?= Lang::get("reader.table.type") ?></th>
                        <th rowspan="3" colspan="1" data-sort="aktivan"><?= Lang::get("reader.table.active") ?></th>
                        <th rowspan="1" colspan="5"><?= Lang::get("reader.table.reader_type_title") ?></th>
                        <th rowspan="2" colspan="2"><?= Lang::get("reader.table.delay_title") ?></th>
                        <th rowspan="2" colspan="2"><?= Lang::get("reader.table.sn_title") ?></th>
                        <th rowspan="3" colspan="1" data-sort="ip_adresa"><?= Lang::get("reader.table.ip_address") ?></th>
                        <th rowspan="2" colspan="3"><?= Lang::get("reader.table.lockers_title") ?></th>
                        <th rowspan="3" colspan="4"><?= Lang::get("common.edit") ?></th>
                    </tr>
                    <tr>
                        <th rowspan="1" colspan="2"><?= Lang::get("reader.table.reader_type.group_evidence") ?></th>
                        <th rowspan="1" colspan="3"><?= Lang::get("reader.table.reader_type.group_other") ?></th>
                    </tr>
                    <tr>
                        <th rowspan="1" colspan="1" data-sort="citac_za_radno_vreme"><?= Lang::get("reader.table.reader_type.working_time") ?></th>
                        <th rowspan="1" colspan="1" data-sort="citac_za_kontrolu_pristupa"><?= Lang::get("reader.table.reader_type.access_control") ?></th>
                        <th rowspan="1" colspan="1" data-sort="citac_za_ormarice"><?= Lang::get("reader.table.reader_type.for_lockers") ?></th>
                        <th rowspan="1" colspan="1" data-sort="citac_za_grupu_ormarica"><?= Lang::get("reader.table.reader_type.for_lockers_group") ?></th>
                        <th rowspan="1" colspan="1" data-sort="citac_za_odjavu"><?= Lang::get("reader.table.reader_type.for_logout") ?></th>
                        <th rowspan="1" colspan="1" data-sort="delay"><?= Lang::get("reader.table.delay.time") ?></th>
                        <th rowspan="1" colspan="1" data-sort="delay_senzora"><?= Lang::get("reader.table.delay.sensor") ?></th>
                        <th rowspan="1" colspan="1" data-sort="sn_citaca"><?= Lang::get("reader.table.serial_number.reader") ?></th>
                        <th rowspan="1" colspan="1" data-sort="sn_barijere"><?= Lang::get("reader.table.serial_number.barrier") ?></th>
                        <th rowspan="1" colspan="1" data-sort="broj_ormarica"><?= Lang::get("reader.table.lockers.number") ?></th>
                        <th rowspan="1" colspan="1" data-sort="broj_redova_ormarica"><?= Lang::get("reader.table.lockers.rows_number") ?></th>
                        <th rowspan="1" colspan="1" data-sort="brojevi_ormarica_po_indexu"><?= Lang::get("reader.table.lockers.by_index") ?></th>
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
</div>

<div class="container mt-5">
    <div class="modal fade" id="citacModal" tabindex="-1" aria-labelledby="citacModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="citacModalLabel"><?= Lang::get("reader.form.edit_title") ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zatvori"></button>
                </div>
                <div class="modal-body">
                    <!-- Forma -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-1 d-flex align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="aktivan">
                                <label class="form-check-label" for="aktivan"><?= Lang::get("reader.form.labels.active") ?></label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label"><?= Lang::get("reader.form.labels.id") ?></label>
                            <input type="text" class="form-control" id="id_citaca">
                            <div class="form-text text-danger error-message">
                                <ul></ul>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label"><?= Lang::get("reader.form.labels.type") ?></label>
                            <select class="form-select" id="tip_citaca">
                                <option disabled><?= Lang::get("common.choose") ?></option>
                                <option value="I" selected>I</option>
                                <option value="U">U</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label"><?= Lang::get("reader.form.labels.serial_number_reader") ?></label>
                            <input type="text" class="form-control" id="sn_citaca">
                            <div class="form-text text-danger error-message">
                                <ul></ul>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label"><?= Lang::get("reader.form.labels.serial_number_barrier") ?></label>
                            <input type="text" class="form-control" id="sn_barijere">
                            <div class="form-text text-danger error-message">
                                <ul></ul>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label"><?= Lang::get("reader.form.labels.delay_time") ?></label>
                            <input type="text" class="form-control" id="delay">
                            <div class="form-text text-danger error-message">
                                <ul></ul>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label"><?= Lang::get("reader.form.labels.delay_sensor") ?></label>
                            <input type="text" class="form-control" id="delay_senzora">
                            <div class="form-text text-danger error-message">
                                <ul></ul>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><?= Lang::get("reader.form.labels.description") ?></label>
                            <input type="text" class="form-control" id="opis_citaca">
                            <div class="form-text text-danger error-message">
                                <ul></ul>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label"><?= Lang::get("reader.form.labels.lockers_number") ?></label>
                            <input type="number" class="form-control" id="broj_ormarica">
                            <div class="form-text text-danger error-message">
                                <ul></ul>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label"><?= Lang::get("reader.form.labels.lockers_rows") ?></label>
                            <input type="number" class="form-control" id="broj_redova_ormarica">
                            <div class="form-text text-danger error-message">
                                <ul></ul>
                            </div>
                        </div>
                        <div class="col-md-2 d-flex align-items-center">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" id="brojevi_ormarica_po_indexu">
                                <label class="form-check-label" for="brojevi_ormarica_po_indexu"><?= Lang::get("reader.form.labels.lockers_by_index") ?></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label"><?= Lang::get("reader.form.labels.ip_address") ?></label>
                            <input type="text" class="form-control" id="ip_address">
                            <div class="form-text text-danger error-message">
                                <ul></ul>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label"><?= Lang::get("reader.form.labels.lockers_ids") ?></label>
                            <textarea class="form-control" rows="3" id="brojevi_ormarica"></textarea>
                            <div class="form-text text-danger"><?= Lang::get("reader.form.textarea_help") ?></div>
                            <div class="form-text text-danger error-message">
                                <ul></ul>
                            </div>
                        </div>
                    </div>

                    <div class="section-title"><?= Lang::get("reader.form.section_title") ?></div>

                    <div class="row">
                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="checkbox" id="citac_za_kontrolu_pristupa">
                            <label class="form-check-label" for="citac_za_kontrolu_pristupa"><?= Lang::get("reader.form.checkboxes.access_control") ?></label>
                        </div>
                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="checkbox" id="citac_za_radno_vreme">
                            <label class="form-check-label" for="citac_za_radno_vreme"><?= Lang::get("reader.form.checkboxes.working_time") ?></label>
                        </div>
                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="checkbox" id="citac_za_ormarice">
                            <label class="form-check-label" for="citac_za_ormarice"><?= Lang::get("reader.form.checkboxes.for_lockers") ?></label>
                        </div>
                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="checkbox" id="citac_za_grupu_ormarica">
                            <label class="form-check-label" for="citac_za_grupu_ormarica"><?= Lang::get("reader.form.checkboxes.for_lockers_group") ?></label>
                        </div>
                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="checkbox" id="citac_za_odjavu">
                            <label class="form-check-label" for="citac_za_odjavu"><?= Lang::get("reader.form.checkboxes.for_logout") ?></label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" id="citacEditBtn"><?= Lang::get("common.edit") ?></button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= Lang::get("common.close") ?></button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    window.translations = <?= json_encode([
                                'yes' => Lang::get('common.yes'),
                                'no'  => Lang::get('common.no'),
                                'edit' => Lang::get("common.edit"),
                                'delete' => Lang::get("common.delete")
                            ]) ?>;
</script>
<?php require base_path("app/views/inc/footer.php") ?>