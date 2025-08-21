/**
 * Ovaj fajl sadrži klasu `AuthUI` koja je zadužena za korisnički interfejs
 * prilikom autentifikacije. Konkretno, prikazuje poruke o greškama
 * kada login ne uspe.
 *
 * @author
 * @version 1.0.1
 */

export class AuthUI {
  /**
   * Prikazuje poruke o greškama na UI-u.
   * Pronalazi HTML element koji sadrži listu grešaka i popunjava je.
   *
   * @param {string[]} messages - niz poruka koje treba prikazati korisniku
   * @returns {void}
   */
  static removeErrors() {
    document.querySelectorAll(".error-message ul").forEach((ul) => {
      ul.innerHTML = "";
    });
  }
  static displayError(errorField, messages) {
    // Pronalazi kontejner za greške (pretpostavlja se da već postoji u DOM-u)
    const ul = errorField.querySelector("ul");

    // Čisti prethodne poruke iz liste
    ul.innerHTML = "";

    errorField.classList.add("visible");
    errorField.style.display = "block"; // Osigurava da je element vidljiv
    // Za svaku poruku kreira <li> element i dodaje ga u <ul>
    messages.forEach((msg) => {
      const li = document.createElement("li");
      li.textContent = msg;
      ul.appendChild(li);
    });
  }
}
