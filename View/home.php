<?php if (isset($posts) && $posts): ?>


  <!-- Filtrage par catégorie -->
  <div class="mb-4">
     <h1 class="text-center text-capitalize">Article du moment</h1>
    <select name="categories_filtre" id="categories_filtre" class="form-select" required>
      <option value="" disabled <?= $filtre_categorie == 0 ? 'selected' : '' ?>>Filtrer par catégorie
      </option>
      <option value="0" <?= $filtre_categorie == 0 ? 'selected' : '' ?>>Aucune</option>

      <?php foreach ($categories as $filtre): ?>
        <option value="<?= htmlspecialchars($filtre['id_categorie'], ENT_QUOTES, 'UTF-8') ?>"
          <?= $filtre_categorie == $filtre['id_categorie'] ? 'selected' : '' ?>>
          <?= htmlspecialchars($filtre['nom'], ENT_QUOTES, 'UTF-8') ?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <!-- Liste des articles -->
  <div class="row row-cols-1 row-cols-md-3 g-4">
    <?php foreach ($posts as $article): ?>
      <div class="col">
        <div class="card shadow-sm h-100 bg-dark text-white rounded-3 hover-shadow">
          <img src="upload/<?= htmlspecialchars($article['image'], ENT_QUOTES, 'UTF-8') ?>"
            class="card-img-top rounded-3" alt="Image de l'article">
          <div class="card-body d-flex justify-content-center align-items-center flex-column">
            <h5 class="card-title text-center text-capitalize">
              <?= htmlspecialchars($article['nom'], ENT_QUOTES, 'UTF-8') ?></h5>
            <p class="card-text text-center">
              <?= htmlspecialchars($article['description'], ENT_QUOTES, 'UTF-8') ?></p>
            <p class="card-text text-center">
              <?= htmlspecialchars($article['prix'], ENT_QUOTES, 'UTF-8') ?> $</p>
            <a href="index.php?component=info_article&id_article=<?= htmlspecialchars($article['id_article'], ENT_QUOTES, 'UTF-8') ?>"
              class="btn btn-info btn-sm text-decoration-none link">
              Détails
            </a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Pagination -->
  <nav aria-label="Page navigation" class="mt-4">
    <ul class="pagination justify-content-center">
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
          <a href="index.php?component=home&articles=<?= $i ?>&tri=<?= htmlspecialchars($tri, ENT_QUOTES, 'UTF-8') ?>&filtre_categorie=<?= htmlspecialchars($filtre_categorie, ENT_QUOTES, 'UTF-8') ?>"
            class="page-link link">
            <?= $i ?>
          </a>
        </li>
      <?php endfor; ?>
    </ul>
  </nav>

<?php else: ?>

  <div class="alert alert-warning text-center" role="alert">
    Aucun article trouvé pour votre recherche.
    <br>
    <a href="index.php?component=home" class="btn btn-primary btn-sm mt-2 link">Réinitialiser le
      filtre</a>
  </div>
  <!-- Optionnel : Redirection automatique après 3 secondes -->
  <!--
  <script>
    setTimeout(() => {
      window.location.href = 'index.php?component=home';
    }, 3000);
  </script>
  -->
<?php endif; ?>

<!-- Script pour gérer les filtres -->
<script type="module">
  import { loadContentFromUrl } from "./Asset/Services/fetch.js";

  const attachCategoryFilterListener = () => {
    const categoryFilter = document.getElementById('categories_filtre');
    if (categoryFilter) {
      categoryFilter.addEventListener('change', function () {
        const categorieId = this.value;
        const url = `index.php?component=home&filtre_categorie=${categorieId}`;
        loadContentFromUrl(url, document.getElementById('principal'));
        history.pushState({ path: url }, '', url);
      });
    }
  };

  attachCategoryFilterListener();
</script>
