document.addEventListener("DOMContentLoaded", function () {
  function attachLinkEventListeners() {
    document.querySelectorAll(".link").forEach((link) => {
      link.addEventListener("click", function (e) {
        e.preventDefault();

        const targetUrl = new URL(this.href, window.location.origin);

        fetch(targetUrl)
          .then((response) => {
            if (!response.ok) {
              throw new Error("Erreur 404");
            }
            return response.text();
          })
          .then((html) => {
            document.querySelector(".container").innerHTML = html;
            history.pushState({}, "", targetUrl);
            attachLinkEventListeners();
          })
          .catch((error) => {
            console.error(error);
          });
      });
    });
  }

  document.querySelector("#aaa").addEventListener("submit", function (e) {
    e.preventDefault();


    var searchTerm = document.getElementById("searchImput").value;

    if (searchTerm) {
      console.log('aaa');
      
      var search_Url = `index.php?component=search&q=${encodeURIComponent(
        searchTerm
      )}`;

      fetch(search_Url)
        .then((response) => {
          if (!response.ok) {
            throw new Error("Erreur 404");
          }
          return response.text();
        })
        .then((html) => {
          document.querySelector(".container").innerHTML = html;
          history.pushState({}, "", search_Url);
          attachLinkEventListeners();
        })
        .catch((error) => {
          console.error(error);
        });
    }
  });
  attachLinkEventListeners();
});
