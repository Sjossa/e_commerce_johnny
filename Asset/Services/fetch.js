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
      const parser = new DOMParser();
      const doc = parser.parseFromString(html, "text/html")
      const newContent = doc.querySelector("#principal");

      if (!newContent) {
        throw new Error("Élément #principal introuvable dans la réponse HTML");
      }

      // Remplace uniquement le contenu de `principal`
      principal.innerHTML = newContent.innerHTML;
      console.log("Contenu chargé :", url);

      // Réinitialiser/recharger les scripts
      const scriptElements = newContent.querySelectorAll("script");
      scriptElements.forEach((script) => {
        const newScript = document.createElement("script");
        newScript.type = script.type || "text/javascript";

        if (script.src) {
          // Si le script a un attribut src, on le recharge à partir de cette URL
          newScript.src = script.src;
        } else {
          // Sinon, on copie le contenu inline du script
          newScript.textContent = script.textContent;
        }

        // Ajoute le nouveau script au DOM
        document.body.appendChild(newScript).parentNode.removeChild(newScript);
      });

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
