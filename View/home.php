<?php if (!empty($posts)): ?>
  <?php foreach ($posts as $post): ?>
    <h2><?= htmlspecialchars($post['nom'], ENT_QUOTES, 'UTF-8'); ?></h2>


  <?php endforeach; ?>
<?php else: ?>
  <p>Aucun article trouvé.</p>
<?php endif; ?>


