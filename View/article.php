<?php
if (isset($_GET["create"])) {
  echo '<h1 class="text-center mb-4">Ajoute</h1>';
} else {
  echo '<h1 class="text-center mb-4">Modifier</h1>';
}
?>
<div><a href="index.php?component=articles" class="link text-decoration-none text-primary">
    Retour <i class="bi bi-arrow-left-square-fill"></i>
</a></div>
<form action="" method="post" enctype="multipart/form-data">
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-12 col-md-8 col-lg-6">
        <div class="card shadow-sm p-4">
          <!-- Formulaire -->
          <div class="mb-4">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" id="nom"
                   value="<?php echo isset($article['nom']) ? htmlentities($article['nom']) : ''; ?>"
                   class="form-control" placeholder="Nom de l'article" required>
          </div>
          <div class="mb-4">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="3"
                      placeholder="Description de l'article" required>
                            <?php echo isset($article['description']) ? htmlentities($article['description']) : ''; ?>
            </textarea>
          </div>
          <div class="mb-4">
            <label for="image" class="form-label">Image</label>
            <input type="file" name="image" id="image" class="form-control"
                   <?php echo !empty($article['image']) ? '' : 'required'; ?>>
            <?php if (!empty($article['image'])): ?>
              <small class="form-text text-muted">Fichier actuel :
                <?php echo htmlentities($article['image']); ?></small>
            <?php endif; ?>
          </div>
          <div class="mb-4">
            <label for="prix" class="form-label">Prix</label>
            <input type="number" step="0.01" name="prix" id="prix" class="form-control"
                   placeholder="Prix en euros"
                   value="<?php echo isset($article['prix']) ? htmlentities($article['prix']) : ''; ?>"
                   required>
          </div>
          <div class="mb-4">
            <label for="stock" class="form-label">Stock</label>
            <input type="number" name="stock" id="stock" class="form-control"
                   placeholder="Quantité en stock"
                   value="<?php echo isset($article['stock']) ? htmlentities($article['stock']) : ''; ?>"
                   required>
          </div>
          <div class="mb-4">
            <label for="id_categorie" class="form-label">Catégorie</label>
            <select name="id_categorie" id="id_categorie" class="form-select" required>
              <?php foreach ($categories as $categorie): ?>
                <option value="<?php echo htmlentities($categorie['id_categorie']); ?>"
                        <?php echo (isset($article['id_categorie']) && $article['id_categorie'] == $categorie['id_categorie']) ? 'selected' : ''; ?>>
                  <?php echo htmlentities($categorie['nom']); ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
          <!-- Bouton Enregistrer -->
          <button type="submit" class="btn btn-primary w-100">Enregistrer l'article</button>
        </div>
      </div>
    </div>
  </div>
</form>
