import { initializeConfigurationEvents } from "./configuration/configuration-events.js";
import { initializeCitaciEvents } from "./citaci/citaci-events.js";
window.addEventListener("DOMContentLoaded", function () {
  initializeConfigurationEvents();
  initializeCitaciEvents();
});
