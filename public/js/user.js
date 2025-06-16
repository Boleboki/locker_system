/**
 * Skripta služi za upravljanje korisnicima na web aplikaciji.
 * 
 * Omogućava:
 * - Dodavanje novog korisnika (username, password, da li je admin)
 * - Izmenu postojećeg korisnika po ID-u
 * - Brisanje korisnika preko modala
 * 
 * Komunikacija sa serverom se odvija putem REST API poziva (fetch),
 * a korisnički interfejs se osvežava i kontroliše kroz event listenere i modale.
 */

import { onClickIfExists, showAlert } from "./helper.js";

// Klasa koja enkapsulira metode za upravljanje korisnicima preko API-ja
class UserManager {
  /**
   * Dodaje novog korisnika slanjem POST zahteva
   * @param {string} username - korisničko ime
   * @param {string} password - lozinka
   * @param {boolean} isAdmin - da li je korisnik admin
   * @returns {Promise<object>} odgovor sa servera u JSON formatu
   */
  static async add(username, password, isAdmin) {
    const response = await fetch("/users", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ username, password, isAdmin }),
    });
    return await response.json();
  }

  /**
   * Izmenjuje korisnika sa zadatim ID-em slanjem PUT zahteva
   * @param {string} userId - ID korisnika
   * @param {string} username - novo korisničko ime
   * @param {string} password - nova lozinka
   * @param {boolean} isAdmin - nova admin privilegija
   * @returns {Promise<object>} odgovor sa servera u JSON formatu
   */
  static async edit(userId, username, password, isAdmin) {
    const response = await fetch(`/users/${userId}`, { // dodata ispravna sintaksa za template literal
      method: "PUT",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ username, password, isAdmin }),
    });
    return await response.json();
  }

  /**
   * Briše korisnika sa zadatim ID-em slanjem DELETE zahteva
   * @param {string} userId - ID korisnika
   * @returns {Promise<object>} odgovor sa servera u JSON formatu
   */
  static async delete(userId) {
    const response = await fetch(`/users/${userId}`, { // dodata ispravna sintaksa za template literal
      method: "DELETE",
      headers: { "Content-Type": "application/json" },
    });
    return await response.json();
  }
}


// Dodavanje korisnika kada se klikne na dugme sa id="addUserBtn"
onClickIfExists("addUserBtn", async () => {
  // Preuzimanje vrednosti iz input polja
  const username = document.getElementById("username").value;
  const password = document.getElementById("password").value;
  const isAdmin = document.getElementById("admin").value;

  try {
    // Pozivanje metode za dodavanje korisnika i prikaz poruke o uspehu/neuspehu
    const data = await UserManager.add(username, password, isAdmin);
    showAlert(data.message || data.error, data.success ? "success" : "danger");
  } catch (e) {
    showAlert("Greška u dodavanju korisnika", "danger");
  }
});

// Izmena korisnika nakon klika na dugme sa id="editUserBtn"
onClickIfExists("editUserBtn", async () => {
  // Preuzimanje ID korisnika iz atributa dugmeta
  const userId = document.getElementById("editUserBtn").getAttribute("data-id");
  const username = document.getElementById("username").value;
  const password = document.getElementById("password").value;
  const isAdmin = document.getElementById("admin").value;

  try {
    // Pozivanje metode za izmenu korisnika i prikaz povratne poruke
    const data = await UserManager.edit(userId, username, password, isAdmin);
    showAlert(data.message || data.error, data.success ? "success" : "danger");
  } catch (e) {
    showAlert("Greška u izmeni korisnika", "danger");
  }
});


// Rukovanje brisanjem korisnika preko modala

let selectedUserId = null;  // čuva trenutno selektovani korisnički ID za brisanje
let selectedListItem = null; // čuva referencu na HTML red u tabeli koji će biti obrisan

// Dodavanje event listenera na sva dugmeta za brisanje korisnika (sa klasom "delete-btn")
document.querySelectorAll(".delete-btn").forEach(button => {
  button.addEventListener("click", e => {
    // Čuvamo podatke o korisniku koji se briše (ID i HTML element reda)
    selectedUserId = e.currentTarget.dataset.id;
    selectedListItem = e.currentTarget.closest("tr");
    // Postavljamo tekst u modal koji prikazuje ime korisnika za brisanje
    document.getElementById("modalUser").textContent = e.currentTarget.dataset.username;
    // Prikaz modala za potvrdu brisanja
    new bootstrap.Modal(document.getElementById("deleteUserModal")).show();
  });
});

// Potvrda brisanja korisnika iz modala
onClickIfExists("confirmDeleteBtn", async () => {
  if (!selectedUserId) return;

  try {
    // Poziv metode za brisanje korisnika i rukovanje rezultatom
    const data = await UserManager.delete(selectedUserId);
    if (data.success) {
      // Prikaz obaveštenja o uspešnom brisanju, uklanjanje reda iz DOM-a i zatvaranje modala
      showAlert(data.message, "danger");
      selectedListItem.remove();
      bootstrap.Modal.getInstance(document.getElementById("deleteUserModal")).hide();
    } else {
      // Prikaz poruke o grešci ako brisanje nije uspelo
      showAlert(data.error, "danger");
    }
  } catch (e) {
    showAlert("Greška prilikom brisanja", "danger");
  }
});
