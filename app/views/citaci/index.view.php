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

    /* Tabela */
    table {
        border-collapse: collapse;
        width: 100%;
        table-layout: auto !important;
    }

    .table-hover tbody tr:hover {
        background-color: #e9ecef;
        cursor: pointer;
    }

    thead th {
        position: sticky;
        z-index: 3;
        box-sizing: border-box;
        padding: 8px;
        cursor: pointer;
    }

    thead tr:nth-child(1) th {
        top: 0;
    }

    thead tr:nth-child(2) th {
        top: 42px;
    }

    thead tr:nth-child(3) th {
        top: 85px;
    }

    td {
        padding: 8px;
        text-align: center;
        vertical-align: middle;
        box-sizing: border-box;
    }

    tr:first-child th:first-child,
    tbody td:first-child {
        position: sticky;
        left: 0;
        z-index: 10;
    }

    #citaciTableContainer thead tr th {
        text-transform: uppercase;
        font-size: 1rem;
    }
</style>

<div class="modal fade" id="deleteCitacModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteCitacModalLabel"><?= Lang::get("citaci.modal_delete.title") ?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Zatvori"></button>
            </div>
            <div class="modal-body">
                <?= Lang::get("citaci.modal_delete.message") ?> <strong><span id="modalCitac"></span></strong>?
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
        <h2 class="text-center"><?= Lang::get("citaci.page_title") ?></h2>
        <div class="d-flex justify-content-between align-items-center mb-3" style="max-width: 800px; margin: 0 auto;">
            <div class="input-group" style="max-width: 400px;">
                <input
                    type="text"
                    id="searchInput"
                    class="form-control border-end-0"
                    placeholder="<?= Lang::get('common.search') ?>"
                    aria-label="Search"
                    aria-describedby="search-icon" />
                <span class="input-group-text bg-white border-start-0" id="search-icon" style="cursor: pointer;">
                    <i class="fas fa-search"></i>
                </span>
            </div>
            <a href="<?= url('/citaci/create') ?>" class="btn btn-success">
                <i class="fas fa-plus"></i> <?= Lang::get("citaci.buttons.add_new") ?>
            </a>
        </div>


        <div style="max-height: 75vh; overflow-y: auto; overflow-x: auto; width: 100%;" class="mt-3" id="citaciTableContainer">
            <table class="table table-bordered table-striped w-100 table-hover" style="table-layout: fixed; word-wrap: break-word;">
                <thead class="table-dark text-center align-middle">
                    <tr>
                        <th rowspan="3" colspan="1" data-sort="id_citaca"><?= Lang::get("citaci.table.id") ?></th>
                        <th rowspan="3" colspan="1" data-sort="opis_citaca"><?= Lang::get("citaci.table.description") ?></th>
                        <th rowspan="3" colspan="1" data-sort="tip_citaca"><?= Lang::get("citaci.table.type") ?></th>
                        <th rowspan="3" colspan="1" data-sort="aktivan"><?= Lang::get("citaci.table.active") ?></th>
                        <th rowspan="1" colspan="5"><?= Lang::get("citaci.table.reader_type_title") ?></th>
                        <th rowspan="2" colspan="2"><?= Lang::get("citaci.table.delay_title") ?></th>
                        <th rowspan="2" colspan="2"><?= Lang::get("citaci.table.sn_title") ?></th>
                        <th rowspan="3" colspan="1" data-sort="ip_adresa"><?= Lang::get("citaci.table.ip_address") ?></th>
                        <th rowspan="2" colspan="3"><?= Lang::get("citaci.table.lockers_title") ?></th>
                        <th rowspan="3" colspan="4"><?= Lang::get("common.edit") ?></th>
                    </tr>
                    <tr>
                        <th rowspan="1" colspan="2"><?= Lang::get("citaci.table.reader_type.group_evidence") ?></th>
                        <th rowspan="1" colspan="3"><?= Lang::get("citaci.table.reader_type.group_other") ?></th>
                    </tr>
                    <tr>
                        <th rowspan="1" colspan="1" data-sort="citac_za_radno_vreme"><?= Lang::get("citaci.table.reader_type.working_time") ?></th>
                        <th rowspan="1" colspan="1" data-sort="citac_za_kontrolu_pristupa"><?= Lang::get("citaci.table.reader_type.access_control") ?></th>
                        <th rowspan="1" colspan="1" data-sort="citac_za_ormarice"><?= Lang::get("citaci.table.reader_type.for_lockers") ?></th>
                        <th rowspan="1" colspan="1" data-sort="citac_za_grupu_ormarica"><?= Lang::get("citaci.table.reader_type.for_lockers_group") ?></th>
                        <th rowspan="1" colspan="1" data-sort="citac_za_odjavu"><?= Lang::get("citaci.table.reader_type.for_logout") ?></th>
                        <th rowspan="1" colspan="1" data-sort="delay"><?= Lang::get("citaci.table.delay.time") ?></th>
                        <th rowspan="1" colspan="1" data-sort="delay_senzora"><?= Lang::get("citaci.table.delay.sensor") ?></th>
                        <th rowspan="1" colspan="1" data-sort="sn_citaca"><?= Lang::get("citaci.table.serial_number.reader") ?></th>
                        <th rowspan="1" colspan="1" data-sort="sn_barijere"><?= Lang::get("citaci.table.serial_number.barrier") ?></th>
                        <th rowspan="1" colspan="1" data-sort="broj_ormarica"><?= Lang::get("citaci.table.lockers.number") ?></th>
                        <th rowspan="1" colspan="1" data-sort="broj_redova_ormarica"><?= Lang::get("citaci.table.lockers.rows_number") ?></th>
                        <th rowspan="1" colspan="1" data-sort="brojevi_ormarica_po_indexu"><?= Lang::get("citaci.table.lockers.by_index") ?></th>
                    </tr>
                </thead>

                <tbody>
                </tbody>
            </table>
        </div>

    </div>
