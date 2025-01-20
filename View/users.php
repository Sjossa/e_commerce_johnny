<?php if (!empty($posts)): ?>

  <!-- Tableau des utilisateurs -->
  <div class="table-responsive shadow-sm rounded">
    <table class="table table-striped table-bordered table-hover align-middle text-center">
      <thead class="table-primary">
        <tr>
          <th scope="col">
            <a href="index.php?component=users&tri=username&users=<?= $page ?>"
               class="text-decoration-none fw-bold text-dark">Nom d'utilisateur</a>
          </th>
          <th scope="col">
            <a href="index.php?component=users&tri=email&users=<?= $page ?>"
               class="text-decoration-none fw-bold text-dark">Email</a>
          </th>
          <th scope="col">
            <a href="index.php?component=users&tri=role&users=<?= $page ?>"
               class="text-decoration-none fw-bold text-dark">Rôle</a>
          </th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($posts as $post): ?>
          <tr>
            <td><?= htmlspecialchars($post['username'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?= htmlspecialchars($post['email'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td><?= htmlspecialchars($post['role'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td>
              <a href="index.php?component=user&id=<?= $post['id']; ?>"
                 class="btn btn-warning btn-sm me-2">
                <i class="bi bi-pencil-square"></i> Modifier
              </a>
              <a href="index.php?component=users&id=<?= $post['id']; ?>"
                 class="btn btn-danger btn-sm" onclick="return confirm('Confirmer la suppression ?');">
                <i class="bi bi-trash"></i> Supprimer
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <nav aria-label="Navigation des pages" class="mt-4">
    <ul class="pagination justify-content-center">
      <?php if ($page > 1): ?>
        <li class="page-item">
          <a href="index.php?component=users&users=<?= $page - 1 ?>&tri=<?= htmlspecialchars($tri, ENT_QUOTES, 'UTF-8'); ?>"
             class="page-link">
            Précédent
          </a>
        </li>
      <?php endif; ?>

      <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <li class="page-item <?= $i == $page ? 'active' : '' ?>">
          <a href="index.php?component=users&users=<?= $i ?>&tri=<?= htmlspecialchars($tri, ENT_QUOTES, 'UTF-8'); ?>"
             class="page-link">
            <?= $i ?>
          </a>
        </li>
      <?php endfor; ?>

      <?php if ($page < $totalPages): ?>
        <li class="page-item">
          <a href="index.php?component=users&users=<?= $page + 1 ?>&tri=<?= htmlspecialchars($tri, ENT_QUOTES, 'UTF-8'); ?>"
             class="page-link">
            Suivant
          </a>
        </li>
      <?php endif; ?>
    </ul>
  </nav>

<?php else: ?>
  <p class="text-center text-muted fs-5">Aucun utilisateur trouvé.</p>
<?php endif; ?>



