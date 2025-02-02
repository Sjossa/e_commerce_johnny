<?php
checkPermission('manager');

$isCreating = isset($_GET['create']);
$title = $isCreating ? 'Ajout d’un article' : 'Modification de l’article';
?>

<div class="container my-5">

  <h1 class="text-center mb-5"><?= htmlentities($title) ?></h1>


  <div class="mb-4 text-start">
    <a href="index.php?component=articles" class="link text-decoration-none text-primary">
      <i class="bi bi-arrow-left-square-fill me-1 link"></i>Retour
    </a>
  </div>


  <?php if (!$isCreating): ?>
    <form
      action="index.php?component=article&id_article=<?= htmlspecialchars($article['id_article']) ?>&new_promotion"
      method="post" class="mb-5 shadow-sm p-4 rounded border">
      <h5 class="mb-4">Ajouter une nouvelle promotion</h5>
      <div class="mb-3">
        <label for="new-promotion" class="form-label">Nouvelle promotion (%)</label>
        <input type="number" name="new_promotion" id="new-promotion" class="form-control"
          placeholder="Entrez un pourcentage de réduction" min="0" max="100" required>
      </div>
      <button type="submit" class="btn btn-outline-primary w-100">Ajouter</button>
    </form>
  <?php endif; ?>

  <!-- Formulaire principal -->
  <form action="" method="post" enctype="multipart/form-data" class="shadow-sm p-5 rounded border">
    <h5 class="text-center mb-4">Détails de l'article</h5>

     <?php if (!$isCreating): ?>
    <div class="mb-4 text-center">
      <img
        src="upload/<?= isset($article['image']) && $article['image'] ? htmlspecialchars($article['image']) : 'default.jpg' ?>"
        alt="<?= htmlentities($article['description'] ?? '') ?>" class="img-fluid d-block mx-auto max-width-200 img-thumbnail">
    </div>
<?php endif; ?>
    <!-- Nom -->
    <div class="mb-4">
      <label for="nom" class="form-label">Nom</label>
      <input type="text" name="nom" id="nom" value="<?= htmlentities($article['nom'] ?? '') ?>"
        class="form-control" placeholder="Nom de l'article" required>
    </div>
<!-- Image -->
    <div class="mb-4">
      <label for="image" class="form-label">Sélectionnez une image :</label>
      <input type="file" name="image" id="image" class="form-control">
    </div>
    <!-- Description -->
    <div class="mb-4">
      <label for="description" class="form-label">Description</label>
      <textarea name="description" id="description" class="form-control" rows="3"
        placeholder="Description de l'article"
        required><?= htmlentities($article['description'] ?? '') ?></textarea>
    </div>

    <!-- Prix -->
    <div class="mb-4">
      <label for="prix" class="form-label">Prix</label>
      <input type="number" step="0.01" name="prix" id="prix" class="form-control"
        value="<?= htmlentities($article['prix'] ?? '') ?>" placeholder="Prix en euros" required>
    </div>

    <!-- Promotion -->
    <div class="mb-4">
      <label for="promotion" class="form-label">Promotion (%)</label>
      <select name="promotion" id="promotion" class="form-select">
        <option value="" <?= isset($article['id_promotion']) && $article['id_promotion'] == 0 ? 'selected' : '' ?>>
          Pas de promotion
        </option>
        <?php foreach ($promotion as $promo): ?>
          <option value="<?= $promo['id_promotion'] ?>" <?= isset($article['id_promotion']) && $promo['id_promotion'] == $article['id_promotion'] ? 'selected' : '' ?>>
            <?= htmlentities($promo['discount_percentage']) ?>%
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Stock -->
    <div class="mb-4">
      <label for="stock" class="form-label">Stock</label>
      <input type="number" name="stock" id="stock" class="form-control"
        value="<?= htmlentities($article['stock'] ?? '') ?>" placeholder="Quantité en stock"
        required>
    </div>

    <!-- Catégorie -->
    <div class="mb-4">
      <label for="id_categorie" class="form-label">Catégorie</label>
      <select name="id_categorie" id="id_categorie" class="form-select" required>
        <?php foreach ($categories as $categorie): ?>
          <option value="<?= htmlentities($categorie['id_categorie']) ?>"
            <?= isset($article['id_categorie']) && $article['id_categorie'] == $categorie['id_categorie'] ? 'selected' : '' ?>>
            <?= htmlentities($categorie['nom']) ?>
          </option>
        <?php endforeach; ?>
      </select>
    </div>

    <!-- Bouton d'enregistrement -->
    <button type="submit" class="btn btn-primary w-100">Enregistrer l’article</button>
  </form>
</div>

<style>
  .max-width-200 {
    max-width: 200px;
  }
</style>
