import { initializeConfigurationEvents } from "./configuration/configuration-events.js";
import { initializeCitaciEvents } from "./citaci/citaci-events.js";
import { initializeAuthEvents } from "./auth/auth-events.js";
import { initializeUserEvents } from "./user/user-events.js";
import { initializeNavbarEvents } from "./nav/nav-events.js";
window.addEventListener("DOMContentLoaded", function () {
  initializeConfigurationEvents();
  initializeCitaciEvents();
  initializeAuthEvents();
  initializeUserEvents();
  initializeNavbarEvents();
});
