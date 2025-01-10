document.addEventListener("DOMContentLoaded", () => {
  const attachLinkEventListeners = () => {
    document.querySelectorAll(".link").forEach((link) => {
      link.addEventListener("click", (e) => {
        e.preventDefault();

        const targetUrl = new URL(link.href, window.location.origin);

        fetch(targetUrl)
          .then((response) => {
            if (!response.ok) {
              throw new Error("Erreur 404");
            }
            return response.text();
          })
          .then((html) => {
            const tempDiv = document.createElement("div");
            tempDiv.innerHTML = html;

            const content = tempDiv.querySelector(".container").innerHTML;

            document.querySelector(".container").innerHTML = content;

            history.pushState({}, "", targetUrl);
            attachLinkEventListeners();
          })
          .catch((error) => {
            console.error("Error during fetch:", error);
          });
      });
    });
  };

  document.querySelector("#aaa").addEventListener("submit", (e) => {
    e.preventDefault();

    const searchTerm = document.getElementById("searchImput").value;
    if (searchTerm === "") {
      alert("Erreur : Aucun terme de recherche renseigné");
      return;
    }

    const searchUrl = `index.php?component=search&q=${encodeURIComponent(
      searchTerm
    )}`;

    fetch(searchUrl)
      .then((response) => {
        if (!response.ok) {
          throw new Error("Erreur 404");
        }
        return response.text();
      })
      .then((html) => {
        const tempDiv = document.createElement("div");
        tempDiv.innerHTML = html;

        const content = tempDiv.querySelector(".container").innerHTML;

        document.querySelector(".container").innerHTML = content;

        history.pushState({}, "", searchUrl);
        attachLinkEventListeners();
      })
      .catch((error) => {
        console.error("Error during search fetch:", error);
      });
  });

  attachLinkEventListeners();
});
