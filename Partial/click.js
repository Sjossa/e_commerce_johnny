import { loadContentFromUrl } from "./fetch.js"; // Importer la fonction

document.addEventListener("DOMContentLoaded", () => {
  const container = document.querySelector(".container");
  const formsearch = document.getElementById("aaa");
  const searchInput = document.getElementById("searchInput"); // Idem ici

  if (!container) {
    console.error("Erreur : l'élément '.container' est introuvable.");
    return;
  }
  if (!formsearch) {
    console.error("Erreur : l'élément avec l'ID 'aaa' est introuvable.");
    return;
  }
  if (!searchInput) {
    console.error(
      "Erreur : l'élément avec l'ID 'searchInput' est introuvable."
    );
    return;
  }

  const attachLinkEventListeners = () => {
    document.querySelectorAll(".link").forEach((link) => {
      link.removeEventListener("click", handleLinkClick);
      link.addEventListener("click", handleLinkClick);
    });
  };

  // Gestionnaire de clic sur les liens
  const handleLinkClick = (e) => {
    e.preventDefault();
    const targetUrl = new URL(e.currentTarget.href, window.location.origin);
    history.pushState({}, "", targetUrl);
    loadContentFromUrl(targetUrl, container, attachLinkEventListeners);
  };

  // Gestion de l'événement de soumission du formulaire
  formsearch.addEventListener("click", (e) => {
    e.preventDefault(); // Éviter un comportement inattendu si ce n'est pas un bouton
    console.log("Recherche effectuée");

    const searchTerm = searchInput.value.trim();
    if (!searchTerm) {
      console.warn("Le champ de recherche est vide.");
      return;
    }

    const searchUrl = `index.php?component=search&q=${encodeURIComponent(
      searchTerm
    )}`;
    loadContentFromUrl(searchUrl, container, attachLinkEventListeners);
  });

  attachLinkEventListeners();
});
