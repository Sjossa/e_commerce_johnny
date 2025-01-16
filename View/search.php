<?php if (isset($posts) && $posts): ?>

  <h2>Résultats de recherche</h2>

  <?php foreach ($posts as $article): ?>
    <p onclick="toogleUser(<?php echo $article['id_article']; ?>)">
      <?php echo htmlspecialchars($article['nom']); ?>

  <?php endforeach; ?>

<?php elseif (!empty($_GET['q'])): ?>
  <p>Aucun article trouvé pour votre recherche.</p>
<?php endif; ?>

