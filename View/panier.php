<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mon Panier - Boutique</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
    rel="stylesheet">
  <style>
    .product-img {
      width: 80px;
      height: 80px;
      object-fit: cover;
    }

    .btn-remove {
      background-color: #dc3545;
      color: white;
    }

    .btn-remove:hover {
      background-color: #c82333;
    }

    .total-section {
      border-top: 1px solid #dee2e6;
      margin-top: 30px;
      padding-top: 15px;
    }

    .cart-item-row {
      align-items: center;
    }
  </style>
</head>

<body>
  <div class="container mt-5">
    <h2 class="mb-4 text-center">Votre Panier</h2>

    <!-- Table Panier -->
    <div class="row">
      <div class="col-12">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col">Image</th>
              <th scope="col">Produit</th>
              <th scope="col">Quantité</th>
              <th scope="col">Prix Unitaire</th>
              <th scope="col">Total</th>
              <th scope="col">Actions</th>
            </tr>
          </thead>
          <tbody>
            <!-- Produit A -->
            <tr class="cart-item-row">
              <td><img src="https://via.placeholder.com/80" alt="Produit A" class="product-img">
              </td>
              <td>Produit A</td>
              <td>
                <input type="number" class="form-control" value="1" min="1">
              </td>
              <td>15 €</td>
              <td>15 €</td>
              <td><button class="btn btn-remove btn-sm">Supprimer</button></td>
            </tr>
            <!-- Produit B -->
            <tr class="cart-item-row">
              <td><img src="https://via.placeholder.com/80" alt="Produit B" class="product-img">
              </td>
              <td>Produit B</td>
              <td>
                <input type="number" class="form-control" value="2" min="1">
              </td>
              <td>25 €</td>
              <td>50 €</td>
              <td><button class="btn btn-remove btn-sm">Supprimer</button></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Section Total -->
    <div class="total-section">
      <div class="row">
        <div class="col-12 d-flex justify-content-between">
          <h4>Total : </h4>
          <h4>65 €</h4>
        </div>
      </div>
      <div class="d-flex justify-content-between mt-3">
        <a href="index.html" class="btn btn-outline-secondary">Retour à la boutique</a>
        <a href="checkout.html" class="btn btn-primary">Passer à la caisse</a>
      </div>
    </div>
  </div>

  <script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
