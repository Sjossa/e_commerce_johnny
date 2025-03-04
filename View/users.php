<?php
checkPermission('manager') ?>

<?php if (!empty($posts)): ?>
	<!-- Tableau des utilisateurs -->
	<div class="table-responsive shadow-sm rounded">
		<table class="table table-striped table-bordered table-hover align-middle text-center">
			<thead class="table-primary">
				<tr>
					<?php foreach (['username' => 'Nom d\'utilisateur', 'email' => 'Email', 'role' => 'Rôle'] as $key => $label): ?>
						<th scope="col">
							<a href="index.php?component=users&tri=<?= htmlspecialchars($key, ENT_QUOTES, 'UTF-8') ?>&users=<?= htmlspecialchars($page, ENT_QUOTES, 'UTF-8') ?>"
								class="text-decoration-none fw-bold text-dark link">
								<?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8') ?>
							</a>
						</th>
					<?php endforeach; ?>
					<th scope="col">Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($posts as $post): ?>
					<tr>
						<?php foreach (['username', 'email', 'role'] as $key): ?>
							<td class="text-nowrap"><?= htmlspecialchars($post[$key], ENT_QUOTES, 'UTF-8'); ?></td>
						<?php endforeach; ?>
						<td>
							<a href="index.php?component=user&id=<?= htmlspecialchars($post['id'], ENT_QUOTES, 'UTF-8'); ?>"
								class="btn btn-warning btn-sm me-2 link">
								<i class="bi bi-pencil-square"></i> Modifier
							</a>
							<a href="index.php?component=users&id=<?= htmlspecialchars($post['id'], ENT_QUOTES, 'UTF-8'); ?>"
								class="btn btn-danger btn-sm link" onclick="return confirm('Confirmer la suppression ?');">
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
					<a href="index.php?component=users&users=<?= htmlspecialchars($page - 1, ENT_QUOTES, 'UTF-8'); ?>&tri=<?= htmlspecialchars($tri, ENT_QUOTES, 'UTF-8'); ?>"
						class="page-link link">
						<i class="bi bi-arrow-left-circle"></i> Précédent
					</a>
				</li>
			<?php endif; ?>

			<?php for ($i = 1; $i <= $totalPages; $i++): ?>
				<li class="page-item <?= $i == $page ? 'active' : '' ?>">
					<a href="index.php?component=users&users=<?= htmlspecialchars($i, ENT_QUOTES, 'UTF-8'); ?>&tri=<?= htmlspecialchars($tri, ENT_QUOTES, 'UTF-8'); ?>"
						class="page-link link">
						<?= htmlspecialchars($i, ENT_QUOTES, 'UTF-8'); ?>
					</a>
				</li>
			<?php endfor; ?>

			<?php if ($page < $totalPages): ?>
				<li class="page-item">
					<a href="index.php?component=users&users=<?= htmlspecialchars($page + 1, ENT_QUOTES, 'UTF-8'); ?>&tri=<?= htmlspecialchars($tri, ENT_QUOTES, 'UTF-8'); ?>"
						class="page-link link">
						<i class="bi bi-arrow-right-circle"></i> Suivant
					</a>
				</li>
			<?php endif; ?>


		</ul>
	</nav>
	<p class="text-center text-muted">Page <?= $page ?> sur <?= $totalPages ?></p>

<?php else: ?>
	<p class="text-center text-muted fs-5">Aucun utilisateur trouvé.</p>
<?php endif; ?>

