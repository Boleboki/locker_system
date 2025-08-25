/**
 * Ovaj fajl postavlja sve događaje vezane za upravljanje čitačima:
 * dodavanje, izmena, brisanje i prikazivanje modala.
 * Koristi `CitaciManager` za komunikaciju sa backend-om
 * i `CitaciUI` za prikazivanje/skrivanje UI komponenti.
 *
 * @author
 * @version 1.0.1
 */

import { AuthUI } from "../auth/AuthUI.js";
import { showAlert } from "../helper.js";
import { CitaciManager } from "./CitaciManager.js";
import { CitaciUI } from "./CitaciUI.js";

/**
 * Inicijalizuje sve događaje za rad sa čitačima:
 * - klikovi na dugmad za izmenu/brisanje
 * - dvoklik za otvaranje forme
 * - potvrda brisanja
 * - dodavanje i izmena čitača
 */
export function initializeCitaciEvents() {
  const citaciTable = document.querySelector("#citaciTable");
  const citaciTableContainer = document.querySelector("#citaciTableContainer");
  const citaciAddForm = document.querySelector("#citaciAddForm");
  const citacModal = document.querySelector("#citacModal");
  const confirmCitacDeleteModal = document.querySelector("#deleteCitacModal");
  const searchInput = document.querySelector("#searchInput");
  const paginationContainer = document.querySelector("#paginationContainer");
  let row = null;
  const citaciTableBody = citaciTableContainer?.querySelector("tbody");

  async function loadAndRenderCitaci() {
    if (!citaciTableContainer || !citaciTableBody) return;
    const sessionMessage = sessionStorage.getItem("alertMessage");

    try {
      if (sessionMessage) {
        showAlert(sessionMessage, "success");
        sessionStorage.removeItem("alertMessage");
      }
      const response = await CitaciManager.getAll();
      if (!response.success) {
        showAlert(response.error, "danger");
        return;
      }
      CitaciUI.setTableData(response.data);
      CitaciUI.setPageSize(
        Number(document.querySelector("#poStranici")?.value) || 5
      );
      CitaciUI.renderTable();
    } catch (err) {
      showAlert("Error getting readers", "danger", null);
      console.error("Error getting readers:", err);
    }
  }
  paginationContainer?.addEventListener("click", (e) => {
    if (e.target.dataset.page) {
      CitaciUI.setCurrentPage(Number(e.target.dataset.page));
      CitaciUI.renderTable();
    }
  });
  document.querySelector("#poStranici")?.addEventListener("change", (e) => {
    CitaciUI.setPageSize(Number(e.target.value) || 5);
    CitaciUI.setCurrentPage(1);
    CitaciUI.renderTable();
  });
  loadAndRenderCitaci();
  let searchTimeout;

  searchInput?.addEventListener("input", (e) => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
      CitaciUI.setSearchValue(e.target.value);
      CitaciUI.renderTable();
    }, 300);
  });

  /**
   * Klik na dugmad u tabeli: brisanje ili uređivanje
   */
  citaciTableContainer?.addEventListener("click", async (e) => {
    if (e.target.closest("th")) {
      let sortField = e.target.closest("th")?.dataset.sort;
      if (!sortField) return;
      document.querySelectorAll("th[data-sort]").forEach((el) => {
        el.classList.remove("sort-asc", "sort-desc");
      });
      e.target.classList.remove("sort-asc", "sort-desc");
      if (e.target.dataset.order === "asc") {
        e.target.dataset.order = "desc";
        e.target.classList.add("sort-desc");
      } else {
        e.target.dataset.order = "asc";
        e.target.classList.add("sort-asc");
      }
      CitaciUI.toggleSort(sortField);
    }
    row = e.target.closest("tbody tr");
    if (!row) return;

    const id = row.dataset.id;
    if (!id) return;

    // Ako je kliknuto na dugme za brisanje čitača
    if (e.target.closest("#citaci-delete-btn")) {
      try {
        // Prikaz modala za potvrdu brisanja
        CitaciUI.showConfirmDeleteModal(id, "#" + id);
      } catch (error) {
        showAlert("Error deleting reader", "danger", null);
        console.error("Error deleting reader:", error);
      }
    }

    // Ako je kliknuto na dugme za izmenu čitača
    if (e.target.closest("#citaci-edit-btn")) {
      try {
        // Uzimanje podataka čitača sa servera
        const data = await CitaciManager.getById(id);
        // Otvaranje modala sa podacima za izmenu
        CitaciUI.showEditModal(data);
      } catch (error) {
        showAlert("Error opening reader editing modal", "danger", null);
        console.error("Error opening reader editing modal:", error);
      }
    }
  });

  /**
   * Potvrda brisanja čitača
   */
  confirmCitacDeleteModal?.addEventListener("click", async (e) => {
    if (e.target.id !== "confirmDeleteBtn") return;

    const id = row.dataset.id;
    if (!id) return;

    try {
      // Slanje zahteva za brisanje čitača
      const response = await CitaciManager.delete(id);
      if (response.success) {
        // Uspešno brisanje sa UI-ja i poruka korisniku
        showAlert(response.message, "success");
        row.remove();
        CitaciUI.hideConfirmDeleteModal();
      } else {
        showAlert(response.error, "danger");
      }
    } catch (error) {
      showAlert("Error deleting reader", "danger", null);
      console.error("Error deleting reader:", error);
    }
  });

  /**
   * Dvoklik na red u tabeli - otvara modal za izmenu
   */
  citaciTableContainer?.addEventListener("dblclick", async (e) => {
    row = e.target.closest("tbody tr");
    if (!row) return;

    // Dobavljanje podataka čitača i otvaranje forme za izmenu
    const data = await CitaciManager.getById(row.dataset.id);
    CitaciUI.showEditModal(data);
  });

  /**
   * Potvrda izmene čitača iz modala
   */
  citacModal?.addEventListener("click", async (e) => {
    if (e.target.id !== "citacEditBtn") return;

    try {
      // Sakupljanje podataka iz forme
      const data = CitaciUI.collectFormData();
      const response = await CitaciManager.update(row.dataset.id, data);
      CitaciUI.removeErrors();
      if (!response.success) {
        if (response.error) {
          showAlert(response.error, "danger");
          CitaciUI.closeEditModal();
          return;
        }
        for (const [field, errors] of Object.entries(response.errors)) {
          const errorsField = document
            .getElementById(field)
            ?.closest("div")
            ?.querySelector(".error-message");
          CitaciUI.displayError(errorsField, errors);
        }
        return;
      }
      showAlert(response.message, "success");
      // Ažuriranje prikaza u tabeli
      CitaciUI.updateRowValue(row, response.data);
      CitaciUI.closeEditModal();
    } catch (error) {
      CitaciUI.closeEditModal();
      showAlert("Error updating reader", "danger", null);
      console.error("Error updating reader:", error);
    }
  });

  /**
   * Dodavanje novog čitača
   */
  citaciAddForm?.addEventListener("click", async (e) => {
    if (e.target.id !== "citacAddBtn") return;

    // Sakupljanje podataka iz forme
    const data = CitaciUI.collectFormData();
    CitaciUI.removeErrors();

    try {
      // Slanje zahteva za dodavanje novog čitača
      const response = await CitaciManager.add(data);
      if (!response.success) {
        if (response.error) {
          showAlert(response.error, "danger");
          CitaciUI.closeEditModal();
          return;
        }
        for (const [field, errors] of Object.entries(response.errors)) {
          const inputField = document.getElementById(field);

          const errorsField = inputField
            ?.closest("div")
            ?.querySelector(".error-message");

          inputField?.closest(".accordion-collapse")?.classList.add("show");
          CitaciUI.displayError(errorsField, errors);
        }
        return;
      }
      if (response.redirect) {
        sessionStorage.setItem("alertMessage", response.message);
        location.href = response.redirect;
        return;
      }
      showAlert(response.message, "success");
      CitaciUI.formReset();
    } catch (error) {
      showAlert("Error adding reader", "danger", null);
      console.error("Error adding reader:", error);
    }
  });
}
