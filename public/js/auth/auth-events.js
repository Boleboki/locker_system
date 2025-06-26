// ====================================================================
// OVAJ FAJL:
// Zadužen je za postavljanje događaja (event listener-a) na UI elemente
// za login i logout funkcionalnosti. Komunicira sa AuthManager-om i AuthUI-jem
// radi obrade autentifikacije korisnika i prikaza poruka.
// ====================================================================

import { AuthUI } from "./AuthUI.js";
import { AuthManager } from "./AuthManager.js";
import { showAlert } from "../helper.js";

// ====================================================================
// initializeAuthEvents()
// Postavlja event listenere za login i logout dugmad na stranici.
//
// Parametri: nema
// Povratna vrednost: nema (funkcija samo registruje događaje)
//
// U okviru funkcije se:
// - obrađuje klik na login dugme i šalju kredencijali AuthManager-u,
// - prikazuju greške ako ih ima,
// - izvršava redirekcija nakon uspešnog login/logout procesa.
// ====================================================================
export function initializeAuthEvents() {
  const loginForm = document.querySelector("#loginForm");
  const logoutBtn = document.querySelector("#logoutBtn");

  // Event listener za klik unutar forme za login
  loginForm?.addEventListener("click", async (e) => {
    if (e.target.id === "loginBtn") {
      try {
        const username = document.querySelector("#username").value;
        const password = document.querySelector("#password").value;

        // Poziv AuthManager.login funkcije (pretpostavlja se da je asinhroni API poziv)
        const response = await AuthManager.login(username, password);

        // Provera da li je login neuspešan
        if (!response.success) {
          // Prikaz grešaka (može biti niz grešaka ili jedna greška kao string)
          const messages = Array.isArray(response.error)
            ? response.error
            : [response.error || "Došlo je do greške"];

          AuthUI.displayError(messages); // Prikaz greške na ekranu

          return; // Prekini dalje izvršavanje ako login nije uspeo
        }

        // Ako server vraća redirect URL, idi na tu stranicu
        if (response.redirect) {
          window.location.href = response.redirect;
        }
      } catch (err) {
        // Uhvati sve greške vezane za komunikaciju sa serverom
        console.error("Greška prilikom logina: ", err);
        showAlert("Greška u komunikaciji sa serverom", "danger"); // Prikaz upozorenja
      }
    }
  });

  // Event listener za logout dugme
  logoutBtn?.addEventListener("click", async (e) => {
    try {
      // Poziv logout funkcije (pretpostavlja se da briše sesiju ili token)
      const response = await AuthManager.logout();

      // Ako server vraća redirect (npr. nazad na login stranicu)
      if (response.redirect) window.location.href = response.redirect;
    } catch (err) {
      // Obrada grešaka prilikom logout-a
      console.error("Greška prilikom logout-a: ", err);
      showAlert("Greška u komunikaciji sa serverom", "danger");
    }
  });
}
