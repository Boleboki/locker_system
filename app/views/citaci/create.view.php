<?php

use App\Core\Lang;

require base_path("app/views/inc/header.php") ?>
<?php require base_path("app/views/inc/nav.php") ?>

<style>
    .form-section {
        background-color: var(--bg-content);
        border-radius: 8px;
        padding: 25px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-top: 40px;
    }

    .section-title {
        border-bottom: 1px solid var(--table-border);
        margin-bottom: 20px;
        padding-bottom: 10px;
        font-weight: bold;
        font-size: 1.3rem;
        color: var(--text-primary);
    }

    .form-check {
        margin-bottom: 10px;
    }

    .btn-blue {
        background-color: var(--primary-color);
        color: var(--btn-primary-text);
        padding: 0.5rem 1rem;
        border-radius: 10px;
        border: none;
    }

    .btn-blue:hover {
        transform: scale(1.05);
        transition: all 0.3s ease;
    }

    input.form-control,
    select.form-select,
    textarea.form-control {
        background-color: var(--input-bg);
        color: var(--input-text);
        border: 1px solid var(--input-border);
    }


    input.form-control:focus,
    select.form-select:focus,
    textarea.form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }
</style>


<div id="alertBox" class="mt-3"></div>

<div class="container">
    <div class="form-section" id="citaciAddForm">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="section-title"><?= Lang::get('reader.form.create_title') ?></div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-1 d-flex align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="aktivan">
                    <label class="form-check-label" for="aktivan"><?= Lang::get('reader.form.labels.active') ?></label>
                </div>
            </div>

            <div class="col-md-2">
                <label class="form-label"><?= Lang::get('reader.form.labels.id') ?></label>
                <input type="text" class="form-control" id="id_citaca">
                <div class="form-text text-danger error-message">
                    <ul></ul>
                </div>
            </div>

            <div class="col-md-2">
                <label class="form-label"><?= Lang::get('reader.form.labels.type') ?></label>
                <select class="form-select" id="tip_citaca">
                    <option disabled><?= Lang::get('common.choose') ?></option>
                    <option value="I" selected>I</option>
                    <option value="U">U</option>
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label"><?= Lang::get('reader.form.labels.serial_number_reader') ?></label>
                <input type="text" class="form-control" id="sn_citaca">
                <div class="form-text text-danger error-message">
                    <ul></ul>
                </div>
            </div>

            <div class="col-md-2">
                <label class="form-label"><?= Lang::get('reader.form.labels.serial_number_barrier') ?></label>
                <input type="text" class="form-control" id="sn_barijere">
                <div class="form-text text-danger error-message">
                    <ul></ul>
                </div>
            </div>

            <div class="col-md-2">
                <label class="form-label"><?= Lang::get('reader.form.labels.delay_time') ?></label>
                <input type="text" class="form-control" id="delay">
                <div class="form-text text-danger error-message">
                    <ul></ul>
                </div>
            </div>

            <div class="col-md-2">
                <label class="form-label"><?= Lang::get('reader.form.labels.delay_sensor') ?></label>
                <input type="text" class="form-control" id="delay_senzora">
                <div class="form-text text-danger error-message">
                    <ul></ul>
                </div>
            </div>

            <div class="col-md-4">
                <label class="form-label"><?= Lang::get('reader.form.labels.description') ?></label>
                <input type="text" class="form-control" id="opis_citaca">
                <div class="form-text text-danger error-message">
                    <ul></ul>
                </div>
            </div>

            <div class="col-md-2">
                <label class="form-label"><?= Lang::get('reader.form.labels.lockers_number') ?></label>
                <input type="number" class="form-control" id="broj_ormarica">
                <div class="form-text text-danger error-message">
                    <ul></ul>
                </div>
            </div>

            <div class="col-md-2">
                <label class="form-label"><?= Lang::get('reader.form.labels.lockers_rows') ?></label>
                <input type="number" class="form-control" id="broj_redova_ormarica">
                <div class="form-text text-danger error-message">
                    <ul></ul>
                </div>
            </div>

            <div class="col-md-2 d-flex align-items-center">
                <div class="form-check mt-4">
                    <input class="form-check-input" type="checkbox" id="brojevi_ormarica_po_indexu">
                    <label class="form-check-label" for="brojevi_ormarica_po_indexu">
                        <?= Lang::get('reader.form.labels.lockers_by_index') ?>
                    </label>
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
                <label class="form-label"><?= Lang::get('reader.form.labels.lockers_ids') ?></label>
                <textarea class="form-control" rows="3" id="brojevi_ormarica"></textarea>
                <div class="form-text text-danger"><?= Lang::get('reader.form.textarea_help') ?></div>
                <div class="form-text text-danger error-message">
                    <ul></ul>
                </div>
            </div>


        </div>


        <div class="section-title"><?= Lang::get('reader.form.section_title') ?></div>

        <div class="row">
            <div class="col-md-3 form-check">
                <input class="form-check-input" type="checkbox" id="citac_za_kontrolu_pristupa">
                <label class="form-check-label" for="citac_za_kontrolu_pristupa">
                    <?= Lang::get('reader.form.checkboxes.access_control') ?>
                </label>
            </div>

            <div class="col-md-3 form-check">
                <input class="form-check-input" type="checkbox" id="citac_za_radno_vreme">
                <label class="form-check-label" for="citac_za_radno_vreme">
                    <?= Lang::get('reader.form.checkboxes.working_time') ?>
                </label>
            </div>

            <div class="col-md-3 form-check">
                <input class="form-check-input" type="checkbox" id="citac_za_ormarice">
                <label class="form-check-label" for="citac_za_ormarice">
                    <?= Lang::get('reader.form.checkboxes.for_lockers') ?>
                </label>
            </div>

            <div class="col-md-3 form-check">
                <input class="form-check-input" type="checkbox" id="citac_za_grupu_ormarica">
                <label class="form-check-label" for="citac_za_grupu_ormarica">
                    <?= Lang::get('reader.form.checkboxes.for_lockers_group') ?>
                </label>
            </div>

            <div class="col-md-3 form-check">
                <input class="form-check-input" type="checkbox" id="citac_za_odjavu">
                <label class="form-check-label" for="citac_za_odjavu">
                    <?= Lang::get('reader.form.checkboxes.for_logout') ?>
                </label>
            </div>
        </div>

        <div class="text-end mt-4">
            <button class="btn-blue" id="citacAddBtn"><?= Lang::get('common.add') ?></button>
        </div>
    </div>
</div>

<?php require base_path("app/views/inc/footer.php") ?>