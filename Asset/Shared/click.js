import { loadContentFromUrl } from "../Services/fetch.js";

document.addEventListener("DOMContentLoaded", () => {
  console.log("DOM content loaded");

  const principal = document.querySelector("#principal");
  const formsearch = document.querySelector("#form-article");
  const searchInput = document.querySelector("#search-article");

  console.log("Sélection des éléments HTML...");

  // Vérification de l'existence des éléments
  if (!principal) {
    console.error("Erreur : l'élément '.principal' est introuvable.");
  } else {
    console.log("Élément '#principal' trouvé.");
  }

  if (!formsearch) {
    console.error(
      "Erreur : l'élément avec l'ID 'form-Articles' est introuvable."
    );
  } else {
    console.log("Élément '#form-article' trouvé.");
  }

  if (!searchInput) {
    console.error(
      "Erreur : l'élément avec l'ID 'Search-articles' est introuvable."
    );
  } else {
    console.log("Élément '#search-article' trouvé.");
  }

  // Fonction pour attacher les événements aux liens
  const re_link = () => {
    console.log("Attachement des événements aux liens...");

    const links = document.querySelectorAll(".link");

    console.log(`Nombre d'éléments '.link' trouvés : ${links.length}`);

    if (links.length === 0) {
      console.warn("Aucun élément avec la classe '.link' trouvé dans le DOM.");
    }

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
    loadContentFromUrl(targetUrl, principal, re_link);
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

    loadContentFromUrl(searchUrl, principal, re_link);
  });

  console.log(
    "Les événements pour '.link', '.detail-btn' et le formulaire de recherche sont configurés."
  );

  // Attacher un événement au clic sur les liens
  re_link();
});
