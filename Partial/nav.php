<nav class="navbar navbar-expand-lg navbar-light bg-dark shadow-sm">
  <div class="container-fluid">
    <!-- Logo / Lien Home -->
    <a href="index.php?component=home" class="navbar-brand fw-bold text-primary link">Home</a>

    <!-- Bouton menu burger -->
    <button class="navbar-toggler border-0 text-danger" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false"
      aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu principal -->
    <div class="collapse navbar-collapse" id="navbarMenu">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <!-- Lien Promotion visible pour tous sauf Manager/Admin -->
        <?php if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['manager', 'admin'])): ?>
          <li class="nav-item">
            <a href="index.php?component=articles_promotion"
              class="nav-link text-primary fw-bold link">Promotion</a>
          </li>
        <?php endif; ?>

        <!-- Section pour Manager / Admin -->
        <?php if (isset($_SESSION['role']) && in_array($_SESSION['role'], ['manager', 'admin'])): ?>
          <li class="nav-item">
            <a href="index.php?component=articles"
              class="nav-link text-primary fw-bold link">Articles</a>
          </li>
          <li class="nav-item">
            <a href="index.php?component=users"
              class="nav-link text-primary fw-bold link">Utilisateurs</a>
          </li>
        <?php endif; ?>

        <!-- Section pour visiteurs non connectés -->
        <?php if (!isset($_SESSION['role']) || empty($_SESSION['role'])): ?>
          <li class="nav-item">
            <a href="index.php?component=login"
              class="nav-link text-primary fw-bold link">Connexion</a>
          </li>
          <li class="nav-item">
            <a href="index.php?component=inscription"
              class="nav-link text-primary fw-bold link">Inscription</a>
          </li>
        <?php elseif (isset($_SESSION['role']) && $_SESSION['role'] === 'customer'): ?>
          <!-- Section pour les utilisateurs connectés en tant que client -->
          <li class="nav-item">
            <a href="Partial/deconnexion.php" class="nav-link text-danger fw-bold">Profil</a>
          </li>
        <?php else: ?>
          <!-- Déconnexion -->
          <li class="nav-item">
            <a href="Partial/deconnexion.php"
              class="nav-link text-danger fw-bold">Déconnexion</a>
          </li>
        <?php endif; ?>
      </ul>

      <!-- Barre de recherche -->
      <form class="d-flex ms-3 "  id="form-article" role="search">
        <div class="input-group">
          

          <!-- Champ de recherche -->
          <input type="search" class="form-control rounded-pill shadow-sm Search-articles ms-2"
            placeholder="Recherchez des articles, produits, etc." id="search-article" aria-label="Recherchez">

          <!-- Bouton rechercher -->
          <button type="submit" class="btn btn-outline-primary rounded-pill shadow-sm ms-2">
            Rechercher
          </button>
        </div>
      </form>

      <!-- Icône Panier -->
      <a href="index.php?component=panier" class="bi bi-bag text-danger fs-4 ms-3 link"></a>
    </div>
  </div>
</nav>
