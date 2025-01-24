<form class="form-control" id="form-login" method="post">
  <!-- Champ Email -->
  <div data-mdb-input-init class="form-outline mb-4">
    <label for="email" class="form-label">Email</label>
    <input type="email" id="email" class="form-control" name="email" placeholder="email" required aria-required="true" aria-label="Email" />
  </div>

  <!-- Champ Mot de passe -->
  <div data-mdb-input-init class="form-outline mb-4">
    <label for="password" class="form-label">Mot de passe</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="password" required aria-required="true" aria-label="Mot de passe" />
  </div>

  <!-- Bouton de connexion -->
  <button type="submit" data-mdb-button-init data-mdb-ripple-init
    class="btn btn-primary btn-block mb-4" id="connexion_button">Connexion</button>
</form>
