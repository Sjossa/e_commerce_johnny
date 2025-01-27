<?php if (isset($posts) && $posts): ?>
  <!-- Affichage des articles -->
  <div class="row row-cols-1 row-cols-md-3 g-4">
    <?php foreach ($posts as $article): ?>
      <div class="col">
        <div class="card shadow-lg h-100 border-light rounded-3">
          <!-- Image de l'article (ajouter l'image dynamique) -->
          <img src="upload/<?= htmlspecialchars($article['image']) ?>" class="card-img-top img-fluid"
            alt="Image de l'article">

          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($article['nom']); ?></h5>
            <p class="card-text"><?= htmlspecialchars($article['description']); ?></p>
            <div class="d-flex justify-content-between align-items-center">
              <!-- Lien vers les détails de l'article -->
              <a href="index.php?component=info_article&id_article=<?= htmlspecialchars($article['id_article']); ?>"
                class="btn btn-info btn-sm detail-btn link text-decoration-none">
                Détails
              </a>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php else: ?>
  <!-- Message si aucun article trouvé -->
  <div class="alert alert-warning text-center" role="alert">
    Aucun article trouvé pour votre recherche.
    <a href="index.php" class="btn btn-primary btn-sm mt-2">Retour à la boutique</a>
  </div>
<?php endif; ?>

