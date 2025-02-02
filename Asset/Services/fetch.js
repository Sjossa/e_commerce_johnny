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
      const doc = parser.parseFromString(html, "text/html");
      const newContent = doc.querySelector("#principal");

      if (!newContent) {
        throw new Error("Élément #principal introuvable dans la réponse HTML");
      }

      // Remplace uniquement le contenu de `principal`
      principal.innerHTML = newContent.innerHTML;
      console.log("Contenu chargé :", url);

      // Supprimer les anciens scripts de `principal`
      principal.querySelectorAll("script").forEach((script) => script.remove());

      // Réinitialiser/recharger les scripts
      const scriptElements = newContent.querySelectorAll("script");
      scriptElements.forEach((script) => {
        const newScript = document.createElement("script");
        newScript.type = script.type || "text/javascript";

        if (script.src) {
          // Vérifie si le script existe déjà avant de l'ajouter
          if (!document.querySelector(`script[src="${script.src}"]`)) {
            newScript.src = script.src;
            newScript.onload = () =>
              console.log(`Script chargé : ${script.src}`);
            document.body.appendChild(newScript);
          }
        } else {
          // Exécuter les scripts inline
          newScript.textContent = script.textContent;
          document.body.appendChild(newScript);

          // Exécuter immédiatement les scripts inline
          setTimeout(() => {
            eval(script.textContent);
          }, 0);
        }
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
