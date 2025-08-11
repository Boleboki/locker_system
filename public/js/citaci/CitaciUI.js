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
    document.getElementById("ip_address").value = data.ip_address || "";

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
    cells[i++].textContent = data.ip_address ?? "";
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
    document.getElementById("ip_address").value = "";

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
      ip_address: document.getElementById("ip_address").value,
    };
  }

  static getQueryParams() {
    const params = new URLSearchParams(window.location.search);
    return {
      sort: params.get("sort") || "",
      direction: params.get("direction") || "asc",
      search: params.get("search") || "",
    };
  }

  static updateUrl(params) {
    const query = new URLSearchParams(params).toString();
    const newUrl = `${window.location.pathname}?${query}`;
    history.pushState(null, "", newUrl);
  }

  static tableData = {};
  static sortDirection = 1;
  static sortField = null;
  static pageSize = 5;
  static searchValue = "";
  static currentPage = 1;

  static setTableData(data) {
    this.tableData = data;
  }
  static setPageSize(size) {
    if (size < 1) return;
    this.pageSize = size;
  }
  static setSearchValue(value) {
    this.searchValue = value;
    this.setCurrentPage(1);
  }
  static setCurrentPage(page) {
    if (page > Math.ceil(this.tableData.length / this.pageSize) || page < 1)
      return;
    this.currentPage = page;
  }

  static nextPage() {
    this.setCurrentPage(this.currentPage + 1);
    this.renderTable();
  }
  static prevPage() {
    this.setCurrentPage(this.currentPage - 1);
    this.renderTable();
  }
  static toggleSort(column) {
    if (!column) return;
    this.setCurrentPage(1);
    if (this.sortField === column) {
      this.sortDirection *= -1;
    } else {
      this.sortField = column;
      this.sortDirection = 1;
    }
    this.renderTable();
  }

  static renderPagination(currentPage, totalPages, data = this.tableData) {
    const container = document.querySelector(
      "#paginationContainer .pagination"
    );
    const showedNumber = document.querySelector("#showedNumber");
    const totalNumber = document.querySelector("#totalNumber");
    container.innerHTML = "";

    const createButton = (
      label,
      page,
      isActive = false,
      isDisabled = false
    ) => {
      const btn = document.createElement("button");
      btn.textContent = label;
      btn.classList.add("page-btn");
      if (isActive) btn.classList.add("active");
      if (isDisabled) btn.disabled = true;
      btn.dataset.page = page;
      return btn;
    };

    const maxButtons = 5;

    container.appendChild(
      createButton("«", currentPage - 1, false, currentPage === 1)
    );

    if (totalPages <= maxButtons) {
      for (let i = 1; i <= totalPages; i++) {
        container.appendChild(createButton(i, i, i === currentPage));
      }
    } else {
      if (currentPage <= maxButtons - 2) {
        for (let i = 1; i <= maxButtons - 1; i++) {
          container.appendChild(createButton(i, i, i === currentPage));
        }
        container.appendChild(createButton("...", -1, false, true));
        container.appendChild(createButton(totalPages, totalPages));
      } else if (currentPage >= totalPages - 2) {
        container.appendChild(createButton(1, 1));
        container.appendChild(createButton("...", -1, false, true));
        for (let i = totalPages - 3; i <= totalPages; i++) {
          container.appendChild(createButton(i, i, i === currentPage));
        }
      } else {
        container.appendChild(createButton(1, 1));
        container.appendChild(createButton("...", -1, false, true));
        for (let i = currentPage - 1; i <= currentPage + 1; i++) {
          container.appendChild(createButton(i, i, i === currentPage));
        }
        container.appendChild(createButton("...", -1, false, true));
        container.appendChild(createButton(totalPages, totalPages));
      }
    }

    container.appendChild(
      createButton("»", currentPage + 1, false, currentPage === totalPages)
    );
    showedNumber.textContent = `${
      (this.currentPage - 1) * this.pageSize + 1
    }-${Math.min(this.currentPage * this.pageSize, data.length)}`;
    if (data.length === 0) {
      showedNumber.textContent = "0";
    }
    totalNumber.textContent = data.length;
  }

  static sortTableData(data = this.tableData) {
    if (!this.sortField) return data;
    return data.sort((a, b) => {
      if (a[this.sortField] < b[this.sortField]) return -this.sortDirection;
      if (a[this.sortField] > b[this.sortField]) return this.sortDirection;
      return 0;
    });
  }
  static filterTableData(data = this.tableData) {
    if (!this.searchValue) return this.tableData;
    return data.filter((item) => {
      return Object.values(item).some((value) =>
        String(value).toLowerCase().includes(this.searchValue.toLowerCase())
      );
    });
  }
  static paginateTableData(data = this.tableData) {
    const start = (this.currentPage - 1) * this.pageSize;
    return data.slice(start, start + this.pageSize);
  }

  static renderTable(data = this.tableData) {
    const tbody = document.querySelector("#citaciTableContainer tbody");
    tbody.innerHTML = "";
    let filteredData = this.filterTableData(data);
    let sortedData = this.sortTableData(filteredData);
    const finalData = this.paginateTableData(sortedData);
    this.renderPagination(
      this.currentPage,
      Math.ceil(filteredData.length / this.pageSize),
      filteredData
    );
    const t = window.translations || {
      yes: "Yes",
      no: "No",
      edit: "Edit",
      delete: "Delete",
    };

    finalData.forEach((item) => {
      const row = document.createElement("tr");
      row.dataset.id = item.id_citaca;
      row.classList.add("citac-row");

      // Helper za bezbedan tekstualni prikaz
      const safe = (value) => document.createTextNode(value ?? "");

      const createCell = (value, classes = "") => {
        const td = document.createElement("td");
        td.className = `text-center align-middle ${classes}`.trim();
        td.appendChild(safe(value));
        return td;
      };

      row.appendChild(createCell(item.id_citaca));
      row.appendChild(createCell(item.opis_citaca));
      row.appendChild(createCell(item.tip_citaca));
      row.appendChild(createCell(item.aktivan == 1 ? t.yes : t.no));
      row.appendChild(
        createCell(item.citac_za_radno_vreme == 1 ? t.yes : t.no)
      );
      row.appendChild(
        createCell(item.citac_za_kontrolu_pristupa == 1 ? t.yes : t.no)
      );
      row.appendChild(createCell(item.citac_za_ormarice == 1 ? t.yes : t.no));
      row.appendChild(
        createCell(item.citac_za_grupu_ormarica == 1 ? t.yes : t.no)
      );
      row.appendChild(createCell(item.citac_za_odjavu == 1 ? t.yes : t.no));
      row.appendChild(createCell(item.delay));
      row.appendChild(createCell(item.delay_senzora));
      row.appendChild(createCell(item.sn_citaca));
      row.appendChild(createCell(item.sn_barijere));
      row.appendChild(createCell(item.ip_address)); // dodatno, ako ti treba
      row.appendChild(createCell(item.broj_ormarica));
      row.appendChild(createCell(item.broj_redova_ormarica));
      row.appendChild(
        createCell(item.brojevi_ormarica_po_indexu == 1 ? t.yes : t.no)
      );

      // Edit dugme
      const editTd = document.createElement("td");
      editTd.className = "text-center align-middle p-3";
      const editBtn = document.createElement("button");
      editBtn.className = "btn btn-primary";
      editBtn.id = "citaci-edit-btn";
      editBtn.dataset.id = item.id_citaca;
      editBtn.innerHTML = `<i class="fa-solid fa-pencil"></i>`;
      editTd.appendChild(editBtn);

      // Delete dugme
      const deleteTd = document.createElement("td");
      deleteTd.className = "text-center align-middle p-3";
      const deleteBtn = document.createElement("button");
      deleteBtn.className = "btn btn-danger";
      deleteBtn.id = "citaci-delete-btn";
      deleteBtn.dataset.id = item.id_citaca;
      deleteBtn.dataset.opis = item.opis_citaca;
      deleteBtn.innerHTML = `<i class="fa-solid fa-trash"></i>`;
      deleteTd.appendChild(deleteBtn);

      row.appendChild(editTd);
      row.appendChild(deleteTd);

      tbody.appendChild(row);
    });
  }
  static removeErrors() {
    document.querySelectorAll(".error-message ul").forEach((ul) => {
      ul.innerHTML = "";
    });
  }

  static displayError(errorField, messages) {
    const ul = errorField?.querySelector("ul");
    if (!ul) return;
    ul.innerHTML = "";

    errorField.style.display = "block";

    messages.forEach((msg) => {
      const li = document.createElement("li");
      li.textContent = msg;
      ul.appendChild(li);
    });
  }
}
