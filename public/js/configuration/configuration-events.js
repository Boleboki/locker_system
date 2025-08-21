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

    selectedRow = tr; // Pamti red koji je selektovan

    // Čita tekst iz ćelija (prvi: ključ, drugi: vrednost, treći: opis)
    kljuc = tr.cells[0].textContent.trim();
    value = tr.cells[1].textContent.trim();
    opis = tr.cells[2].textContent.trim();

    // Otvara modal za uređivanje sa učitanim podacima
    ConfigurationUI.openModal(kljuc, value, opis);
  });

  // 📌 Klik unutar modala (npr. dugmad za zatvaranje ili za potvrdu izmene)
  editModal.addEventListener("click", async (e) => {
    const target = e.target;

    // Ako je kliknuto na dugme za zatvaranje modala
    if (target.classList.contains("close-btn")) {
      ConfigurationUI.closeModal();
      return;
    }

    // Ako je kliknuto na dugme za izmenu konfiguracije
    if (target.id === "editBtn") {
      // Uzima novu vrednost iz modalnog prikaza
      const newValue = document.getElementById("modalValue").textContent.trim();

      try {
        // Poziva funkciju za ažuriranje na serveru
        const data = await ConfigurationManager.update(kljuc, newValue);

        // Ako server vrati grešku, prikazuje alert i prekida dalje izvršavanje
        if (!data.success) {
          showAlert(data.error, "danger");
          return;
        }

        // Ako je update uspešan, ažurira vrednost u tabeli u prikazu korisniku
        ConfigurationUI.updateRowValue(selectedRow, newValue);

        // Zatvara modal i prikazuje poruku o uspehu
        ConfigurationUI.closeModal();
        showAlert(data.message, "success");
      } catch (err) {
        // Ako dođe do greške prilikom poziva ili mreže, prikazuje alert i loguje grešku
        showAlert("Error editing configuration", "danger", null);
        console.error("Error editing configuration: ", err);
      }
    }
  });

  // 📌 Klik van sadržaja modala zatvara modal
  window.addEventListener("click", (e) => {
    // Ako je kliknuto van modalnog sadržaja (na overlay)
    if (e.target === editModal) {
      ConfigurationUI.closeModal();
    }
  });
}
