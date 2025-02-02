<form action="index.php?component=panier" method="POST">
	<div class="container mt-5">
		<h1 class="text-center text-primary">Votre Panier</h1>

		<?php if (!empty($errorMessage)): ?>
			<div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
				<?= htmlspecialchars($errorMessage) ?>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		<?php endif; ?>

		<?php if (!empty($cartItems)): ?>
			<table class="table table-bordered table-striped table-hover">
				<thead class="thead-dark">
					<tr>
						<th>Images</th>
						<th>Article</th>
						<th>Quantité</th>
						<th>Prix Unitaire</th>
						<th>Total</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$totalPanier = 0;
					foreach ($cartItems as $item):
						// Vérification si une promotion est valide
						if (isset($item['pourcentage']) && $item['pourcentage'] > 0) {

							$prixUnitaire = $item['prix'] * (1 - $item['pourcentage'] / 100);
						} else {
							// Sinon, utiliser le prix original
							$prixUnitaire = $item['prix'];
						}

						$totalArticle = $prixUnitaire * $item['quantity'];
						$totalPanier += $totalArticle;
						?>
						<tr>
							<td>
								<img src="upload/<?= htmlspecialchars($item['image']) ?>"
									alt="Image de <?= htmlspecialchars($item['nom']) ?>" class="img-fluid rounded mx-auto d-block"
									style="max-width: 120px;">

							</td>
							<td><?= htmlspecialchars($item['nom']) ?></td>
							<td>
								<input type="number" name="quantity[<?= $item['id_article'] ?>]"
									value="<?= $item['quantity'] ?>" min="1" max="<?= $item['stock'] ?>"
									class="form-control w-50 mx-auto">
							</td>
							<td>
								<?php if (isset($item['pourcentage']) && $item['pourcentage'] > 0): ?>
									<del><?= number_format($item['prix'], 2) ?> €</del>
									<span class="text-success">
										<?= number_format($prixUnitaire, 2) ?> €
									</span>
								<?php else: ?>
									<?= number_format($item['prix'], 2) ?> €
								<?php endif; ?>
							</td>
							<td><?= number_format($totalArticle, 2) ?> €</td>
							<td class="text-center">
								<button type="submit" name="update[<?= $item['id_article'] ?>]"
									class="btn btn-warning btn-sm">
									<i class="bi bi-pencil-square"></i> Mettre à jour
								</button>
								<button type="submit" name="remove[<?= $item['id_article'] ?>]"
									class="btn btn-danger btn-sm"
									onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">
									<i class="bi bi-trash"></i> Supprimer
								</button>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

			<div class="text-center">
				<h3>Total du panier : <strong><?= number_format($totalPanier, 2) ?> €</strong></h3>
				<button type="submit" name="checkout" class="btn btn-success btn-lg mt-3">Passer à la
					commande
				</button>
			</div>
		<?php else: ?>
			<div class="alert alert-info text-center">
				Votre panier est vide. <a href="index.php" class="btn btn-link link">Retournez à la
					boutique</a>
			</div>
		<?php endif; ?>
	</div>
</form>

<!-- Validation JavaScript pour les quantités -->
<script>
	document.querySelectorAll('input[type="number"]').forEach(input => {
		input.addEventListener('change', function () {
			const min = parseInt(input.getAttribute('min'));
			const max = parseInt(input.getAttribute('max'));
			let value = parseInt(input.value);

			// Valider la valeur entrée
			if (value < min) {
				input.value = min;
			} else if (value > max) {
				input.value = max;
			}
		});
	});
</script>
