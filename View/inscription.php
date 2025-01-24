
<form method="post" action="index.php?component=inscription" onsubmit="return verification();">
  <div class="mb-3">
    <label for="username" class="form-label">Entrez votre nom</label>
    <input type="text" class="form-control" username" name="username" aria-describedby="username" required>
  </div>

  <div class="mb-3">
    <label for="email" class="form-label">Entrez votre adresse email</label>
    <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" required>
  </div>

  <div class="mb-3">
    <label for="password" class="form-label">Mot de passe</label>
    <input type="password" class="form-control" id="password" name="password" required>
  </div>

  <div class="mb-3">
    <label for="verifpassword" class="form-label">Confirmez votre mot de passe</label>
    <input type="password" class="form-control" id="verifpassword" name="verifpassword" required>
  </div>

  <button type="submit" class="btn btn-primary">Envoyer</button>
</form>

<script>
  function verification() {
    var password = document.getElementById("password").value;
    var confirmPassword = document.getElementById("verifpassword").value;

    if (password !== confirmPassword) {
      alert("Les mots de passe ne correspondent pas");
      return false;
    }
    return true;
  }
</script>
