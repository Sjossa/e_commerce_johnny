import { loadContentFromUrl } from "./fetch.js";

document.addEventListener("DOMContentLoaded", () => {
  console.log("DOM entièrement chargé et analysé.");

  const container = document.querySelector(".container");
  const formsearch = document.querySelector("#form-article");
  const searchInput = document.querySelector("#search-article");

  // Vérification de l'existence des éléments
  if (!container) {
    console.error("Erreur : l'élément '.container' est introuvable.");
  } else {
    console.log("Élément '.container' trouvé :", container);
  }

  if (!formsearch) {
    console.error(
      "Erreur : l'élément avec l'ID 'form-Articles' est introuvable."
    );
  } else {
    console.log("Élément '.form-Articles' trouvé :", formsearch);
  }

  if (!searchInput) {
    console.error(
      "Erreur : l'élément avec l'ID 'Search-articles' est introuvable."
    );
  } else {
    console.log("Élément '.Search-articles' trouvé :", searchInput);
  }

  // Fonction pour attacher les événements aux liens
  const re_link = () => {
    const links = document.querySelectorAll(".link");
    if (links.length === 0) {
      console.warn("Aucun élément avec la classe '.link' trouvé dans le DOM.");
    }

    console.log(`Nombre d'éléments '.link' trouvés : ${links.length}`);
    links.forEach((link) => {
      console.log("Attachement des événements au lien :", link);
      link.removeEventListener("click", handleLinkClick);
      link.addEventListener("click", handleLinkClick);
    });
  };



  // Gestionnaire de clic sur les liens
  const handleLinkClick = (e) => {
    e.preventDefault();

    console.log("Lien cliqué :", e.currentTarget.href);

    const targetUrl = new URL(e.currentTarget.href, window.location.origin);

    console.log("URL cible générée :", targetUrl.toString());

    if (
      targetUrl.pathname === window.location.pathname &&
      targetUrl.search === window.location.search
    ) {
      console.log(
        "Lien cliqué pointe déjà vers la page actuelle, aucune action effectuée."
      );
      return;
    }

    console.log("Chargement du contenu pour :", targetUrl.toString());
    history.pushState({}, "", targetUrl);
    loadContentFromUrl(targetUrl, container, re_link, );
  };

  // Gestion de l'événement de soumission du formulaire
  formsearch.addEventListener("click", (e) => {
    e.preventDefault();
    console.log("Formulaire de recherche soumis.");

    const searchTerm = searchInput.value.trim();
    console.log("Terme recherché :", searchTerm);

    if (!searchTerm) {
      console.warn(
        "Le champ de recherche est vide, aucune recherche effectuée."
      );
      return;
    }

    const searchUrl = `index.php?component=search&q=${encodeURIComponent(
      searchTerm
    )}`;
    console.log("URL de recherche générée :", searchUrl);

    loadContentFromUrl(searchUrl, container, re_link, );
  });



  console.log(
    "Les événements pour '.link', '.detail-btn' et le formulaire de recherche sont configurés."
  );

  // Attacher un événement au clic sur les liens
  re_link();
});
