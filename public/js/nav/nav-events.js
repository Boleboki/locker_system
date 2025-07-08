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

  navbar?.addEventListener("click", (e) => {
    if (e.target.classList.contains("lang-select")) {
      const lang = e.target.dataset.lang;

      document.cookie = `lang=${lang}; path=/; max-age=${60 * 60 * 24 * 30}`;

      location.reload();
    }
  });
}
