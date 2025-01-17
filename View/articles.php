<?php if (!empty($posts)): ?>
  <!-- Boutons pour accéder aux formulaires -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <a href="index.php?component=article&create" class="btn btn-success">
      Ajouter un article
    </a>
    <button id="bbbb" class="btn btn-primary">
      Ajouter une catégorie
    </button>
  </div>

  <!-- Barre de recherche -->
  <div class="mb-3">
    <input type="text" id="SearchArticle" class="form-control" placeholder="Recherchez un article par nom ou description">
  </div>

  <!-- Tableau des articles -->
  <table class="table table-bordered table-hover shadow-sm" id="articleTable">
    <thead class="table-light">
      <tr>
        <th scope="col">Nom</th>
        <th scope="col">Description</th>
        <th scope="col">Image</th>
        <th scope="col">Stock</th>
        <th scope="col">Catégorie</th>
        <th scope="col">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($posts as $post): ?>
        <tr>
          <td><?= htmlspecialchars($post['nom'], ENT_QUOTES, 'UTF-8'); ?></td>
          <td><?= htmlspecialchars($post['description'], ENT_QUOTES, 'UTF-8'); ?></td>
          <td>
            <img src="<?= htmlspecialchars($post['image'], ENT_QUOTES, 'UTF-8'); ?>" alt="Image"
              class="img-thumbnail" style="width: 100px; height: auto;">
          </td>
          <td><?= htmlspecialchars($post['stock'], ENT_QUOTES, 'UTF-8'); ?></td>
          <td><?= htmlspecialchars($post['categories_nom'], ENT_QUOTES, 'UTF-8'); ?></td>
          <td>
            <a href="index.php?component=article&id=<?= $post['id_article']; ?>"
              class="btn btn-warning btn-sm">Modifier</a>
            <a href="index.php?component=articles&id=<?= $post['id_article']; ?>"
              class="btn btn-danger btn-sm" id="btn-Delete">Supprimer</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
<?php else: ?>
  <p>Aucun article trouvé.</p>

  <!-- Boutons visibles même si la liste est vide -->
  <div class="mt-3">
    <a href="index.php?component=article" class="btn btn-success">
      Ajouter un article
    </a>
    <a href="#" class="btn btn-primary float-end">
      Ajouter une catégorie
    </a>
  </div>
<?php endif; ?>


<script>
  const btnCategories = document.getElementById("bbbb");
  const SearchArticlet = document.getElementById("SearchArticle");
  const table = document.getElementById("articleTable");
  const rows = table.querySelectorAll("tbody tr");

  // Gestion de la recherche
  SearchArticlet.addEventListener("input", (e) => {
    const query = e.target.value.toLowerCase();
    console.log("aaa");


    rows.forEach(row => {
      const name = row.cells[0].textContent.toLowerCase();
      const description = row.cells[1].textContent.toLowerCase();

      if (name.includes(query) || description.includes(query)) {
        row.style.display = "";
      } else {
        row.style.display = "none";
      }
    });
  });

  // Bouton Ajouter une catégorie
  btnCategories.addEventListener("click", () => {
    let existingForm = document.querySelector(".form-container");
    if (existingForm) {
      existingForm.remove();
    } else {
      const divContainer = document.createElement("div");
      divContainer.classList.add("form-container", "mt-3");

      const inputField = document.createElement("input");
      inputField.type = "text";
      inputField.id = "dd";
      inputField.placeholder = "Entrez une nouvelle catégorie";
      inputField.name = "nom";
      inputField.classList.add("form-control", "mb-2");

      const form = document.createElement("form");
      form.method = "POST";
      form.action = "index.php?component=articles&categorie";

      const button = document.createElement("button");
      button.textContent = "Envoyer la valeur";
      button.type = "submit";
      button.classList.add("btn", "btn-primary");

      form.appendChild(inputField);
      form.appendChild(button);
      divContainer.appendChild(form);
      btnCategories.insertAdjacentElement("afterend", divContainer);
    }
  });
</script>
