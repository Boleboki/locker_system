/**
 * Ovaj fajl postavlja sve događaje vezane za upravljanje čitačima:
 * dodavanje, izmena, brisanje i prikazivanje modala.
 * Koristi `CitaciManager` za komunikaciju sa backend-om
 * i `CitaciUI` za prikazivanje/skrivanje UI komponenti.
 *
 * @author
 * @version 1.0.1
 */

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

  let row = null;

  /**
   * Klik na dugmad u tabeli: brisanje ili uređivanje
   */
  citaciTable?.addEventListener("click", async (e) => {
    row = e.target.closest("tbody tr");
    if (!row) return;

    const id = row.dataset.id;
    if (!id) return;

    // Ako je kliknuto na dugme za brisanje čitača
    if (e.target.id === "citaci-delete-btn") {
      try {
        // Prikaz modala za potvrdu brisanja
        CitaciUI.showConfirmDeleteModal(id, "#" + id);
      } catch (error) {
        showAlert("Greška prilikom brisanja čitača: " + error, "danger");
        console.error("Error deleting citac:", error);
      }
    }

    // Ako je kliknuto na dugme za izmenu čitača
    if (e.target.id === "citaci-edit-btn") {
      try {
        // Uzimanje podataka čitača sa servera
        const data = await CitaciManager.getById(id);
        // Otvaranje modala sa podacima za izmenu
        CitaciUI.showEditModal(data);
      } catch (error) {
        showAlert(
          "Greška prilikom otvaranja modala za izmenu čitača: " + error,
          "danger"
        );
        console.error("Error opening edit modal:", error);
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
        showAlert("Čitač uspešno obrisan", "success");
        row.remove();
        CitaciUI.hideConfirmDeleteModal();
      } else {
        showAlert("Greška: " + response.error, "danger");
      }
    } catch (error) {
      showAlert("Greška prilikom brisanja čitača", "danger");
      console.error("Error deleting citac:", error);
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
      if (response.success) {
        showAlert("Čitač uspešno ažuriran", "success");
        // Ažuriranje prikaza u tabeli
        CitaciUI.updateRowValue(row, response.data);
        CitaciUI.closeEditModal();
      } else {
        showAlert("Greška: " + response.error, "danger");
      }
    } catch (error) {
      showAlert("Greška prilikom ažuriranja čitača: " + error, "danger");
      console.error("Error updating citac:", error);
    }
  });

  /**
   * Dodavanje novog čitača
   */
  citaciAddForm?.addEventListener("click", async (e) => {
    if (e.target.id !== "citacAddBtn") return;

    // Sakupljanje podataka iz forme
    const data = CitaciUI.collectFormData();

    try {
      // Slanje zahteva za dodavanje novog čitača
      const response = await CitaciManager.add(data);
      if (response.success) {
        showAlert("Čitač uspešno dodat", "success");
        CitaciUI.formReset();
      } else {
        showAlert("Greška: " + response.error, "danger");
      }
    } catch (error) {
      showAlert("Greška prilikom dodavanja čitača: " + error, "danger");
      console.error("Error adding citac:", error);
    }
  });
}
