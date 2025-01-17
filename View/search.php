<?php if (isset($posts) && $posts): ?>

  <h2>Résultats de recherche</h2>

  <?php foreach ($posts as $article): ?>
    <p onclick="toogleUser(<?php echo $article['id_article']; ?>)">
      <?php echo htmlspecialchars($article['nom']); ?>
      <a href="index.php?component=article&id=<?= $article['id_article']; ?>"
              class="btn btn-warning btn-sm link">Modifier</a>


  <?php endforeach; ?>

<?php elseif (!empty($_GET['q'])): ?>
  <p>Aucun article trouvé pour votre recherche.</p>
<?php endif; ?>

