import { ConfigurationUI } from "./ConfigurationUI.js";
import { ConfigurationManager } from "./ConfigurationManager.js";
import { showAlert } from "../helper.js";

export function initializeConfigurationEvents() {
  const configurationTable = document.querySelector("#configTableContainer");
  const editModal = document.getElementById("editModal");
  let selectedRow = null;

  if (!configurationTable || !editModal) return;
  let kljuc = null,
    value = null,
    opis = null;
  // 📌 Klik na red tabele
  configurationTable.addEventListener("dblclick", (e) => {
    const tr = e.target.closest("tbody tr");
    if (!tr) return;

    selectedRow = tr;

    kljuc = tr.cells[0].textContent.trim();
    value = tr.cells[1].textContent.trim();
    opis = tr.cells[2].textContent.trim();

    ConfigurationUI.openModal(kljuc, value, opis);
  });

  // 📌 Klik unutar modala
  editModal.addEventListener("click", async (e) => {
    const target = e.target;

    if (target.classList.contains("close-btn")) {
      ConfigurationUI.closeModal();
      return;
    }

    if (target.id === "editBtn") {
      const newValue = document.getElementById("modalValue").textContent.trim();

      try {
        const data = await ConfigurationManager.update(kljuc, newValue);
        if (!data.success) {
          showAlert("Greška pri izmeni: " + data.error, "danger");
          return;
        }
        ConfigurationUI.updateRowValue(selectedRow, newValue);
        ConfigurationUI.closeModal();
        showAlert("Uspešno izmenjeno polje " + kljuc, "success");
      } catch (err) {
        showAlert("Greška pri izmeni", "danger");
        console.error("Greška pri izmeni:", err);
      }
    }

    if (target.id === "delBtn") {
      try {
        const data = await ConfigurationManager.delete(kljuc);
        if (!data.success) {
          showAlert("Greška pri brisanju: " + data.error, "danger");
          return;
        }
        ConfigurationUI.deleteRow(selectedRow);
        ConfigurationUI.closeModal();
        showAlert("Uspešno obrisano polje " + kljuc, "success");
      } catch (err) {
        showAlert("Greška pri brisanju", "danger");
        console.error("Greška pri brisanju:", err);
      }
    }
  });

  // 📌 Klik van sadržaja modala zatvara modal
  window.addEventListener("click", (e) => {
    if (e.target === editModal) {
      ConfigurationUI.closeModal();
    }
  });
}
