<form class="container mt-5" id="form-login" method="post">
	<h2 class="text-center mb-4 text-primary">Connexion</h2>
	
	<!-- Champ Email -->
	<div class="form-outline mb-4">
		<label for="email" class="form-label">Email</label>
		<input type="email" id="email" class="form-control" name="email" placeholder="Entrez votre email"
			   required aria-required="true" aria-label="Email" autocomplete="email"/>
	</div>
	
	<!-- Champ Mot de passe -->
	<div class="form-outline mb-4">
		<label for="password" class="form-label">Mot de passe</label>
		<input type="password" class="form-control" id="password" name="password"
			   placeholder="Entrez votre mot de passe"
			   required aria-required="true" aria-label="Mot de passe" autocomplete="current-password"/>
	</div>
	
	<!-- Bouton de connexion -->
	<div class="d-grid gap-2">
		<button type="submit" class="btn btn-primary btn-lg mb-4" id="connexion_button">Connexion</button>
	</div>
	
	
	<div class="text-center">
		<a href="#" class="text-decoration-none">Mot de passe oublié ?</a>
	</div>
</form>

<script>
    document.getElementById('form-login').addEventListener('submit', function (e) {
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        if (!email || !password) {
            e.preventDefault();
            alert('Veuillez remplir tous les champs.');
        }
    });
</script>
