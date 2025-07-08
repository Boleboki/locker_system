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
   * Prikuplja nove lozinke iz forme za reset lozinke.
   *
   * @returns {Object} - objekat sa novom lozinkom i potvrdom lozinke
   */
  static collectPasswordReset() {
    return {
      new_password: document.getElementById("new_password")?.value || "",
      confirm_password:
        document.getElementById("confirm_password")?.value || "",
    };
  }
  /**
   * Zatvara modal za reset lozinke korisnika.
   */
  static closeResetPasswordModal() {
    const modalElement = document.getElementById("resetPasswordModal");

    // Inicijalizuj modal iz DOM elementa koristeći Bootstrap API
    const modalInstance = bootstrap.Modal.getInstance(modalElement);

    if (modalInstance) {
      modalInstance.hide(); // Zatvara modal
    }
  }
  /**
   * Briše unete vrednosti u formi za promenu lozinke.
   */
  static clearPasswordEditForm() {
    document.getElementById("new_password").value = "";
    document.getElementById("confirm_password").value = "";
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
   * Uklanja prikazane greške iz svih error-message elemenata.
   */
  static removeErrors() {
    document.querySelectorAll(".error-message ul").forEach((ul) => {
      ul.innerHTML = "";
    });
  }
  /**
   * Prikazuje greške ispod određenog polja u formi.
   *
   * @param {HTMLElement} errorField - element u koji se greške prikazuju
   * @param {string[]} messages - lista poruka grešaka
   */
  static displayError(errorField, messages) {
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
