<?php if (isset($posts) && $posts): ?>


  <div class="row row-cols-1 row-cols-md-3 g-4">
    <?php foreach ($posts as $article): ?>
      <div class="col">
        <div class="card shadow-sm h-100">
          <div class="card-body">
            <h5 class="card-title"><?php echo htmlspecialchars($article['nom']); ?></h5>
            <p class="card-text"><?php echo htmlspecialchars($article['description']); ?></p>
            <div class="d-flex justify-content-between align-items-center">
              <a  href="index.php?component=info_article&id_article=<?= $article['id_article']; ?>" class="btn btn-secondary btn-sm detail-btn link" >Détails</a>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

<?php elseif (!empty($_GET['q'])): ?>
  <p>Aucun article trouvé pour votre recherche.</p>
<?php endif; ?>


<script>
  document.addEventListener("DOMContentLoaded", () => {
    // Sélectionne tous les boutons avec la classe "detail-btn"


    // Ajoute un gestionnaire d'événements à chaque bouton
    buttons.forEach(button => {
      button.addEventListener('click', () => {
        const articleId = button.getAttribute('data-id'); // Récupère l'id de l'article
        window.location.href = "index.php?component=article&id=" + articleId; // Redirection
      });
    });
  });
</script>
