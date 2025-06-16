/*
 * Ova skripta pruža osnovnu funkcionalnost za autentifikaciju korisnika
 * preko frontend-a. 
 * 
 * Glavne funkcionalnosti:
 * - Prijavljivanje korisnika slanjem korisničkog imena i lozinke na backend
 * - Odjavljivanje korisnika slanjem zahteva za logout na backend
 * - Upravljanje klik događajima na dugmad za login i logout, sa prikazom
 *   odgovarajućih poruka o greškama ili preusmeravanjem korisnika nakon uspeha
 * 
 * Skripta koristi async/await za asinkrone pozive API-ja i funkcije iz "helper.js" 
 * za pomoćne UI funkcije poput prikaza upozorenja i registracije klikova.
 */

import { showAlert, onClickIfExists } from "./helper.js";

class Auth {
  /**
   * Funkcija za prijavu korisnika slanjem POST zahteva
   * @param {string} username - korisničko ime 
   * @param {string} password - lozinka
   * @returns {Promise<object>} odgovor sa servera u JSON formatu
   */
  
  static async login(username, password) {
    try {
      const response = await fetch("/login", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ username, password }),
      });
      return await response.json();
    } catch (err) {
      showAlert("Greška u komunikaciji sa serverom", "danger");
    }
  }
  /**
   * Funkcija za odjavljivanje korisnika slanjem DELETE zahteva
   * @returns {Promise<object>} odgovor sa servera u JSON formatu
   */
  static async logout() {
    const response = await fetch("/logout", {
      method: "DELETE",
    });
    return await response.json();
  }
}

// Registracija klik handlera za dugme za login
// Učitava vrednosti input polja za korisničko ime i lozinku,
// poziva Auth.login
onClickIfExists("loginBtn", async () => {
  const username = document.getElementById('username').value.trim();
  const password = document.getElementById('password').value;

  try {
    const data = await Auth.login(username, password);

    if (!data.success) {
      showAlert(data.error || "Došlo je do greške", "danger");
      return;
    }

    if (data.redirect) {
      window.location.href = data.redirect;
    }
  } catch (err) {
    console.error("Greška prilikom logina:", err);
    showAlert("Greška u komunikaciji sa serverom", "danger");
  }
});


// Registracija klik handlera za dugme za logout
// Poziva Auth.logout
onClickIfExists("logoutBtn", async () => {
  try {
    const data = await Auth.logout();
    if (data.redirect) window.location.href = data.redirect;
  } catch (err) {
    showAlert("Greška u komunikaciji sa serverom: " + err, "danger");
  }
});
