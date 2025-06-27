import { url } from "../helper.js";
/**
 * Klasa `UserManager` omogućava upravljanje korisnicima kroz REST API
 * pomoću HTTP zahteva (POST, PUT, DELETE) za dodavanje, izmenu i brisanje korisnika.
 * Sve metode su statičke i asinkrone, vraćaju Promise sa odgovorom servera.
 *
 * @author
 * @version 1.0.1
 */
export class UserManager {
  /**
   * Dodaje novog korisnika slanjem POST zahteva na server.
   *
   * @param {object} data - objekat sa podacima korisnika (username, password, admin, aktivan)
   * @returns {Promise<object>} - odgovor servera u JSON formatu
   */
  static async add(data) {
    try {
      // Slanje POST zahteva sa JSON telom koje sadrži podatke korisnika
      const response = await fetch(url("/users"), {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data),
      });
      // Provera da li je odgovor sa servera uspešan
      if (!response.ok) {
        const errorText = await response.text(); // Dohvatanje teksta greške
        console.error("Server error text:", errorText);
        throw new Error("Server error text: " + errorText);
      }
      // Parsiranje i vraćanje JSON odgovora
      return await response.json();
    } catch (err) {
      console.error("Greška prilikom dodavanja korisnika:", err);
      throw err; // Prosleđivanje greške višem sloju
    }
  }

  /**
   * Izmenjuje korisnika sa zadatim ID-em slanjem PUT zahteva na server.
   *
   * @param {string} userId - ID korisnika koji se menja
   * @param {object} data - objekat sa novim podacima korisnika (npr. username, password itd.)
   * @returns {Promise<object>} - odgovor servera u JSON formatu
   */
  static async edit(userId, data) {
    try {
      // Slanje PUT zahteva sa JSON telom koje sadrži nove podatke korisnika
      const response = await fetch(url(`/users/${userId}`), {
        method: "PUT",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data),
      });
      // Provera uspešnosti odgovora
      if (!response.ok) {
        const errorText = await response.text(); // Dohvatanje poruke greške sa servera
        console.error("Server error text:", errorText);
        throw new Error("Server error text: " + errorText);
      }
      // Parsiranje i vraćanje JSON odgovora
      return await response.json();
    } catch (err) {
      console.error("Greška prilikom izmene korisnika:", err);
      throw err; // Prosleđivanje greške višem sloju
    }
  }

  /**
   * Briše korisnika sa zadatim ID-em slanjem DELETE zahteva na server.
   *
   * @param {int} userId - ID korisnika koji se briše
   * @returns {Promise<object>} - odgovor servera u JSON formatu o statusu brisanja
   */
  static async delete(userId) {
    try {
      // Slanje DELETE zahteva za brisanje korisnika
      const response = await fetch(url(`/users/${userId}`), {
        method: "DELETE",
        headers: { "Content-Type": "application/json" },
      });
      // Provera da li je brisanje bilo uspešno
      if (!response.ok) {
        const errorText = await response.text(); // Dohvatanje greške sa servera
        console.error("Server error text:", errorText);
        throw new Error("Server error text: " + errorText);
      }
      // Parsiranje i vraćanje odgovora
      return await response.json();
    } catch (err) {
      console.error("Greška prilikom brisanja korisnika:", err);
      throw err; // Prosleđivanje greške višem sloju
    }
  }
}
