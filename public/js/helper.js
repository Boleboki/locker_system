/**
 * Ova skripta sadrži pomoćne (helper) funkcije za rad sa DOM elementima i prikaz notifikacija.
 *
 * Funkcionalnosti:
 * - onClickIfExists: proverava da li element sa datim ID postoji i dodaje mu klik event listener
 * - showAlert: prikazuje Bootstrap alert poruku na stranici i automatski je uklanja nakon 3 sekunde
 * @author
 * @version 1.0.1
 */

// Proverava da li element sa prosleđenim ID postoji u DOM-u.
// Ako postoji, dodaje mu event listener za klik koji izvršava prosleđenu callback funkciju.
// Time se izbegavaju greške ako element nije učitan ili ne postoji.
export const onClickIfExists = (elementId, callback) => {
  const element = document.getElementById(elementId);
  if (element) {
    element.addEventListener("click", callback);
  }
};

// Prikazuje alert poruku na stranici koristeći Bootstrap stilizovani alert.
// message - tekst poruke koja će biti prikazana
// type - tip poruke (default je "success", može biti "danger", "warning", itd.)
// Poruka se prikazuje u elementu sa ID "alertBox", a zatim automatski nestaje posle 3 sekunde.
export const showAlert = (message, type = "success", time = null) => {
  const alertBox = document.getElementById("alertBox");
  alertBox.innerHTML = `
    <div class="alert alert-${type} alert-dismissible fade show" role="alert">
      ${message}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  `;

  if (!time || time <= 0) return;

  setTimeout(() => {
    const alert = alertBox.querySelector(".alert");
    if (alert) {
      alert.classList.remove("show");
      alert.remove();
    }
  }, time * 1000);
};

export const url = (path) => {
  // Vraća URL koji se koristi za API pozive, kombinujući osnovni URL sa prosleđenim putem
  return `${BASE_URL}${path}`;
};
