/**
 * Klasa ConfigurationUI upravlja prikazom i interakcijom modala za konfiguraciju
 * i omogućava ažuriranje i brisanje redova u UI tabeli konfiguracionih podataka.
 * @author
 * @version 1.0.1
 */
export class ConfigurationUI {
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
    document.getElementById("modalValue").textContent = value;
    document.getElementById("modalDescription").textContent = opis;

    // Prikaz modala (pravljenje vidljivim)
    document.getElementById("editModal").style.display = "block";
  }

  /**
   * Zatvara modalni prozor za uređivanje konfiguracije.
   * Ne prima parametre.
   */
  static closeModal() {
    // Sakrivanje modala (uklanjanje sa ekrana)
    document.getElementById("editModal").style.display = "none";
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
}
