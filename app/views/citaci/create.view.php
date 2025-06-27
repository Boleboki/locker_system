<?php require base_path("app/views/inc/header.php") ?>
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
            <div class="section-title">Unos novog čitača</div>
        </div>

        <div class="row g-3 mb-3">
            <div class="col-md-1 d-flex align-items-center">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="aktivan">
                    <label class="form-check-label" for="aktivan">Aktivan</label>
                </div>
            </div>
            <div class="col-md-2">
                <label class="form-label">ID čitača</label>
                <input type="text" class="form-control" id="id_citaca">
            </div>
            <div class="col-md-2">
                <label class="form-label">Tip čitača</label>
                <select class="form-select" id="tip_citaca">
                    <option disabled>Izaberite...</option>
                    <option value="I" selected>I</option>
                    <option value="U">U</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">SN čitača</label>
                <input type="text" class="form-control" id="sn_citaca">
            </div>
            <div class="col-md-2">
                <label class="form-label">SN barijere</label>
                <input type="text" class="form-control" id="sn_barijere">
            </div>
            <div class="col-md-2">
                <label class="form-label">Delay vreme</label>
                <input type="text" class="form-control" id="delay">
            </div>
            <div class="col-md-2">
                <label class="form-label">Delay senzora</label>
                <input type="text" class="form-control" id="delay_senzora">
            </div>
            <div class="col-md-4">
                <label class="form-label">Opis čitača</label>
                <input type="text" class="form-control" id="opis_citaca">
            </div>
            <div class="col-md-2">
                <label class="form-label">Broj ormarića</label>
                <input type="number" class="form-control" id="broj_ormarica">
            </div>
            <div class="col-md-2">
                <label class="form-label">Broj redova</label>
                <input type="number" class="form-control" id="broj_redova_ormarica">
            </div>
            <div class="col-md-2 d-flex align-items-center">
                <div class="form-check mt-4">
                    <input class="form-check-input" type="checkbox" id="brojevi_ormarica_po_indexu">
                    <label class="form-check-label" for="brojevi_ormarica_po_indexu">Po indeksu niza</label>
                </div>
            </div>
            <div class="col-12">
                <label class="form-label">Brojevi ormarića / ID brojevi čitača</label>
                <textarea class="form-control" rows="3" id="brojevi_ormarica"></textarea>
                <div class="form-text text-danger">*koristite zarez za odvajanje ormarića</div>
            </div>
        </div>

        <div class="section-title">Funkcionalnosti čitača</div>

        <div class="row">
            <div class="col-md-3 form-check">
                <input class="form-check-input" type="checkbox" id="citac_za_kontrolu_pristupa">
                <label class="form-check-label" for="citac_za_kontrolu_pristupa">za kontrolu pristupa</label>
            </div>
            <div class="col-md-3 form-check">
                <input class="form-check-input" type="checkbox" id="citac_za_radno_vreme">
                <label class="form-check-label" for="citac_za_radno_vreme">za radno vreme</label>
            </div>
            <div class="col-md-3 form-check">
                <input class="form-check-input" type="checkbox" id="citac_za_ormarice">
                <label class="form-check-label" for="citac_za_ormarice">za ormariće</label>
            </div>
            <div class="col-md-3 form-check">
                <input class="form-check-input" type="checkbox" id="citac_za_grupu_ormarica">
                <label class="form-check-label" for="citac_za_grupu_ormarica">za grupu ormarića</label>
            </div>
            <div class="col-md-3 form-check">
                <input class="form-check-input" type="checkbox" id="citac_za_odjavu">
                <label class="form-check-label" for="citac_za_odjavu">za odjavu</label>
            </div>
        </div>

        <div class="text-end mt-4">
            <button class="btn btn-blue" id="citacAddBtn">Unesi</button>
        </div>
    </div>
</div>


<?php require base_path("app/views/inc/footer.php") ?>