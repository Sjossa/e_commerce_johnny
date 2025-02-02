<h2>Résultats de recherche</h2>

<?php if (!empty($posts)): ?>
	<div class="row row-cols-1 row-cols-md-3 g-4">
		<?php foreach ($posts as $article): ?>
			<div class="col">
				<div class="card shadow-sm h-100 border-light rounded-3 hover-zoom">
					<div class="card-body">
						<h5 class="card-title"><?php echo htmlspecialchars($article['nom']); ?></h5>
						<p class="card-text"><?php echo htmlspecialchars($article['description']); ?></p>
						<div class="d-flex justify-content-between align-items-center">

							<!-- Bouton Détails avec toggle -->
							<a href="index.php?component=info_article&id_article=<?= htmlspecialchars($article['id_article']) ?>"
								class="btn btn-secondary btn-sm link">Détails
							</a>
						</div>
						<!-- Détails supplémentaires cachés -->
						<div id="details-<?php echo htmlspecialchars($article['id_article']); ?>"
							class="extra-details mt-2 d-none">
							<p>Plus d'informations sur l'article...</p>
							<!-- Tu peux ajouter ici des informations détaillées sur l'article -->
						</div>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
<?php else: ?>
	<p>Aucun article trouvé pour votre recherche. <a href="index.php" class="link">Retour à la page
			d'accueil</a></p>
<?php endif; ?>

<script>
	// Fonction de toggle pour afficher/masquer les détails de l'article
	function toogleUser(articleId) {
		const details = document.getElementById('details-' + articleId);
		details.classList.toggle('d-none');
	}
</script>

<!-- CSS personnalisé pour ajouter des effets -->
<style>
	/* Effet de zoom au survol de la carte */
	.hover-zoom:hover {
		transform: scale(1.05);
		transition: transform 0.3s ease-in-out;
	}

	/* Détails supplémentaires stylés */
	.extra-details {
		background-color: #f8f9fa;
		border: 1px solid #ddd;
		padding: 10px;
	}
</style>
