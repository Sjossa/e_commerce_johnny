export const loadContentFromUrl = (url, principal, callback) => {


  console.log("Requête démarrée :", url);
  principal.classList.add("loading");

  fetch(url)
    .then((response) => {
      if (!response.ok) {
        throw new Error(`Erreur ${response.status} : ${response.statusText}`);
      }
      return response.text();
    })
    .then((html) => {
      // On remplace directement le contenu de `principal` avec l'élément cible extrait
      const parser = new DOMParser();
      const doc = parser.parseFromString(html, "text/html");
      const newContent = doc.querySelector("#principal");

      if (!newContent) {
        throw new Error("Élément #principal introuvable dans la réponse HTML");
      }

      principal.innerHTML = newContent.innerHTML; // Remplace uniquement le contenu
      console.log("Contenu chargé :", url);

      if (callback) callback();
    })
    .catch((error) => {
      console.error("Erreur pendant le chargement :", error);
      alert(
        "Une erreur est survenue lors du chargement de la page. Veuillez réessayer."
      );
    })
    .finally(() => {
     
      console.log("Requête terminée :", url);
      principal.classList.remove("loading");
    });
};
