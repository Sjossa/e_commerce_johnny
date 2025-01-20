<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
  <div class="container-fluid">
    <!-- Logo ou Home -->
    <a href="index.php?component=home" class="navbar-brand fw-bold text-primary">Home</a>

    <!-- Bouton pour le menu burger -->
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
      aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Contenu du menu -->
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <!-- CRUD pour Manager/Admin -->
        <?php if (isset($_SESSION['role']) && ($_SESSION['role'] === 'manager' || $_SESSION['role'] === 'admin')): ?>
          <li class="nav-item">
            <a class="nav-link text-primary fw-bold" href="index.php?component=articles">Articles</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-primary fw-bold" href="index.php?component=users">users</a>
          </li>
        <?php endif; ?>
      </ul>

      <!-- Liens Connexion/Inscription ou Déconnexion -->
      <ul class="navbar-nav ms-3">
        <?php if (!isset($_SESSION['role']) || empty($_SESSION['role'])): ?>
          <li class="nav-item">
            <a class="nav-link text-primary fw-bold" href="index.php?component=login">Connexion</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-primary fw-bold"
              href="index.php?component=inscription">Inscription</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link text-danger fw-bold" href="Partial/deconexion.php">Déconnexion</a>
          </li>
        <?php endif; ?>
      </ul>


        <form class="d-flex ms-3 form-Articles" role="search">
          <div class="input-group">
            <input class="form-control rounded-pill border-0 shadow-sm Search-articles" type="search"
              placeholder="Recherche" aria-label="Search">
            <button class="btn btn-outline-primary rounded-pill shadow-sm ms-2"
              type="submit">Recherche</button>
          </div>


    </div>
  </form>
        </form>


      <!-- Icône Panier -->
      <a class="bi bi-bag text-danger fs-4 ms-3" href="index.php?component=cart"></a>
    </div>
  </div>
</nav>
