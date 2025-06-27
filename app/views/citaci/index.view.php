<?php require base_path("app/views/inc/header.php") ?>
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
</style>

<div class="modal fade" id="deleteCitacModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content border-danger">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteCitacModalLabel">Potvrda brisanja</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Zatvori"></button>
            </div>
            <div class="modal-body">
                Da li ste sigurni da želite da obrišete čitač <strong><span id="modalCitac"></span></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Otkaži</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Obriši</button>
            </div>
        </div>
    </div>
</div>

<div id="alertBox" class="mt-3"></div>
<div class="d-flex justify-content-center align-items-start">
    <div class="mt-2" style="max-width: 95%; width: 100%;">
        <h2 class="text-center">Podešavanja čitača</h2>
        <div style="max-height: 75vh; overflow-y: auto; overflow-x: auto; width: 100%;" class="mt-3" id="citaciTableContainer">
            <table class="table table-bordered table-striped w-100 table-hover" style="table-layout: fixed; word-wrap: break-word;">
                <thead class="table-dark text-center align-middle">
                    <tr>
                        <th rowspan="3" colspan="1">ID</th>
                        <th rowspan="3" colspan="1">OPIS</th>
                        <th rowspan="3" colspan="1">TIP</th>
                        <th rowspan="3" colspan="1">AKTIVAN</th>
                        <th rowspan="1" colspan="5">VRSTA ČITAČA</th>
                        <th rowspan="2" colspan="2">DELAY</th>
                        <th rowspan="2" colspan="2">SN</th>
                        <th rowspan="2" colspan="3">ORMARIĆI</th>
                        <th rowspan="3" colspan="4">EDIT</th>
                    </tr>
                    <tr>
                        <th rowspan="1" colspan="2">EVIDENCIJA</th>
                        <th rowspan="1" colspan="3">OSTALO</th>
                    </tr>
                    <tr>
                        <th rowspan="1" colspan="1">Radnog vremena</th>
                        <th rowspan="1" colspan="1">Kontrola pristupa</th>
                        <th rowspan="1" colspan="1">Za ormariće</th>
                        <th rowspan="1" colspan="1">Za grupu ormarića</th>
                        <th rowspan="1" colspan="1">Za odjavu</th>
                        <th rowspan="1" colspan="1">Vremena</th>
                        <th rowspan="1" colspan="1">Senzora</th>
                        <th rowspan="1" colspan="1">Čitača</th>
                        <th rowspan="1" colspan="1">Barijere</th>
                        <th rowspan="1" colspan="1">Broj</th>
                        <th rowspan="1" colspan="1">Broj redova</th>
                        <th rowspan="1" colspan="1">Po indeksu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($config as $row) : ?>
                        <tr data-id="<?= $row['id_citaca'] ?>" class="citac-row">
                            <td class="text-center align-middle"><?= htmlspecialchars($row['id_citaca']) ?></td>
                            <td class="text-center align-middle"><?= htmlspecialchars($row['opis_citaca']) ?></td>
                            <td class="text-center align-middle"><?= htmlspecialchars($row['tip_citaca']) ?></td>
                            <td class="text-center align-middle"><?= $row['aktivan'] ? 'Da' : 'Ne' ?></td>
                            <td class="text-center align-middle"><?= $row['citac_za_radno_vreme'] ? 'Da' : 'Ne' ?></td>
                            <td class="text-center align-middle"><?= $row['citac_za_kontrolu_pristupa'] ? 'Da' : 'Ne' ?></td>
                            <td class="text-center align-middle"><?= $row['citac_za_ormarice'] ? 'Da' : 'Ne' ?></td>
                            <td class="text-center align-middle"><?= $row['citac_za_grupu_ormarica'] ? 'Da' : 'Ne' ?></td>
                            <td class="text-center align-middle"><?= $row['citac_za_odjavu'] ? 'Da' : 'Ne' ?></td>
                            <td class="text-center align-middle"><?= htmlspecialchars($row['delay']) ?></td>
                            <td class="text-center align-middle"><?= htmlspecialchars($row['delay_senzora']) ?></td>
                            <td class="text-center align-middle"><?= htmlspecialchars($row['sn_citaca']) ?></td>
                            <td class="text-center align-middle"><?= htmlspecialchars($row['sn_barijere']) ?></td>
                            <td class="text-center align-middle"><?= htmlspecialchars($row['broj_ormarica']) ?></td>
                            <td class="text-center align-middle"><?= htmlspecialchars($row['broj_redova_ormarica']) ?></td>
                            <td class="text-center align-middle"><?= $row['brojevi_ormarica_po_indexu'] ? 'Da' : 'Ne' ?></td>
                            <td class="text-center align-middle p-3">
                                <button class="btn btn-primary" id="citaci-edit-btn">Izmeni</button>
                            </td>
                            <td class="text-center align-middle p-3">
                                <button class="btn btn-danger" id="citaci-delete-btn">Obriši</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
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
                    <h5 class="modal-title" id="citacModalLabel">Izmena čitača</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Zatvori"></button>
                </div>
                <div class="modal-body">
                    <!-- Forma -->
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
                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="checkbox" id="citac_za_kontrolu_pristupa">
                            <label class="form-check-label" for="citac_za_kontrolu_pristupa">za kontrolu pristupa</label>
                        </div>
                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="checkbox" id="citac_za_radno_vreme">
                            <label class="form-check-label" for="citac_za_radno_vreme">za radno vreme</label>
                        </div>
                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="checkbox" id="citac_za_ormarice">
                            <label class="form-check-label" for="citac_za_ormarice">za ormariće</label>
                        </div>
                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="checkbox" id="citac_za_grupu_ormarica">
                            <label class="form-check-label" for="citac_za_grupu_ormarica">za grupu ormarića</label>
                        </div>
                        <div class="col-md-4 form-check">
                            <input class="form-check-input" type="checkbox" id="citac_za_odjavu">
                            <label class="form-check-label" for="citac_za_odjavu">za odjavu</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-blue" id="citacEditBtn">Izmeni</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Zatvori</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require base_path("app/views/inc/footer.php") ?>