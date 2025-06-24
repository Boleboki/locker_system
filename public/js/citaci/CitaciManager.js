/**
 * Klasa CitaciManager omogućava komunikaciju sa serverom (REST API)
 * za entitet "citaci" pomoću HTTP zahteva.
 *
 * Obezbeđuje metode za:
 * - Dohvatanje jednog čitača po ID-u
 * - Dodavanje novog čitača
 * - Ažuriranje postojećeg čitača
 * - Brisanje čitača
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
      const response = await fetch(url(`/citaci/${id}`));
      if (!response.ok) {
        const errorText = await response.text();
        console.error("Server error text:", errorText);
        throw new Error("Server error text: " + errorText);
      }
      return await response.json();
    } catch (error) {
      console.error("Error fetching data by ID:", error);
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
      const response = await fetch(url("/citaci"), {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
      });
      if (!response.ok) {
        const errorText = await response.text();
        console.error("Server error text:", errorText);
        throw new Error("Server error text: " + errorText);
      }

      return await response.json();
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
      const response = await fetch(url(`/citaci/${id}`), {
        method: "PUT",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify(data),
      });
      if (!response.ok) {
        const errorText = await response.text();
        console.error("Server error text:", errorText);
        throw new Error("Server error text: " + errorText);
      }

      return await response.json();
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
      const response = await fetch(url(`/citaci/${id}`), {
        method: "DELETE",
        headers: {
          "Content-Type": "application/json",
        },
      });
      if (!response.ok) {
        const errorText = await response.text();
        console.error("Server error text:", errorText);
        throw new Error("Server error text: " + errorText);
      }

      return await response.json();
    } catch (error) {
      console.error("Error deleting data:", error);
      throw error;
    }
  }
}
