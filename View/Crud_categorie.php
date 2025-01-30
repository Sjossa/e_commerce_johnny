<?php
checkPermission('manager');
?>
  <div class="container mt-5">
    <h1 class="text-center text-primary mb-4">Gestion des catégories</h1>

    <h2>Ajouter une catégorie</h2>
    <form method="POST" action="index.php?component=Crud_categorie&AjoutCategorie">
      <div class="form-group">
        <input type="text" id="dd" placeholder="Entrez une nouvelle catégorie" name="nom"
          class="form-control mb-2">
      </div>
      <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>

    <!-- Liste des catégories -->
    <h2>Liste des catégories</h2>
    <table class="table table-bordered table-striped category-table">
      <thead class="thead-light">
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Nom</th>
          <th scope="col">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($categorie as $category): ?>
          <tr id="row-<?php echo $category['id_categorie']; ?>">
            <td><?php echo htmlspecialchars($category['id_categorie'], ENT_QUOTES, 'UTF-8'); ?></td>
            <td>
              <span
                class="category-name"><?php echo htmlspecialchars($category['nom'], ENT_QUOTES, 'UTF-8'); ?></span>
              <form method="POST" action="index.php?component=Crud_categorie&ModiCategorie" class="edit-form" style="display: none;">
  <input type="hidden" name="id_categorie" value="<?php echo $category['id_categorie']; ?>">
              <input name="nom" value="<?php echo htmlspecialchars($category['nom'], ENT_QUOTES, 'UTF-8'); ?>"
                class="form-control form-control-sm" required>
              <button type="submit" class="btn btn-success btn-sm mt-2">Enregistrer</button>
            </form>
            </td>



            <td>
              <button class="btn btn-warning btn-sm edit-btn">
                <i class="fas fa-edit"></i> Éditer
              </button>
              <a href="index.php?component=Crud_categorie&id_categorie=<?php echo htmlspecialchars($category['id_categorie'], ENT_QUOTES, 'UTF-8'); ?>"
                class="btn btn-danger btn-sm"
                onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette catégorie ?');">
                <i class="fas fa-trash"></i> Supprimer
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <!-- JavaScript natif -->
  <script>
    const editButtons = document.querySelectorAll('.edit-btn');

    editButtons.forEach(button => {
      button.addEventListener('click', (event) => {
        event.preventDefault();

        const row = button.closest('tr');
        const nameSpan = row.querySelector('.category-name');
        const editForm = row.querySelector('.edit-form');

        if (editForm.style.display === 'none') {
          nameSpan.style.display = 'none'; // Masquer le texte
          editForm.style.display = 'block'; // Afficher le formulaire
        } else {
          nameSpan.style.display = 'block'; // Réafficher le texte
          editForm.style.display = 'none'; // Masquer le formulaire
        }
      });
    });
  </script>

  <!-- Style additionnel -->
  <style>
    .edit-form {
      margin-top: 0.5rem;
    }
  </style>
</body>
