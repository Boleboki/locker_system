/**
 * Klasa ConfigurationUI upravlja prikazom i interakcijom modala za konfiguraciju
 * i omogućava ažuriranje i brisanje redova u UI tabeli konfiguracionih podataka.
 * @author
 * @version 1.0.1
 */
const unsavedWarning = document.getElementById("unsavedWarning");
export class ConfigurationUI {
  static originalValue = "";
  static hasChanges = false;
  /**
   * Otvara modalni prozor za uređivanje konfiguracione stavke.
   * Postavlja ključ, vrednost i opis konfiguracije u modal.
   *
   * @param {string} key - ključ konfiguracione stavke koja se uređuje.
   * @param {string} value - trenutna vrednost konfiguracione stavke.
   * @param {string} opis - opis konfiguracione stavke (objašnjenje).
   */
  static openModal(key, value, opis) {
    // Postavljanje teksta u modal elemente
    document.getElementById("modalKey").textContent = key;
    document.getElementById("value").textContent = value;
    document.getElementById("modalDescription").textContent = opis;
    this.originalValue = value;
    this.hasChanges = false;
    // Prikaz modala (pravljenje vidljivim)
    unsavedWarning.style.display;
    document.getElementById("editModal").style.display = "block";
  }

  static showConfirm() {
    // Prikaz upozorenja ako postoje nesnimljene promene
    unsavedWarning.style.display = "block";
  }
  /**
   * Zatvara modalni prozor za uređivanje konfiguracije.
   * Ne prima parametre.
   */
  static closeModal() {
    // Sakrivanje modala (uklanjanje sa ekrana)
    document.getElementById("editModal").style.display = "none";
    unsavedWarning.style.display = "none";
  }

  /**
   * Ažurira vrednost u određenom redu tabele.
   * Pretpostavlja se da je vrednost u drugoj ćeliji reda (td:nth-child(2)).
   *
   * @param {HTMLElement} row - HTML element reda tabele koji treba da se ažurira.
   * @param {string} value - nova vrednost koja će biti postavljena u ćeliju.
   */
  static updateRowValue(row, value) {
    // Pronalazi ćeliju sa vrednošću u redu i menja njen tekst
    const valueCell = row.querySelector("td:nth-child(2)");
    if (valueCell) {
      valueCell.textContent = value;
    }
  }

  /**
   * Briše dati red iz tabele.
   *
   * @param {HTMLElement} row - HTML element reda koji treba ukloniti iz DOM-a.
   */
  static deleteRow(row) {
    // Uklanja red ako postoji
    if (row) {
      row.remove();
    }
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

    errorField.classList.add("visible");

    messages.forEach((msg) => {
      const li = document.createElement("li");
      li.textContent = msg;
      ul.appendChild(li);
    });
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

  static filterTableData(data = this.tableData) {
    if (!this.searchValue) return this.tableData;
    const searchValue = this.searchValue.toLowerCase();
    return data.filter((item) => {
      return Object.values(item).some((value) =>
        String(value).toLowerCase().includes(searchValue)
      );
    });
  }
  static paginateTableData(data = this.tableData) {
    const start = (this.currentPage - 1) * this.pageSize;
    return data.slice(start, start + this.pageSize);
  }

  static renderTable(data = this.tableData) {
    const tbody = document.querySelector("#configTableContainer tbody");
    tbody.innerHTML = "";
    let filteredData = this.filterTableData(data);
    const finalData = this.paginateTableData(filteredData);
    this.renderPagination(
      this.currentPage,
      Math.ceil(filteredData.length / this.pageSize),
      filteredData
    );

    finalData.forEach((item) => {
      const tr = document.createElement("tr");
      tr.innerHTML = `
        <td>${item.name ?? ""}</td>
        <td>${item.par ?? ""}</td>
        <td>${item.opis ?? ""}</td>
        <td>${item.tip ?? ""}</td>
      `;
      tbody.appendChild(tr);
    });
  }
}
