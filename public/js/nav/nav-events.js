/**
 * Inicijalizuje sve događaje vezane za upravljanje navbarom:
 * - Promena jezika klikom na dugme sa klasom `.lang-select`
 * - Postavljanje kolačića sa izabranim jezikom
 * - Osvežavanje stranice nakon promene jezika
 *
 * @author
 * @version 1.0.1
 */
export function initializeNavbarEvents() {
  const navbar = document.querySelector(".navbar");
  const toggleThemeBtn = document.getElementById("toggleThemeBtn");
  const themeIcon = document.getElementById("themeIcon");

  navbar?.addEventListener("click", (e) => {
    if (e.target.classList.contains("lang-select")) {
      const lang = e.target.dataset.lang;

      document.cookie = `lang=${lang}; path=/; max-age=${60 * 60 * 24 * 30}`;

      location.reload();
    }
  });

  // Učitavanje prethodno sačuvane teme
  if (localStorage.getItem("theme") === "dark") {
    document.body.classList.add("dark-theme");
    themeIcon.classList.replace("fa-sun", "fa-moon");
  }

  toggleThemeBtn.addEventListener("click", () => {
    document.body.classList.toggle("dark-theme");

    // Animacija ikone
    themeIcon.classList.add("rotate");
    setTimeout(() => {
      themeIcon.classList.remove("rotate");
    }, 300);

    if (document.body.classList.contains("dark-theme")) {
      themeIcon.classList.replace("fa-sun", "fa-moon");
      localStorage.setItem("theme", "dark");
    } else {
      themeIcon.classList.replace("fa-moon", "fa-sun");
      localStorage.setItem("theme", "light");
    }
  });
}
