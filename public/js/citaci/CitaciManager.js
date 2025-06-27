/**
 * Klasa `CitaciManager` omogućava komunikaciju sa serverom (REST API)
 * za entitet "citaci" pomoću HTTP zahteva.
 *
 * Obezbeđuje metode za:
 * - Dohvatanje jednog čitača po ID-u
 * - Dohvatanje svih čitača
 * - Dodavanje novog čitača
 * - Ažuriranje postojećeg čitača
 * - Brisanje čitača
 *
 * @author
 * @version 1.0.1
 */

import { url } from "../helper.js";

export class CitaciManager {
  /**
   * Dohvata podatke o čitaču sa servera na osnovu ID-a.
   *
   * @param {number} id - ID čitača koji se traži
   * @returns {Promise<Object>} - JSON objekat sa podacima o čitaču
   */
  static async getById(id) {
    try {
      // Slanje GET zahteva za pojedinačnog čitača
      const response = await fetch(url(`/citaci/${id}`));
      if (!response.ok) {
        const errorText = await response.text(); // Uzimanje tekstualne greške sa servera
        console.error("Server error text:", errorText);
        throw new Error("Server error text: " + errorText);
      }
      return await response.json(); // Parsiranje i vraćanje JSON odgovora
    } catch (error) {
      console.error("Error fetching data by ID:", error);
      throw error;
    }
  }

  /**
   * Dohvata sve čitače sa servera.
   *
   * @returns {Promise<Object[]>} - Niz čitača u JSON formatu
   */
  static async getAll() {
    try {
      // Slanje GET zahteva za sve čitače
      const response = await fetch(url(`/api/citaci`));
      if (!response.ok) {
        const errorText = await response.text(); // Greška ako status nije OK
        console.error("Server error text:", errorText);
        throw new Error("Server error text: " + errorText);
      }
      return await response.json(); // Vraćanje niza čitača
    } catch (error) {
      console.error("Error fetching data by ID:", error); // Napomena: poruka može biti zbunjujuća jer se odnosi na sve
      throw error;
    }
  }

  /**
   * Šalje podatke za kreiranje novog čitača na server.
   *
   * @param {Object} data - Podaci o čitaču koji se kreira
   * @returns {Promise<Object>} - JSON odgovor servera sa kreiranim podacima
   */
  static async add(data) {
    try {
      // Slanje POST zahteva za dodavanje čitača
      const response = await fetch(url("/citaci"), {
        method: "POST",
        headers: {
          "Content-Type": "application/json", // Obavezno naglasiti tip sadržaja
        },
        body: JSON.stringify(data), // Slanje podataka kao JSON string
      });
      if (!response.ok) {
        const errorText = await response.text(); // Čitanje teksta greške
        console.error("Server error text:", errorText);
        throw new Error("Server error text: " + errorText);
      }

      return await response.json(); // Vraćanje kreiranog objekta sa servera
    } catch (error) {
      console.error("Error adding data:", error);
      throw error;
    }
  }

  /**
   * Ažurira podatke o postojećem čitaču na serveru.
   *
   * @param {number} id - ID čitača koji se ažurira
   * @param {Object} data - Novi podaci za čitača
   * @returns {Promise<Object>} - JSON odgovor servera sa ažuriranim podacima
   */
  static async update(id, data) {
    try {
      // Slanje PUT zahteva za ažuriranje podataka čitača
      const response = await fetch(url(`/citaci/${id}`), {
        method: "PUT",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
      });
      if (!response.ok) {
        const errorText = await response.text(); // Greška ako je status neodgovarajući
        console.error("Server error text:", errorText);
        throw new Error("Server error text: " + errorText);
      }

      return await response.json(); // Vraćanje ažuriranih podataka
    } catch (error) {
      console.error("Error updating data:", error);
      throw error;
    }
  }

  /**
   * Briše čitača sa servera na osnovu ID-a.
   *
   * @param {number} id - ID čitača koji se briše
   * @returns {Promise<Object>} - JSON odgovor servera o statusu brisanja
   */
  static async delete(id) {
    try {
      // Slanje DELETE zahteva za brisanje čitača
      const response = await fetch(url(`/citaci/${id}`), {
        method: "DELETE",
        headers: {
          "Content-Type": "application/json",
        },
      });
      if (!response.ok) {
        const errorText = await response.text(); // Ako nešto pođe po zlu
        console.error("Server error text:", errorText);
        throw new Error("Server error text: " + errorText);
      }

      return await response.json(); // Povratna informacija o brisanju
    } catch (error) {
      console.error("Error deleting data:", error);
      throw error;
    }
  }
}
