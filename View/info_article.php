<style>
  .product-img {
    max-width: 100%;
    border-radius: 5px;
  }

  .product-details {
    padding-top: 20px;
  }

  .product-description {
    font-size: 1.1rem;
    color: #555;
  }

  .btn-primary-custom {
    background-color: #007bff;
    border-color: #007bff;
  }

  .btn-primary-custom:hover {
    background-color: #0056b3;
    border-color: #004085;
  }

  .price {
    font-size: 1.5rem;
    font-weight: bold;
    color: #28a745;
  }
</style>

<body>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-3">
        <img src="upload/<?= htmlspecialchars($article['image']) ?>" alt="Image de l'article"
          class="img-fluid d-block mx-auto max-width-200 img-thumbnail">
      </div>
      <div class="col-md-6 product-details">
        <h1><?= htmlentities($article['nom'] ?? '') ?></h1>
        <p class="price"> <?= htmlentities($article['prix'] ?? '') ?>€</p>


        <!-- Description -->
        <p class="product-description">
          <?= htmlentities($article['description'] ?? '') ?>
        </p>

        <div class="d-flex align-items-center mt-4">
          <h5>Quantité:</h5>
          <input type="number" class="form-control w-25 ms-3" value="1" min="1"
            max="<?= htmlspecialchars($article['stock']) ?>">
        </div>

        <div class="d-flex mt-4">
          <button class="btn btn-primary-custom me-3" id="add-to-cart-btn">Ajouter au
            panier</button>
        </div>
      </div>
    </div>

    <!-- Section supplémentaire -->
    <div class="mt-5">
      <h3>Produits similaires</h3>
      <div class="row">
        <div class="col-md-4">
          <div class="card">
            <img src="https://via.placeholder.com/150" class="card-img-top" alt="Produit similaire">
            <div class="card-body">
              <h5 class="card-title">Produit B</h5>
              <p class="card-text">15,99 €</p>
              <a href="#" class="btn btn-outline-secondary">Voir</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <img src="https://via.placeholder.com/150" class="card-img-top" alt="Produit similaire">
            <div class="card-body">
              <h5 class="card-title">Produit C</h5>
              <p class="card-text">19,99 €</p>
              <a href="#" class="btn btn-outline-secondary">Voir</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <img src="https://via.placeholder.com/150" class="card-img-top" alt="Produit similaire">
            <div class="card-body">
              <h5 class="card-title">Produit D</h5>
              <p class="card-text">24,99 €</p>
              <a href="#" class="btn btn-outline-secondary">Voir</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
