let isLoading = false;


export const loadContentFromUrl = (url, container, callback) => {
  if (isLoading) {
    console.warn("Une requête est déjà en cours, veuillez patienter.");
    return;
  }

  isLoading = true;
  console.log("Requête démarrée :", url);
  container.classList.add("loading");

  fetch(url)
    .then((response) => {
      if (!response.ok) {
        throw new Error(`Erreur ${response.status} : ${response.statusText}`);
      }
      return response.text();
    })
    .then((html) => {
      const tempDiv = document.createElement("div");
      tempDiv.innerHTML = html;

      const newContent = tempDiv.querySelector(".container");

      if (!newContent) {
        throw new Error("Container introuvable dans la réponse HTML");
      }

      container.innerHTML = "";
      container.appendChild(newContent);
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
      isLoading = false;
      console.log("Requête terminée :", url);
      container.classList.remove("loading");
    });
};
