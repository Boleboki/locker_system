import { showAlert } from "../helper.js";
import { UserManager } from "./UserManager.js";
import { UserUI } from "./UserUI.js";

/**
 * Inicijalizuje sve događaje vezane za upravljanje korisnicima:
 * - brisanje korisnika
 * - izmena korisnika
 * - dodavanje novog korisnika
 *
 * @author
 * @version 1.0.1
 */
export function initializeUserEvents() {
  const usersTable = document.querySelector("#usersTable");
  const deleteUserModal = document.querySelector("#deleteUserModal");
  const editUserForm = document.querySelector("#editUserForm");
  const userCreateForm = document.querySelector("#userCreateForm");
  const resetPasswordModal = document.querySelector("#resetPasswordModal");
  let row = null;

  // Klik na dugmad unutar tabele korisnika (npr. dugme za brisanje)
  usersTable?.addEventListener("click", async (e) => {
    row = e.target.closest("tbody tr"); // pronalazi red u tabeli
    if (!row) return;
    const userId = row.dataset.id,
      userUsername = row.dataset.username;

    // Ako je kliknuto na dugme za brisanje korisnika
    if (e.target.closest("#delete-btn")) {
      if (!userId || !userUsername) return;

      // Prikazuje modal za potvrdu brisanja korisnika
      UserUI.showConfirmDeleteModal(userId, userUsername);
    }
  });

  // Klik na dugme za potvrdu brisanja u modalu
  deleteUserModal?.addEventListener("click", async (e) => {
    if (e.target.id !== "confirmDeleteBtn") return;

    try {
      const userId = row.dataset.id;
      if (!userId) return;

      // Poziva UserManager za brisanje korisnika po ID-u
      const response = await UserManager.delete(row.dataset.id);

      if (response.success) {
        // Prikaz poruke o uspešnom brisanju
        showAlert(response.message, "danger");
        // Uklanja red korisnika iz tabele
        row.remove();
        // Zatvara modal za potvrdu brisanja
        UserUI.hideConfirmDeleteModal();
      } else {
        // Prikaz greške ako brisanje nije uspelo
        showAlert(response.error, "danger");
      }
    } catch (err) {
      showAlert("Error deleting user: " + err, "danger");
      console.error("Error deleting user: ", e);
    }
  });

  // Klik na dugme za izmenu korisnika u formi
  editUserForm?.addEventListener("click", async (e) => {
    if (e.target.id !== "editUserBtn") return;

    try {
      const userId = e.target.dataset.id;
      // Prikuplja podatke iz forme
      const data = UserUI.collectData();
      delete data.password;
      // Šalje zahtev za izmenu korisnika
      const response = await UserManager.edit(userId, data);

      UserUI.removeErrors();

      if (!response.success) {
        if (response.error) {
          showAlert(response.error, "danger");
          return;
        }
        for (const [field, messages] of Object.entries(response.errors)) {
          const errorField = document
            .getElementById(field)
            ?.closest("div")
            ?.querySelector(".error-message");
          UserUI.displayError(errorField, messages);
        }
        return;
      }
      // Prikaz uspešne poruke
      showAlert(response.message, "success");
    } catch (e) {
      showAlert("Error editing user: " + e, "danger");
      console.log("Error editing user: ", e);
    }
  });

  // Klik na dugme za dodavanje novog korisnika u formi
  userCreateForm?.addEventListener("click", async (e) => {
    if (e.target.id === "addUserBtn") {
      try {
        // Prikupljanje podataka iz forme za kreiranje korisnika
        const data = UserUI.collectData();
        // Slanje zahteva za dodavanje korisnika
        const response = await UserManager.add(data);
        UserUI.removeErrors();
        if (!response.success) {
          if (response.error) {
            showAlert(response.error, "danger");
            return;
          }
          for (const [field, messages] of Object.entries(response.errors)) {
            const errorField = document
              .getElementById(field)
              ?.closest("div")
              ?.querySelector(".error-message");

            UserUI.displayError(errorField, messages);
          }
          return;
        }
        showAlert(response.message, "success");
      } catch (e) {
        showAlert("Error adding user: " + e, "danger");
        console.error("Error adding user: ", e);
      }
    }
  });

  resetPasswordModal?.addEventListener("click", async (e) => {
    if (e.target.id !== "confirmResetBtn" || !e.target.dataset.id) return;
    try {
      const data = UserUI.collectPasswordReset();
      const response = await UserManager.updatePassword(
        e.target.dataset.id,
        data
      );
      UserUI.removeErrors();
      if (!response.success) {
        if (response.error) {
          showAlert(response.error, "danger");
          return;
        }
        for (const [field, messages] of Object.entries(response.errors)) {
          const errorField = document
            .getElementById(field)
            ?.closest("div")
            ?.querySelector(".error-message");

          UserUI.displayError(errorField, messages);
        }
        return;
      }
      UserUI.clearPasswordEditForm();
      UserUI.closeResetPasswordModal();
      showAlert(response.message, "success");
    } catch (err) {
      showAlert("Error updating password: " + e, "danger");
      console.error("Error updating password:", err);
    }
  });
}
