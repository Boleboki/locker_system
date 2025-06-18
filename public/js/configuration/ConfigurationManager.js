export class ConfigurationManager {
  static async update(key, value) {
    try {
      const response = await fetch(`/konfiguracija/${key}`, {
        method: "PUT",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ value: value }),
      });
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return await response.json();
    } catch (error) {
      console.error("Error updating configuration:", error);
      throw error;
    }
  }
  static async delete(key) {
    try {
      const response = await fetch(`/konfiguracija/${key}`, {
        method: "DELETE",
      });
      if (!response.ok) {
        throw new Error("Network response was not ok");
      }
      return await response.json();
    } catch (error) {
      console.error("Error deleting configuration:", error);
      throw error;
    }
  }
}
