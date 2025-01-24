<?php
require "Partial/securite.php";
require "helper/formHelper.php";

if (!isset($article) || !isset($role)) {
    echo "Les données nécessaires ne sont pas définies.";
    exit;
}
?>

<form action="" method="post" enctype="multipart/form-data" class="formulaire">
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
          </div>

          <!-- Bouton Enregistrer -->
          <button type="submit" class="btn btn-primary w-100 shadow-sm">Enregistrer les modifications</button>
        </div>
      </div>
    </div>
  </div>
</form>
