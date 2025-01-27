<form action="" method="POST">
  <div class="container mt-5">
    <div class="row">
      <!-- Image de l'article -->
      <div class="col-md-3">
        <img src="upload/<?= htmlspecialchars($article['image']) ?>" alt="Image de l'article"
          class="img-fluid d-block mx-auto img-thumbnail" style="max-width: 200px;">
      </div>

      <!-- Détails du produit -->
      <div class="col-md-6 product-details">
        <h1><?= htmlentities($article['nom'] ?? '') ?></h1>

        <?php if (isset($article['prix'])): ?>
          <div class="price">
            <?php
            if (isset($article['pourcentage']) && $article['pourcentage'] > 0) {
              echo '<p class="old-price" style="text-decoration: line-through;">'
                . htmlspecialchars($article['prix'], ENT_QUOTES, 'UTF-8')
                . ' €</p>';
              $prixReduit = $article['prix'] * (1 - $article['pourcentage'] / 100);
              echo '<p class="new-price">' . htmlspecialchars($prixReduit, ENT_QUOTES, 'UTF-8') . ' €</p>';
            } else {
              echo '<p class="current-price">' . htmlspecialchars($article['prix'], ENT_QUOTES, 'UTF-8') . ' €</p>';
            }
            ?>
          </div>
        <?php else: ?>
          <p class="error">Erreur : aucun prix spécifié.</p>
        <?php endif; ?>

        <!-- Description du produit -->
        <p class="product-description">
          <?= htmlentities($article['description'] ?? '') ?>
        </p>

        <!-- Quantité -->
        <div class="d-flex align-items-center mt-4">
          <label for="quantity" class="h5 mb-0">Quantité:</label>
          <input type="number" class="form-control w-25 ms-3" id="quantity" name="quantity"
            value="1" min="1" max="<?= htmlspecialchars($article['stock']) ?>" required>
        </div>

        <!-- Bouton Ajouter au panier -->
        <div class="d-flex mt-4">
          <button type="submit" class="btn btn-primary-custom me-3" id="add-to-cart-btn"
            name="add_to_cart" value="<?= htmlspecialchars($article['id_article']) ?>">
            Ajouter au panier
          </button>
        </div>
      </div>
    </div>
  </div>
</form>

<script>
  document.getElementById("add-to-cart-btn").addEventListener("click", function (event) {
    const quantity = document.getElementById("quantity").value;
    if (quantity <= 0) {
      alert("La quantité doit être supérieure à zéro.");
      event.preventDefault();
    }
  });
</script>
