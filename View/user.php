<?php

    checkPermission('manager');

    require "helper/formHelper.php";
?>

<form action="index.php?component=user&id=<?php echo $id; ?>" method="post" enctype="multipart/form-data" class="formulaire">

	<div class="container my-5">
		<div class="row justify-content-center">
			<div class="col-12 col-md-8 col-lg-6">
				<div class="card shadow-sm p-4 border-0 rounded-lg">
					<!-- Titre -->
					<h2 class="text-center mb-4 text-primary">Modifier les Informations</h2>

					<!-- Champ Nom d'utilisateur -->
                    <?php renderInputField('username', 'Nom d\'utilisateur', 'text', htmlspecialchars($article['username'] ?? '')); ?>

					<!-- Champ Email -->
                    <?php renderInputField('email', 'Email', 'email', htmlspecialchars($article['email'] ?? '')); ?>

					<!-- Champ Catégorie -->
					<div class="mb-4">
						<label for="role" class="form-label fw-bold">Catégorie</label>
						<select name="role" id="role" class="form-select shadow-sm border-secondary" required>
                            <?php foreach ($role as $roles): ?>
								<option value="<?php echo htmlspecialchars($roles); ?>"
                                    <?php echo (isset($article['role']) && $article['role'] == $roles) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($roles); ?>
								</option>
                            <?php endforeach; ?>
						</select>
						<div class="invalid-feedback">Veuillez sélectionner un rôle.</div> <!-- Validation message -->
					</div>

					<!-- Bouton Enregistrer -->
					<button type="submit" class="btn btn-primary w-100 shadow-sm">Enregistrer les modifications</button>
				</div>
			</div>
		</div>
	</div>
</form>

<!-- Validation en JavaScript -->
<script>
    // Validation côté client (facultatif, selon tes besoins)
    document.querySelector("form").addEventListener("submit", function (event) {
        let valid = true;

        // Vérification du champ 'role'
        const role = document.getElementById("role");
        if (!role.value) {
            role.classList.add("is-invalid");
            valid = false;
        } else {
            role.classList.remove("is-invalid");
        }

        if (!valid) {
            event.preventDefault();
        }
    });
</script>
