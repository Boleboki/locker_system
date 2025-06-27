/**
 * Ovaj fajl sadrži klasu `AuthManager` koja upravlja autentifikacijom korisnika.
 * Omogućava login (POST) i logout (DELETE) komunikaciju sa serverom.
 * Oslanja se na `url` helper funkciju za formiranje URL putanja ka API-ju.
 *
 * @author
 * @version 1.0.1
 */

import { url } from "../helper.js";

export class AuthManager {
  /**
   * Funkcija za prijavu korisnika.
   * Šalje POST zahtev sa korisničkim imenom i lozinkom na server.
   *
   * @param {string} username - korisničko ime koje korisnik unosi
   * @param {string} password - lozinka koju korisnik unosi
   * @returns {Promise<object>} - odgovor servera u JSON formatu
   *
   * U slučaju greške baca izuzetak koji može biti uhvaćen u UI sloju.
   */
  static async login(username, password) {
    try {
      // Slanje POST zahteva na /login endpoint sa JSON telom
      const response = await fetch(url("/login"), {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ username, password }),
      });

      // Ako odgovor nije uspešan (status kod nije 2xx)
      if (!response.ok) {
        const errorText = await response.text(); // čitanje teksta greške sa servera
        console.error("Server error text:", errorText);
        throw new Error("Server error text: " + errorText);
      }

      // Parsiranje JSON odgovora sa servera
      return await response.json();
    } catch (err) {
      // Logovanje greške i propagacija dalje
      console.error("Greška prilikom logovanja: ", err);
      throw err;
    }
  }

  /**
   * Funkcija za odjavu korisnika.
   * Šalje DELETE zahtev na server radi uništavanja sesije/tokena.
   *
   * @returns {Promise<object>} - JSON odgovor servera (npr. success i redirect)
   *
   * U slučaju greške baca izuzetak koji treba da bude obrađen u UI sloju.
   */
  static async logout() {
    try {
      // Slanje DELETE zahteva na /logout endpoint
      const response = await fetch(url("/logout"), {
        method: "DELETE",
      });

      // Ako je odgovor neuspešan, baci grešku sa porukom sa servera
      if (!response.ok) {
        const errorText = await response.text();
        console.error("Server error text:", errorText);
        throw new Error("Server error text: " + errorText);
      }

      // Vraćanje parsiranog JSON odgovora
      return await response.json();
    } catch (err) {
      // Logovanje greške prilikom logout-a
      console.log("Greška prilikom logout-a: ", err);
      throw err;
    }
  }
}
