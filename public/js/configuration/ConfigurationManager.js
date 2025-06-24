/**
 * Klasa ConfigurationManager se koristi za komunikaciju sa backend API-jem
 * u vezi sa ažuriranjem i brisanjem konfiguracionih stavki.
 * Metode koriste async/await i fetch API za HTTP zahteve.
 */

import { url } from "../helper.js";
export class ConfigurationManager {
  /**
   * Ažurira vrednost konfiguracione stavke na serveru.
   *
   * @param {string} key - ključ konfiguracione stavke koja se ažurira.
   * @param {string} value - nova vrednost koja treba da se postavi.
   * @returns {Promise<Object>} - vraća JSON odgovor sa servera (uspeh/greška).
   * @throws {Error} - baca grešku ako mrežni zahtev nije uspešan.
   */
  static async update(key, value) {
    try {
      // Slanje PUT zahteva na endpoint sa ključem konfiguracije
      const response = await fetch(url(`/konfiguracija/${key}`), {
        method: "PUT",
        headers: {
          "Content-Type": "application/json", // JSON telo zahteva
        },
        body: JSON.stringify({ value: value }), // telo sa novom vrednošću
      });

      // Provera da li je odgovor uspešan (status 200-299)
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }

      // Parsiranje i vraćanje JSON odgovora
      return await response.json();
    } catch (error) {
      // Logovanje greške u konzolu i ponovno bacanje greške da bi se obradila na višem nivou
      console.error("Error updating configuration:", error);
      throw error;
    }
  }

  /**
   * Briše konfiguracionu stavku sa servera po datom ključu.
   *
   * @param {string} key - ključ konfiguracione stavke koja treba da se obriše.
   * @returns {Promise<Object>} - vraća JSON odgovor sa servera (uspeh/greška).
   * @throws {Error} - baca grešku ako mrežni zahtev nije uspešan.
   */
  static async delete(key) {
    try {
      // Slanje DELETE zahteva na endpoint sa ključem konfiguracije
      const response = await fetch(url(`/konfiguracija/${key}`), {
        method: "DELETE",
      });

      // Provera da li je odgovor uspešan
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }

      // Parsiranje i vraćanje JSON odgovora
      return await response.json();
    } catch (error) {
      // Logovanje greške i ponovno bacanje greške
      console.error("Error deleting configuration:", error);
      throw error;
    }
  }
}
