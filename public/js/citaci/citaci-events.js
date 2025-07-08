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
  const citaciTable = document.querySelector("#citaciTableContainer");
  const citaciAddForm = document.querySelector("#citaciAddForm");
  const citacModal = document.querySelector("#citacModal");
  const confirmCitacDeleteModal = document.querySelector("#deleteCitacModal");
  const searchInput = document.getElementById("searchInput");
  const searchIcon = document.getElementById("search-icon");

  let row = null;
  const citaciTableBody = citaciTable?.querySelector("tbody");

  let currentSortField = null;
  let currentSortDirection = "asc";
  async function loadAndRenderCitaci({ sortField = null, search = null } = {}) {
    if (!citaciTable || !citaciTableBody) return;

    // Uzimamo trenutne URL parametre da bismo ih zadržali
    const currentParams = CitaciUI.getQueryParams();
    const urlParams = {};

    // Ako je prosleđen search iz inputa, koristi ga; ako nije, koristi iz URL-a
    if (search !== null) {
      if (search.trim() !== "") urlParams.search = search.trim();
    } else if (currentParams.search?.trim()) {
      urlParams.search = currentParams.search.trim();
    }

    // Ako je prosleđen novi sort, ažuriraj direction i field
    if (sortField !== null) {
      if (currentSortField === sortField) {
        currentSortDirection = currentSortDirection === "asc" ? "desc" : "asc";
      } else {
        currentSortField = sortField;
        currentSortDirection = "asc";
      }
      urlParams.sort = currentSortField;
      urlParams.direction = currentSortDirection;
    } else if (currentParams.sort) {
      // Ako nije prosleđen novi sort, koristi prethodne vrednosti iz URL-a
      currentSortField = currentParams.sort;
      currentSortDirection = currentParams.direction || "asc";
      urlParams.sort = currentSortField;
      urlParams.direction = currentSortDirection;
    }

    CitaciUI.updateUrl(urlParams); // Ažuriraj URL samo sa relevantnim vrednostima

    try {
      const response = await CitaciManager.getAll(
        urlParams.sort || "",
        urlParams.direction || "asc",
        urlParams.search || ""
      );
      if (response.success)
        CitaciUI.renderTable(citaciTableBody, response.data);
    } catch (err) {
      showAlert("Error getting readers: " + err, "danger");
      console.error("Error getting readers:", err);
    }
  }

  // Pozovi odmah na inicijalizaciji (kada se DOM učita)
  const params = CitaciUI.getQueryParams();
  if (searchInput && params.search) {
    searchInput.value = params.search;
  }
  loadAndRenderCitaci();

  // Search ikonica klik
  searchIcon?.addEventListener("click", () => {
    loadAndRenderCitaci({ search: searchInput.value.trim() });
  });

  // Enter u search inputu
  searchInput?.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
      e.preventDefault();
      loadAndRenderCitaci({ search: searchInput.value.trim() });
    }
  });

  /**
   * Klik na dugmad u tabeli: brisanje ili uređivanje
   */
  citaciTable?.addEventListener("click", async (e) => {
    if (e.target.closest("th")) {
      const sortData = e.target.closest("th")?.dataset.sort;
      if (!sortData) return;
      await loadAndRenderCitaci({ sortField: sortData });
      return;
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
        showAlert("Error deleting reader: " + error, "danger");
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
        showAlert("Error opening reader editing modal: " + error, "danger");
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
      showAlert("Error deleting reader: " + error, "danger");
      console.error("Error deleting reader:", error);
    }
  });

  /**
   * Dvoklik na red u tabeli - otvara modal za izmenu
   */
  citaciTable?.addEventListener("dblclick", async (e) => {
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
        if (response.serverError) {
          showAlert(response.serverError, "danger");
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
      showAlert("Error updating reader: " + error, "danger");
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
        if (response.serverError) {
          showAlert(response.serverError, "danger");
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
      CitaciUI.formReset();
    } catch (error) {
      showAlert("Error adding reader: " + error, "danger");
      console.error("Error adding reader:", error);
    }
  });
}
