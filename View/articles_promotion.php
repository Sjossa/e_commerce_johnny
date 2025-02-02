<div class="container mt-4">
  <!-- Section Filtrage par catégorie -->
  <div class="mb-4">
    <h1 class="text-center text-capitalize">en promotion</h1>
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

  <!-- Liste des Articles -->
  <div class="row row-cols-1 row-cols-md-3 g-4">
    <?php foreach ($posts as $article): ?>
      <?php if ($article['categories_nom'] !== null): ?>
        <div class="col">
          <div class="card shadow-sm h-100 border-0 rounded-lg hover-shadow">
            <div class="card-body">
              <!-- Titre de l'article -->
              <h5 class="card-title text-truncate"><?= htmlspecialchars($article['nom']) ?></h5>

              <!-- Image de l'article -->
              <div class="mb-3">
                <img src="upload/<?= htmlspecialchars($article['image']) ?>" alt="Image de l'article"
                  class="img-fluid d-block mx-auto rounded-3"
                  style="max-height: 200px; object-fit: cover;">
              </div>

              <!-- Description de l'article -->
              <p class="card-text text-muted" style="max-height: 100px; overflow: hidden;">
                <?= htmlspecialchars($article['description']) ?>
              </p>

              <!-- Bouton Détails -->
              <div class="d-flex justify-content-between align-items-center">
                <a href="index.php?component=info_article&id_article=<?= $article['id_article'] ?>"
                  class="btn btn-outline-primary btn-sm w-100 link">Détails</a>
              </div>
            </div>
          </div>
        </div>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>

  <!-- Pagination -->
  <nav aria-label="Page navigation" class="mt-4">
    <ul class="pagination justify-content-center">
      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
          <a href="index.php?component=articles_promotion&articles=<?= $i ?>&tri=<?= htmlspecialchars($tri, ENT_QUOTES, 'UTF-8') ?>&filtre_categorie=<?= htmlspecialchars($filtre_categorie, ENT_QUOTES, 'UTF-8') ?>"
            class="page-link link"><?= $i ?></a>
        </li>
      <?php endfor; ?>
    </ul>
  </nav>
</div>

<!-- Styles -->
<style>
  .card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
  }

  .hover-shadow {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .card-body {
    padding: 1.25rem;
  }

  .card-title {
    font-size: 1.1rem;
    font-weight: bold;
  }

  .btn-outline-primary {
    transition: background-color 0.3s ease, color 0.3s ease;
  }

  .btn-outline-primary:hover {
    background-color: #007bff;
    color: white;
  }

  .container {
    max-width: 1200px;
  }

  .pagination {
    margin-top: 20px;
  }
</style>

<!-- JavaScript -->
<script type="module">
  import { loadContentFromUrl } from "./Asset/Services/fetch.js";

  // Écouteur de changement pour le filtrage par catégorie
  const attachCategoryFilterListener = () => {
    const categoryFilter = document.getElementById('categories_filtre');
    if (categoryFilter) {
      categoryFilter.addEventListener('change', function () {
        const categorieId = this.value;
        const url = `index.php?component=articles_promotion&filtre_categorie=${categorieId}`;
        loadContentFromUrl(url, document.getElementById('principal'));
        history.pushState({ path: url }, '', url);
      });
    }
  };

  attachCategoryFilterListener();
</script>
