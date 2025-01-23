<?php require "Partial/securite.php"; ?>
<form action="" method="post" enctype="multipart/form-data" class="formulaire">
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-12 col-md-8 col-lg-6">
        <div class="card shadow-sm p-4 border-0 rounded-lg">
          <!-- Titre -->
          <h2 class="text-center mb-4 text-primary">Modifier les Informations</h2>

          <!-- Champ Nom d'utilisateur -->
          <div class="mb-4">
            <label for="username" class="form-label fw-bold">Nom d'utilisateur</label>
            <input type="text" name="username" id="username"
                   value="<?php echo htmlentities($article['username'] ?? ''); ?>"
                   class="form-control shadow-sm border-secondary" required
                   placeholder="Entrez votre nom d'utilisateur">
          </div>

          <!-- Champ Email -->
          <div class="mb-4">
            <label for="email" class="form-label fw-bold">Email</label>
            <input type="email" name="email" id="email"
                   value="<?php echo htmlentities($article['email'] ?? ''); ?>"
                   class="form-control shadow-sm border-secondary" required
                   placeholder="Entrez votre email">
          </div>

          <!-- Champ Catégorie -->
          <div class="mb-4">
            <label for="role" class="form-label fw-bold">Catégorie</label>
            <select name="role" id="role" class="form-select shadow-sm border-secondary" required>
              <?php foreach ($role as $roles): ?>
                <option value="<?php echo htmlentities($roles); ?>"
                        <?php echo (isset($article['role']) && $article['role'] == $roles) ? 'selected' : ''; ?>>
                  <?php echo htmlentities($roles); ?>
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
