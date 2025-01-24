<?php require "Partial/securite.php";
if (!empty($posts)): ?>

<?php var_dump($page);?>

  <!-- Section des actions -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <a href="index.php?component=article&create" class="btn btn-success d-flex align-items-center">
      <i class="bi bi-plus-circle me-2"></i> Ajouter un article
    </a>
    <button id="bbbb" class="btn btn-primary d-flex align-items-center">
      <i class="bi bi-folder-plus me-2"></i> Ajouter une catégorie
    </button>
  </div>

  <div class="mb-4">
    <select name="categories_filtre" id="categories_filtre" class="form-select" required>
      <option value="" disabled selected>Filtrer par catégorie</option>
      <option value="A">Aucune</option>

      <?php foreach ($filtres as $filtre): ?>
        <option value="<?= htmlspecialchars($filtre['id_categorie'], ENT_QUOTES, 'UTF-8') ?>"
          <?= isset($article['nom']) && $article['nom'] == $filtre['nom'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($filtre['nom'], ENT_QUOTES, 'UTF-8') ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <!-- Tableau des articles -->
  <div class="table-responsive shadow-sm">
    <table class="table table-striped table-bordered table-hover" id="articleTable">
      <thead class="table-primary text-center">
        <tr>
          <th scope="col">
            <a href="#" class="text-decoration-none link">Nom</a>
          </th>
          <th scope="col">Description</th>
          <th scope="col">Image</th>
          <th scope="col">
            <a href="index.php?component=articles&tri=stock&articles=<?php echo $page ?>&filtre_categorie=<?php echo htmlspecialchars($filtre_categorie, ENT_QUOTES, 'UTF-8'); ?>"
              class="text-decoration-none link">Stock</a>




          </th>
          <th scope="col">
           Catégorie
          </th>
          <th scope="col"> <a href="index.php?component=articles&tri=stock&articles=<?php echo $page ?>&filtre_categorie=<?php echo htmlspecialchars($filtre_categorie, ENT_QUOTES, 'UTF-8'); ?>"
            class="text-decoration-none link">Prix</a></th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($posts as $post): ?>
          <tr>
            <td><?= htmlspecialchars($post['nom'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?= htmlspecialchars($post['description'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td class="text-center">
              <img src="upload/<?= htmlspecialchars($post['image'], ENT_QUOTES, 'UTF-8') ?>"
                alt="Image de l'article" class="img-fluid img-thumbnail" style="max-width: 100px;">
            </td>
            <td class="text-center"><?= htmlspecialchars($post['stock'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td>
              <?= isset($post['categories_nom']) ? htmlspecialchars($post['categories_nom'], ENT_QUOTES, 'UTF-8') : 'Aucune catégorie'; ?>
            </td>
            <td>
              <?php
              if (isset($post['pourcentage']) && isset($post['prix'])) {
                // Afficher le prix barré
                echo '<span style="text-decoration: line-through;">'
                  . htmlspecialchars($post['prix'], ENT_QUOTES, 'UTF-8')
                  . ' &euro;</span><br>';

                // Afficher le texte "en promotion" suivi du prix après réduction
                if ($post['pourcentage'] != 0) {
                  echo "En promotion : "
                    . htmlspecialchars($post['prix'] * (1 - $post['pourcentage'] / 100), ENT_QUOTES, 'UTF-8')
                    . ' &euro;';
                } else {
                  echo "Erreur : le pourcentage ne peut pas être 0.";
                }
              } elseif (isset($post['prix'])) {
                // Afficher uniquement le prix si le pourcentage n'existe pas
                echo htmlspecialchars($post['prix'], ENT_QUOTES, 'UTF-8') . ' &euro;';
              } else {
                // Si rien n'est défini, afficher un message d'erreur
                echo 'Erreur : pas de prix.';
              }
              ?>
            </td>

            <td class="text-center">
              <a href="index.php?component=article&id_article=<?= htmlspecialchars($post['id_article'], ENT_QUOTES, 'UTF-8'); ?>"
                class="btn btn-warning btn-sm">
                <i class="bi bi-pencil-square"></i> Modifier
              </a>
              <a href="index.php?component=articles&id_article=<?= htmlspecialchars($post['id_article'], ENT_QUOTES, 'UTF-8'); ?>"
                class="btn btn-danger btn-sm" id="btn-Delete">
                <i class="bi bi-trash"></i> Supprimer
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <nav aria-label="Page navigation" class="mt-4">
    <ul class="pagination justify-content-center">
      <?php if (isset($_GET['tri']) && isset($_GET['filtre_categorie'])): ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <li class="page-item <?= $i == $page ? 'active' : '' ?>">
            <a href="index.php?component=articles&articles=<?= $i ?>&tri=<?= htmlspecialchars($tri, ENT_QUOTES, 'UTF-8'); ?>&filtre_categorie=<?= htmlspecialchars($filtre_categorie, ENT_QUOTES, 'UTF-8'); ?>"
              class="page-link link"><?= $i ?></a>
          </li>
        <?php endfor; ?>
        <?php if ($page < $totalPages): ?>
          <li class="page-item">
            <a href="index.php?component=articles&articles=<?= $page + 1 ?>&tri=<?= htmlspecialchars($tri, ENT_QUOTES, 'UTF-8'); ?>&filtre_categorie=<?= htmlspecialchars($filtre_categorie, ENT_QUOTES, 'UTF-8'); ?>"
              class="page-link link">Suivant</a>
          </li>
        <?php endif; ?>

        <!-- Si seulement "tri" est défini -->
      <?php elseif (isset($_GET['tri']) && !isset($_GET['filtre_categorie'])): ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <li class="page-item <?= $i == $page ? 'active' : '' ?>">
            <a href="index.php?component=articles&articles=<?= $i ?>&tri=<?= htmlspecialchars($tri, ENT_QUOTES, 'UTF-8'); ?>"
              class="page-link link"><?= $i ?></a>
          </li>
        <?php endfor; ?>
        <?php if ($page < $totalPages): ?>
          <li class="page-item">
            <a href="index.php?component=articles&articles=<?= $page + 1 ?>&tri=<?= htmlspecialchars($tri, ENT_QUOTES, 'UTF-8'); ?>"
              class="page-link link">Suivant</a>
          </li>
        <?php endif; ?>

        <!-- Si seulement "filtre_categorie" est défini -->
      <?php elseif (isset($_GET['filtre_categorie']) && !isset($_GET['tri'])): ?>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <li class="page-item <?= $i == $page ? 'active' : '' ?>">
            <a href="index.php?component=articles&articles=<?= $i ?>&filtre_categorie=<?= htmlspecialchars($filtre_categorie, ENT_QUOTES, 'UTF-8'); ?>"
              class="page-link link"><?= $i ?></a>
          </li>
        <?php endfor; ?>
        <?php if ($page < $totalPages): ?>
          <li class="page-item">
            <a href="index.php?component=articles&articles=<?= $page + 1 ?>&filtre_categorie=<?= htmlspecialchars($filtre_categorie, ENT_QUOTES, 'UTF-8'); ?>"
              class="page-link link">Suivant</a>
          </li>
        <?php endif; ?>

        <!-- Pagination normale (ni tri ni filtre) -->
      <?php else: ?>
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
          <li class="page-item <?= $i == $page ? 'active' : '' ?>">
            <a href="index.php?component=articles&articles=<?= $i ?>" class="page-link link"><?= $i ?></a>
          </li>
        <?php endfor; ?>
        <?php if ($page < $totalPages): ?>
          <li class="page-item">
            <a href="index.php?component=articles&articles=<?= $page + 1 ?>"
              class="page-link link">Suivant</a>
          </li>
        <?php endif; ?>
      <?php endif; ?>
    </ul>
  </nav>




<?php else: ?>
  <p class="text-center text-muted">Aucun article trouvé.</p>
<?php endif; ?>
<script type="module" src="Asset/Services/fetch.js"></script>



<script type="module">
  import { loadContentFromUrl } from "./Asset/Services/fetch.js";

  // Filtrer par catégorie : Définition de la fonction
  const attachCategoryFilterListener = () => {
    const categoryFilter = document.getElementById('categories_filtre');

    if (categoryFilter) {
      categoryFilter.addEventListener('change', function () {
        const categorieId = this.value;
        console.log('Catégorie sélectionnée:', categorieId);

        if (categorieId) {
          const url = `index.php?component=articles&filtre_categorie=${categorieId}`;

          loadContentFromUrl(url, document.getElementById('principal'), () => {
            console.log("Contenu mis à jour !");
            attachCategoryFilterListener(); // Réattacher le listener après mise à jour
          });

          history.pushState({ path: url }, '', url); // Modifier l'URL sans recharger
        }
      });
    }
  };

  // Appel initial de la fonction après la déclaration
  attachCategoryFilterListener();

  // Ajout de la logique pour les boutons existants
  const btnCategories = document.getElementById("bbbb");
  const deleteBtns = document.querySelectorAll("#btn-Delete");

  deleteBtns.forEach(btn => {
    btn.addEventListener("click", function (event) {
      if (!confirm('Êtes-vous sûr de vouloir supprimer cet article ?')) {
        event.preventDefault();
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
      button.textContent = "Envoyer";
      button.type = "submit";
      button.classList.add("btn", "btn-primary");

      form.appendChild(inputField);
      form.appendChild(button);
      divContainer.appendChild(form);
      btnCategories.insertAdjacentElement("afterend", divContainer);
    }
  });
</script>
