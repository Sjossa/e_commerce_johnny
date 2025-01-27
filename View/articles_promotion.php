<div class="row row-cols-1 row-cols-md-3 g-4">
  <?php foreach ($posts as $article): ?>
    <?php if ($article['id_promotion'] !== null): ?>
      <div class="col">
        <div class="card shadow-sm h-100 border-0 rounded-lg">
          <div class="card-body">
            <!-- Titre de l'article -->
            <h5 class="card-title text-truncate" style="max-width: 100%;">
              <?php echo htmlspecialchars($article['nom']); ?>
            </h5>
<div class="col-md-3">
        <img src="upload/<?= htmlspecialchars($article['image']) ?>" alt="Image de l'article"
          class="img-fluid d-block mx-auto max-width-200 img-thumbnail">
      </div>
            <!-- Description de l'article -->
            <p class="card-text text-muted" style="max-height: 100px; overflow: hidden;">
              <?php echo htmlspecialchars($article['description']); ?>
            </p>

            <!-- Bouton Détails -->
            <div class="d-flex justify-content-between align-items-center">
              <a href="index.php?component=info_article&id_article=<?php echo $article['id_article']; ?>"
                class="btn btn-outline-primary btn-sm w-100" aria-label="Voir les détails de l'article">
                Détails
              </a>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  <?php endforeach; ?>
</div>
