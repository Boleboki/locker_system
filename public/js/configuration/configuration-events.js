import { ConfigurationUI } from "./ConfigurationUI.js";
import { ConfigurationManager } from "./ConfigurationManager.js";
import { showAlert } from "../helper.js";

/**
 * Funkcija koja inicijalizuje sve potrebne događaje (event listenere)
 * vezane za UI konfiguracije - otvaranje modala, izmena vrednosti, zatvaranje modala...
 *
 * Ne prima parametre i ne vraća vrednost.
 * @author
 * @version 1.0.1
 */
export function initializeConfigurationEvents() {
  // Dohvatanje kontejnera tabele i modala iz DOM-a
  const configurationTable = document.querySelector("#configTableContainer");
  const editModal = document.getElementById("editModal");
  const valueInput = document.getElementById("value");
  const unsavedWarning = document.getElementById("unsavedWarning");
  const paginationContainer = document.querySelector("#paginationContainer");
  const searchInput = document.querySelector("#searchInput");

  let selectedRow = null; // Čuva trenutno selektovani red u tabeli za izmene

  // Ako ne postoje neophodni elementi, prekida se izvršavanje
  if (!configurationTable || !editModal) return;

  // Promenljive koje će čuvati trenutno izabrani ključ, vrednost i opis konfiguracije
  let kljuc = null,
    value = null,
    opis = null;

  // 📌 Dvoklik na red u tabeli
  configurationTable.addEventListener("dblclick", (e) => {
    // Nalazi najbliži <tr> u tbody (red tabele) na koji je kliknuto
    const tr = e.target.closest("tbody tr");
    if (!tr) return; // Ako nije kliknuto na red, izlazi
    ConfigurationUI.removeErrors();

    selectedRow = tr; // Pamti red koji je selektovan

    // Čita tekst iz ćelija (prvi: ključ, drugi: vrednost, treći: opis)
    kljuc = tr.cells[0].textContent.trim();
    value = tr.cells[1].textContent.trim();
    opis = tr.cells[2].textContent.trim();

    // Otvara modal za uređivanje sa učitanim podacima
    ConfigurationUI.openModal(kljuc, value, opis);
  });

  const loadAndRenderConfig = async () => {
    try {
      const configData = await ConfigurationManager.getAll();
      ConfigurationUI.setTableData(configData);
      ConfigurationUI.setPageSize(
        Number(document.querySelector("#poStranici")?.value) || 5
      );
      ConfigurationUI.renderTable(configData);
    } catch (err) {
      console.error("Error loading configurations: ", err);
      showAlert("Error loading configurations", "danger", null);
    }
  };
  loadAndRenderConfig();
  const saveChanges = async () => {
    try {
      const newValue = valueInput.textContent.trim();

      // Poziva funkciju za ažuriranje na serveru
      const data = await ConfigurationManager.update(kljuc, newValue);

      ConfigurationUI.removeErrors();
      // Ako server vrati grešku, prikazuje alert i prekida dalje izvršavanje
      if (!data.success) {
        if (data.error) {
          showAlert(data.error, "danger");
          ConfigurationUI.closeModal();
          return;
        }
        for (const [field, errors] of Object.entries(data.errors)) {
          const errorsField = document
            .getElementById(field)
            ?.closest("div")
            ?.querySelector(".error-message");

          ConfigurationUI.displayError(errorsField, errors);
        }
        return;
      }

      // Ako je update uspešan, ažurira vrednost u tabeli u prikazu korisniku
      ConfigurationUI.updateRowValue(selectedRow, newValue);

      // Zatvara modal i prikazuje poruku o uspehu
      ConfigurationUI.closeModal();
      showAlert(data.message, "success");
    } catch (err) {
      // Ako dođe do greške prilikom poziva ili mreže, prikazuje alert i loguje grešku
      ConfigurationUI.closeModal();
      showAlert("Error editing configuration", "danger", null);
      console.error("Error editing configuration: ", err);
    }
  };
  // 📌 Klik unutar modala (npr. dugmad za zatvaranje ili za potvrdu izmene)
  editModal.addEventListener("click", async (e) => {
    const target = e.target;

    // Ako je kliknuto na dugme za zatvaranje modala
    if (target.classList.contains("close-btn")) {
      if (value === valueInput.textContent.trim()) {
        ConfigurationUI.closeModal();
        return;
      }
      ConfigurationUI.showConfirm();
    }

    // Ako je kliknuto na dugme za izmenu konfiguracije
    if (target.id === "editBtn") {
      saveChanges();
      // Uzima novu vrednost iz modalnog prikaza
    }
  });
  unsavedWarning?.addEventListener("click", (e) => {
    if (e.target.id === "saveBtn") {
      saveChanges();
    } else if (e.target.id === "discardBtn") {
      ConfigurationUI.closeModal();
    }
  });

  paginationContainer?.addEventListener("click", (e) => {
    if (e.target.id === "poStranici") {
      ConfigurationUI.setPageSize(Number(e.target.value) || 5);
      ConfigurationUI.renderTable();
    }

    if (e.target.dataset.page) {
      const page = Number(e.target.dataset.page) || 1;
      ConfigurationUI.setCurrentPage(page);
      ConfigurationUI.renderTable();
    }
  });
  let searchTimeout;
  searchInput?.addEventListener("input", (e) => {
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
      ConfigurationUI.setSearchValue(e.target.value);
      ConfigurationUI.renderTable();
    }, 300);
  });
}
