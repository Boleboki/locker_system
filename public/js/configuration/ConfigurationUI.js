export class ConfigurationUI {
  static openModal(key, value, opis) {
    document.getElementById("modalKey").textContent = key;
    document.getElementById("modalValue").textContent = value;
    document.getElementById("modalDescription").textContent = opis;
    document.getElementById("editModal").style.display = "block";
  }

  static closeModal() {
    document.getElementById("editModal").style.display = "none";
  }

  static updateRowValue(row, value) {
    const valueCell = row.querySelector("td:nth-child(2)");
    if (valueCell) {
      valueCell.textContent = value;
    }
  }
  static deleteRow(row) {
    if (row) {
      row.remove();
    }
  }
}