</div>
<div class="container mt-5">
    <div class="modal fade" id="citacModal" tabindex="-1" aria-labelledby="citacModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="citacModalLabel"><?= Lang::get("citaci.form.edit_title") ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zatvori"></button>
                </div>
                <div class="modal-body">
                    <!-- Forma -->
                    <div class="row g-3 mb-3">
                        <div class="col-md-1 d-flex align-items-center">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="aktivan">
                                <label class="form-check-label" for="aktivan"><?= Lang::get("citaci.form.labels.active") ?></label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label"><?= Lang::get("citaci.form.labels.id") ?></label>
                            <input type="text" class="form-control" id="id_citaca">
                            <div class="form-text text-danger error-message" style="display: none;">
                                <ul style="list-style-type: '* '; padding-left: 1rem;"></ul>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label"><?= Lang::get("citaci.form.labels.type") ?></label>
                            <select class="form-select" id="tip_citaca">
                                <option disabled><?= Lang::get("common.choose") ?></option>
                                <option value="I" selected>I</option>
                                <option value="U">U</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label"><?= Lang::get("citaci.form.labels.serial_number_reader") ?></label>
                            <input type="text" class="form-control" id="sn_citaca">
                            <div class="form-text text-danger error-message" style="display: none;">
                                <ul style="list-style-type: '* '; padding-left: 1rem;"></ul>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label"><?= Lang::get("citaci.form.labels.serial_number_barrier") ?></label>
                            <input type="text" class="form-control" id="sn_barijere">
                            <div class="form-text text-danger error-message" style="display: none;">
                                <ul style="list-style-type: '* '; padding-left: 1rem;"></ul>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label"><?= Lang::get("citaci.form.labels.delay_time") ?></label>
                            <input type="text" class="form-control" id="delay">
                            <div class="form-text text-danger error-message" style="display: none;">
                                <ul style="list-style-type: '* '; padding-left: 1rem;"></ul>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label"><?= Lang::get("citaci.form.labels.delay_sensor") ?></label>
                            <input type="text" class="form-control" id="delay_senzora">
                            <div class="form-text text-danger error-message" style="display: none;">
                                <ul style="list-style-type: '* '; padding-left: 1rem;"></ul>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label"><?= Lang::get("citaci.form.labels.description") ?></label>
                            <input type="text" class="form-control" id="opis_citaca">
                            <div class="form-text text-danger error-message" style="display: none;">
                                <ul style="list-style-type: '* '; padding-left: 1rem;"></ul>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label"><?= Lang::get("citaci.form.labels.lockers_number") ?></label>
                            <input type="number" class="form-control" id="broj_ormarica">
                            <div class="form-text text-danger error-message" style="display: none;">
                                <ul style="list-style-type: '* '; padding-left: 1rem;"></ul>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label"><?= Lang::get("citaci.form.labels.lockers_rows") ?></label>
                            <input type="number" class="form-control" id="broj_redova_ormarica">
                            <div class="form-text text-danger error-message" style="display: none;">
                                <ul style="list-style-type: '* '; padding-left: 1rem;"></ul>
                            </div>
                        </div>
                        <div class="col-md-2 d-flex align-items-center">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" id="brojevi_ormarica_po_indexu">
                                <label class="form-check-label" for="brojevi_ormarica_po_indexu"><?= Lang::get("citaci.form.labels.lockers_by_index") ?></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label"><?= Lang::get("citaci.form.labels.ip_address") ?></label>
                            <input type="text" class="form-control" id="ip_address">
                            <div class="form-text text-danger error-message" style="display: none;">
                                <ul style="list-style-type: '* '; padding-left: 1rem;"></ul>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label"><?= Lang::get("citaci.form.labels.lockers_ids") ?></label>
                            <textarea class="form-control" rows="3" id="brojevi_ormarica"></textarea>
                            <div class="form-text text-danger"><?= Lang::get("citaci.form.textarea_help") ?></div>
                            <div class="form-text text-danger error-message" style="display: none;">
                                <ul style="list-style-type: '* '; padding-left: 1rem;"></ul>
                            </div>
                        </div>
                    </div>

                    <div class="section-title"><?= Lang::get("citaci.form.section_title") ?></div>

                    <div class="row">
                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="checkbox" id="citac_za_kontrolu_pristupa">
                            <label class="form-check-label" for="citac_za_kontrolu_pristupa"><?= Lang::get("citaci.form.checkboxes.access_control") ?></label>
                        </div>
                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="checkbox" id="citac_za_radno_vreme">
                            <label class="form-check-label" for="citac_za_radno_vreme"><?= Lang::get("citaci.form.checkboxes.working_time") ?></label>
                        </div>
                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="checkbox" id="citac_za_ormarice">
                            <label class="form-check-label" for="citac_za_ormarice"><?= Lang::get("citaci.form.checkboxes.for_lockers") ?></label>
                        </div>
                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="checkbox" id="citac_za_grupu_ormarica">
                            <label class="form-check-label" for="citac_za_grupu_ormarica"><?= Lang::get("citaci.form.checkboxes.for_lockers_group") ?></label>
                        </div>
                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="checkbox" id="citac_za_odjavu">
                            <label class="form-check-label" for="citac_za_odjavu"><?= Lang::get("citaci.form.checkboxes.for_logout") ?></label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-blue" id="citacEditBtn"><?= Lang::get("common.edit") ?></button>
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