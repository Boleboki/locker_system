<?php

use App\Core\Lang;

require base_path("app/views/inc/header.php") ?>
<?php require base_path("app/views/inc/nav.php") ?>

<style>
    body {
        background-color: #e3f2fd;
    }

    .form-section {
        background-color: #ffffff;
        border-radius: 8px;
        padding: 25px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-top: 40px;
    }

    .section-title {
        border-bottom: 1px solid #dee2e6;
        margin-bottom: 20px;
        padding-bottom: 10px;
        font-weight: bold;
        font-size: 1.3rem;
    }

    .form-check {
        margin-bottom: 10px;
    }

    .btn-blue {
        background-color: #0d6efd;
        color: white;
    }

    .btn-blue:hover {
        background-color: #0b5ed7;
    }
</style>

<div id="alertBox" class="mt-3"></div>

<div class="container">
    <div class="form-section" id="citaciAddForm">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="section-title"><?= Lang::get('citaci.form.create_title') ?></div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-1 d-flex align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="aktivan">
                    <label class="form-check-label" for="aktivan"><?= Lang::get('citaci.form.labels.active') ?></label>
                </div>
            </div>

            <div class="col-md-2">
                <label class="form-label"><?= Lang::get('citaci.form.labels.id') ?></label>
                <input type="text" class="form-control" id="id_citaca">
                <div class="form-text text-danger error-message" style="display: none;">
                    <ul style="list-style-type: '* '; padding-left: 1rem;"></ul>
                </div>
            </div>

            <div class="col-md-2">
                <label class="form-label"><?= Lang::get('citaci.form.labels.type') ?></label>
                <select class="form-select" id="tip_citaca">
                    <option disabled><?= Lang::get('common.choose') ?></option>
                    <option value="I" selected>I</option>
                    <option value="U">U</option>
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label"><?= Lang::get('citaci.form.labels.serial_number_reader') ?></label>
                <input type="text" class="form-control" id="sn_citaca">
                <div class="form-text text-danger error-message" style="display: none;">
                    <ul style="list-style-type: '* '; padding-left: 1rem;"></ul>
                </div>
            </div>

            <div class="col-md-2">
                <label class="form-label"><?= Lang::get('citaci.form.labels.serial_number_barrier') ?></label>
                <input type="text" class="form-control" id="sn_barijere">
                <div class="form-text text-danger error-message" style="display: none;">
                    <ul style="list-style-type: '* '; padding-left: 1rem;"></ul>
                </div>
            </div>

            <div class="col-md-2">
                <label class="form-label"><?= Lang::get('citaci.form.labels.delay_time') ?></label>
                <input type="text" class="form-control" id="delay">
                <div class="form-text text-danger error-message" style="display: none;">
                    <ul style="list-style-type: '* '; padding-left: 1rem;"></ul>
                </div>
            </div>

            <div class="col-md-2">
                <label class="form-label"><?= Lang::get('citaci.form.labels.delay_sensor') ?></label>
                <input type="text" class="form-control" id="delay_senzora">
                <div class="form-text text-danger error-message" style="display: none;">
                    <ul style="list-style-type: '* '; padding-left: 1rem;"></ul>
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label"><?= Lang::get('citaci.form.labels.description') ?></label>
                <input type="text" class="form-control" id="opis_citaca">
                <div class="form-text text-danger error-message" style="display: none;">
                    <ul style="list-style-type: '* '; padding-left: 1rem;"></ul>
                </div>
            </div>

            <div class="col-md-2">
                <label class="form-label"><?= Lang::get('citaci.form.labels.lockers_number') ?></label>
                <input type="number" class="form-control" id="broj_ormarica">
                <div class="form-text text-danger error-message" style="display: none;">
                    <ul style="list-style-type: '* '; padding-left: 1rem;"></ul>
                </div>
            </div>

            <div class="col-md-2">
                <label class="form-label"><?= Lang::get('citaci.form.labels.lockers_rows') ?></label>
                <input type="number" class="form-control" id="broj_redova_ormarica">
                <div class="form-text text-danger error-message" style="display: none;">
                    <ul style="list-style-type: '* '; padding-left: 1rem;"></ul>
                </div>
            </div>

            <div class="col-md-2 d-flex align-items-center">
                <div class="form-check mt-4">
                    <input class="form-check-input" type="checkbox" id="brojevi_ormarica_po_indexu">
                    <label class="form-check-label" for="brojevi_ormarica_po_indexu">
                        <?= Lang::get('citaci.form.labels.lockers_by_index') ?>
                    </label>
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
                <label class="form-label"><?= Lang::get('citaci.form.labels.lockers_ids') ?></label>
                <textarea class="form-control" rows="3" id="brojevi_ormarica"></textarea>
                <div class="form-text text-danger"><?= Lang::get('citaci.form.textarea_help') ?></div>
                <div class="form-text text-danger error-message" style="display: none;">
                    <ul style="list-style-type: '* '; padding-left: 1rem;"></ul>
                </div>
            </div>


        </div>


        <div class="section-title"><?= Lang::get('citaci.form.section_title') ?></div>

        <div class="row">
            <div class="col-md-3 form-check">
                <input class="form-check-input" type="checkbox" id="citac_za_kontrolu_pristupa">
                <label class="form-check-label" for="citac_za_kontrolu_pristupa">
                    <?= Lang::get('citaci.form.checkboxes.access_control') ?>
                </label>
            </div>

            <div class="col-md-3 form-check">
                <input class="form-check-input" type="checkbox" id="citac_za_radno_vreme">
                <label class="form-check-label" for="citac_za_radno_vreme">
                    <?= Lang::get('citaci.form.checkboxes.working_time') ?>
                </label>
            </div>

            <div class="col-md-3 form-check">
                <input class="form-check-input" type="checkbox" id="citac_za_ormarice">
                <label class="form-check-label" for="citac_za_ormarice">
                    <?= Lang::get('citaci.form.checkboxes.for_lockers') ?>
                </label>
            </div>

            <div class="col-md-3 form-check">
                <input class="form-check-input" type="checkbox" id="citac_za_grupu_ormarica">
                <label class="form-check-label" for="citac_za_grupu_ormarica">
                    <?= Lang::get('citaci.form.checkboxes.for_lockers_group') ?>
                </label>
            </div>

            <div class="col-md-3 form-check">
                <input class="form-check-input" type="checkbox" id="citac_za_odjavu">
                <label class="form-check-label" for="citac_za_odjavu">
                    <?= Lang::get('citaci.form.checkboxes.for_logout') ?>
                </label>
            </div>
        </div>

        <div class="text-end mt-4">
            <button class="btn btn-blue" id="citacAddBtn"><?= Lang::get('common.add') ?></button>
        </div>
    </div>
</div>

<?php require base_path("app/views/inc/footer.php") ?>