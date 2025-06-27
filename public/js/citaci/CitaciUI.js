/**
 * Klasa CitaciUI upravlja korisničkim interfejsom za prikaz, uređivanje i brisanje čitača.
 *
 * Služi za:
 * - Prikaz modala za izmenu čitača sa popunjenim podacima
 * - Ažuriranje vrednosti reda u tabeli u interfejsu
 * - Otvaranje i zatvaranje modala za potvrdu brisanja
 *
 * @author
 * @version 1.0.1
 */

export class CitaciUI {
  modal = null;

  /**
   * Prikazuje modal za uređivanje čitača i popunjava formu sa podacima.
   *
   * @param {Object} data - Podaci o čitaču koji se uređuje.
   */
  static showEditModal(data) {
    document.getElementById("id_citaca").value = data.id_citaca || "";
    document.getElementById("opis_citaca").value = data.opis_citaca || "";
    document.getElementById("tip_citaca").value = data.tip_citaca || "";
    document.getElementById("delay").value = data.delay || "";
    document.getElementById("delay_senzora").value = data.delay_senzora || "";
    document.getElementById("sn_citaca").value = data.sn_citaca || "";
    document.getElementById("sn_barijere").value = data.sn_barijere || "";
    document.getElementById("broj_ormarica").value = data.broj_ormarica || "";
    document.getElementById("broj_redova_ormarica").value =
      data.broj_redova_ormarica || "";
    document.getElementById("brojevi_ormarica").value =
      data.brojevi_ormarica || "";

    // Popunjavanje checkbox-ova na osnovu vrednosti (0 ili 1)
    document.getElementById("aktivan").checked = data.aktivan == 1;
    document.getElementById("citac_za_radno_vreme").checked =
      data.citac_za_radno_vreme == 1;
    document.getElementById("citac_za_kontrolu_pristupa").checked =
      data.citac_za_kontrolu_pristupa == 1;
    document.getElementById("citac_za_ormarice").checked =
      data.citac_za_ormarice == 1;
    document.getElementById("citac_za_grupu_ormarica").checked =
      data.citac_za_grupu_ormarica == 1;
    document.getElementById("citac_za_odjavu").checked =
      data.citac_za_odjavu == 1;

    // Checkbox za prikaz po indeksu
    document.getElementById("brojevi_ormarica_po_indexu").checked =
      data.brojevi_ormarica_po_indexu == 1;

    // Inicijalizacija i prikaz Bootstrap modala
    this.modal = new bootstrap.Modal(document.getElementById("citacModal"));
    this.modal.show();
  }

  /**
   * Ažurira podatke u prikazanoj HTML tabeli u skladu sa prosleđenim podacima.
   *
   * @param {HTMLElement} row - Red u tabeli koji treba ažurirati.
   * @param {Object} data - Novi podaci koji se prikazuju u redu.
   */
  static updateRowValue(row, data) {
    if (!row || !data) return;

    row.dataset.id = data.id_citaca || "";
    const cells = row.querySelectorAll("td");
    let i = 0;

    cells[i++].textContent = data.id_citaca ?? "";
    cells[i++].textContent = data.opis_citaca ?? "";
    cells[i++].textContent = data.tip_citaca ?? "";
    cells[i++].textContent = data.aktivan == 1 ? "Da" : "Ne";
    cells[i++].textContent = data.citac_za_radno_vreme == 1 ? "Da" : "Ne";
    cells[i++].textContent = data.citac_za_kontrolu_pristupa == 1 ? "Da" : "Ne";
    cells[i++].textContent = data.citac_za_ormarice == 1 ? "Da" : "Ne";
    cells[i++].textContent = data.citac_za_grupu_ormarica == 1 ? "Da" : "Ne";
    cells[i++].textContent = data.citac_za_odjavu == 1 ? "Da" : "Ne";
    cells[i++].textContent = data.delay ?? "";
    cells[i++].textContent = data.delay_senzora ?? "";
    cells[i++].textContent = data.sn_citaca ?? "";
    cells[i++].textContent = data.sn_barijere ?? "";
    cells[i++].textContent = data.broj_ormarica ?? "";
    cells[i++].textContent = data.broj_redova_ormarica ?? "";
    cells[i++].textContent = data.brojevi_ormarica_po_indexu == 1 ? "Da" : "Ne";
  }

