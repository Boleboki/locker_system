/**
 * Klasa `UserUI` je zadužena za upravljanje korisničkim interfejsom
 * vezanim za rad sa korisnicima, kao što su prikaz modala za brisanje,
 * prikupljanje podataka iz formi i prikaz grešaka.
 * Sve metode su statičke i pozivaju se direktno bez instanciranja klase.
 *
 * @author
 * @version 1.0.1
 */

export class UserUI {
  /**
   * Prikazuje modal za potvrdu brisanja korisnika.
   *
   * @param {number} userId - ID korisnika koji se briše
   * @param {string} username - Korisničko ime koje se prikazuje u modalu
   */
  static showConfirmDeleteModal(userId, username = "") {
    const modal = document.getElementById("deleteUserModal");
    if (!modal) return;

    // Postavlja korisničko ime u modal da korisnik vidi koga briše
    document.getElementById("modalUser").textContent = username;

    // Inicijalizuje i prikazuje Bootstrap modal
    const deleteModal = new bootstrap.Modal(modal);
    deleteModal.show();
  }

  /**
   * Zatvara modal za potvrdu brisanja korisnika.
   */
  static hideConfirmDeleteModal() {
    const modal = document.getElementById("deleteUserModal");
    if (modal) {
      // Dohvata postojeću instancu modala i zatvara je
      const deleteModal = bootstrap.Modal.getInstance(modal);
      if (deleteModal) {
        deleteModal.hide();
      }
    }
  }

  /**
   * Prikuplja podatke iz forme za kreiranje ili izmenu korisnika.
   *
   * @returns {Object} - objekat sa prikupljenim podacima (username, password, admin, aktivan)
   */
  static collectData() {
    return {
      username: document.getElementById("username")?.value || "",
      password: document.getElementById("password")?.value || "",
      admin: document.getElementById("admin")?.value || "",
      aktivan: document.getElementById("aktivan")?.checked || false,
    };
  }

  /**
   * Prikazuje greške ispod forme u vidu liste.
   *
   * @param {string[]} messages - niz tekstualnih poruka koje se prikazuju kao greške
   */
  static displayError(messages) {
    const errorField = document.querySelector(".error-message");
    const ul = errorField.querySelector("ul");
    ul.innerHTML = ""; // Čisti prethodne greške
    errorField.style.display = "block"; // Prikazuje polje za greške

    // Dodaje svaku poruku kao listu u ul element
    messages.forEach((msg) => {
      const li = document.createElement("li");
      li.textContent = msg;
      ul.appendChild(li);
    });
  }
}
