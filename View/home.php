<?php if (isset($posts) && $posts): ?>
  <!-- Affichage des articles -->
  <div class="row row-cols-1 row-cols-md-3 g-4">
    <?php foreach ($posts as $article): ?>
      <div class="col">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($article['nom']); ?></h5>
            <p class="card-text"><?php echo htmlspecialchars($article['description']); ?></p>
            <div class="d-flex justify-content-between align-items-center">
              <!-- Lien vers les détails de l'article -->
              <a href="index.php?component=info_article&id_article=<?php echo $article['id_article']; ?>" class="btn btn-secondary btn-sm detail-btn link">Détails</a>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php else : ?>
  <!-- Message si aucun article trouvé -->
  <p>Aucun article trouvé pour votre recherche.</p>
<?php endif; ?>