  /**
   * Zatvara modal za uređivanje ako je otvoren.
   */
  static closeEditModal() {
    if (this.modal) {
      this.modal.hide();
    }
  }

  /**
   * Prikazuje modal za potvrdu brisanja čitača.
   *
   * @param {number} citacId - ID čitača koji se briše
   * @param {string} citacOpis - Opis čitača (prikazuje se korisniku)
   */
  static showConfirmDeleteModal(citacId, citacOpis = "") {
    const modal = document.getElementById("deleteCitacModal");
    if (!modal) return;

    document.getElementById("modalCitac").textContent = citacOpis;
    document.getElementById("confirmDeleteBtn").dataset.id = citacId;

    const deleteModal = new bootstrap.Modal(modal);
    deleteModal.show();
  }

  /**
   * Zatvara modal za potvrdu brisanja čitača.
   */
  static hideConfirmDeleteModal() {
    const modal = document.getElementById("deleteCitacModal");
    if (modal) {
      const deleteModal = bootstrap.Modal.getInstance(modal);
      if (deleteModal) {
        deleteModal.hide();
      }
    }
  }

  /**
   * Resetuje polja forme na podrazumevane vrednosti.
   * - Poništava sve unešene tekstualne vrednosti i postavlja checkbox-ove
   *   na inicijalne vrednosti (npr. `aktivan` i `po_indeksu` su čekirani).
   */
  static formReset() {
    // Resetuje input polja (tekstualna i numerička)
    document.getElementById("id_citaca").value = "";
    document.getElementById("opis_citaca").value = "";
    document.getElementById("tip_citaca").value = "";
    document.getElementById("delay").value = "";
    document.getElementById("delay_senzora").value = "";
    document.getElementById("sn_citaca").value = "";
    document.getElementById("sn_barijere").value = "";
    document.getElementById("broj_ormarica").value = "";
    document.getElementById("broj_redova_ormarica").value = "";
    document.getElementById("brojevi_ormarica").value = "";

    // Resetuje checkbox-ove na podrazumevane vrednosti
    document.getElementById("aktivan").checked = false;
    document.getElementById("citac_za_radno_vreme").checked = false;
    document.getElementById("citac_za_kontrolu_pristupa").checked = false;
    document.getElementById("citac_za_ormarice").checked = false;
    document.getElementById("citac_za_grupu_ormarica").checked = false;
    document.getElementById("citac_za_odjavu").checked = false;
    document.getElementById("brojevi_ormarica_po_indexu").checked = false;

    // Zatvara modal ako je otvoren
    this.closeEditModal();
  }

  /**
   * Prikuplja podatke iz forme za čitač iz DOM elemenata.
   *
   * @returns {Object} - Objekat sa svim vrednostima iz forme, spreman za slanje backendu.
   */
  static collectFormData() {
    return {
      // Tekstualna i numerička polja
      id_citaca: document.getElementById("id_citaca").value,
      opis_citaca: document.getElementById("opis_citaca").value,
      tip_citaca: document.getElementById("tip_citaca").value,
      delay: document.getElementById("delay").value,
      delay_senzora: document.getElementById("delay_senzora").value,
      sn_citaca: document.getElementById("sn_citaca").value,
      sn_barijere: document.getElementById("sn_barijere").value,
      broj_ormarica: document.getElementById("broj_ormarica").value,
      broj_redova_ormarica: document.getElementById("broj_redova_ormarica")
        .value,
      brojevi_ormarica: document.getElementById("brojevi_ormarica").value,

      // Checkbox polja (vraćaju true/false)
      aktivan: document.getElementById("aktivan").checked,
      citac_za_radno_vreme: document.getElementById("citac_za_radno_vreme")
        .checked,
      citac_za_kontrolu_pristupa: document.getElementById(
        "citac_za_kontrolu_pristupa"
      ).checked,
      citac_za_ormarice: document.getElementById("citac_za_ormarice").checked,
      citac_za_grupu_ormarica: document.getElementById(
        "citac_za_grupu_ormarica"
      ).checked,
      citac_za_odjavu: document.getElementById("citac_za_odjavu").checked,
      brojevi_ormarica_po_indexu: document.getElementById(
        "brojevi_ormarica_po_indexu"
      ).checked,
    };
  }
}
