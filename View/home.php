<?php if (!empty($posts)): ?>
  <?php foreach ($posts as $post): ?>
    <div class="d-flex mb-3">
      <div class="me-3"><?= htmlspecialchars($post['nom'], ENT_QUOTES, 'UTF-8'); ?></div>
      <div class="me-3"><?= htmlspecialchars($post['description'], ENT_QUOTES, 'UTF-8'); ?></div>
      <div class="me-3"><?= htmlspecialchars($post['image'], ENT_QUOTES, 'UTF-8'); ?></div>
      <div class="me-3"><?= htmlspecialchars($post['stock'], ENT_QUOTES, 'UTF-8'); ?></div>
      <div class="me-3"><?= htmlspecialchars($post['id_categorie'], ENT_QUOTES, 'UTF-8'); ?></div>
    </div>
  <?php endforeach; ?>
<?php else: ?>
  <p>Aucun article trouvé.</p>
<?php endif; ?>

