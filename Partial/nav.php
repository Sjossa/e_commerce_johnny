<style>
  /* Styles généraux pour le menu */
  .navbar {
    font-size: 1rem;
  }

  .navbar-brand {
    font-size: 1.25rem;
  }

  .nav-link {
    font-size: 1rem;
    transition: color 0.3s ease;
  }

  .nav-link:hover {
    color: #0d6efd;
    /* Bleu clair Bootstrap */
  }

  /* Bouton de recherche */
  .input-group .form-control {
    min-width: 250px;
    border-radius: 25px;
  }

  .input-group .btn {
    border-radius: 25px;
    font-size: 0.9rem;
  }

  /* Icône panier */
  .bi-bag {
    transition: transform 0.3s ease, color 0.3s ease;
  }

  .bi-bag:hover {
    transform: scale(1.2);
    color: #dc3545;
    /* Rouge Bootstrap */
  }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
  <div class="container-fluid">
    <!-- Logo -->
    <a href="index.php?component=home" class="navbar-brand fw-bold text-primary">Home</a>

    <!-- Bouton menu burger -->
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarMenu" aria-controls="navbarMenu" aria-expanded="false"
      aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu principal -->
    <div class="collapse navbar-collapse" id="navbarMenu">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <!-- Liens pour les rôles Manager/Admin -->
        <?php if (isset($_SESSION['role']) && ($_SESSION['role'] === 'manager' || $_SESSION['role'] === 'admin')): ?>
          <li class="nav-item">
            <a href="index.php?component=articles" class="nav-link text-primary fw-bold">Articles</a>
          </li>
          <li class="nav-item">
            <a href="index.php?component=users" class="nav-link text-primary fw-bold">Utilisateurs</a>
          </li>
        <?php endif; ?>
      </ul>

      <!-- Liens Connexion/Inscription ou Déconnexion -->
      <ul class="navbar-nav ms-3">
        <?php if (!isset($_SESSION['role']) || empty($_SESSION['role'])): ?>
          <li class="nav-item">
            <a href="index.php?component=login" class="nav-link text-primary fw-bold">Connexion</a>
          </li>
          <li class="nav-item">
            <a href="index.php?component=inscription"
              class="nav-link text-primary fw-bold">Inscription</a>
          </li>
        <?php else: ?>
          <ul class="navbar-nav ms-3">
          <li class="nav-item">
            <a href="index.php?component=articles_promotion"
              class="nav-link text-primary fw-bold">Promotion</a>
          </li>
        </ul>
          <li class="nav-item">
            <a href="Partial/deconexion.php" class="nav-link text-danger fw-bold">Déconnexion</a>
          </li>
        <?php endif; ?>
      </ul>

      <!-- Lien Promotion (uniquement pour les "customer") -->


      <!-- Barre de recherche -->
      <form class="d-flex ms-3" role="search">
        <div class="input-group">
          <input type="search" class="form-control rounded-pill shadow-sm" placeholder="Recherche"
            aria-label="Search">
          <button type="submit"
            class="btn btn-outline-primary rounded-pill shadow-sm ms-2">Rechercher</button>
        </div>
      </form>

      <!-- Icône Panier -->
      <a href="index.php?component=cart" class="bi bi-bag text-danger fs-4 ms-3"></a>
    </div>
  </div>
</nav>
