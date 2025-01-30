Voici la version plus professionnelle et détaillée du fichier Markdown :

```markdown
# 📦 e_commerce

## ⚙️ Configuration du projet

Pour configurer le projet `e_commerce`, suivez les étapes ci-dessous :

1. **Importation de la base de données** :
   Importez le fichier SQL `e_commerce.sql` dans votre base de données.

2. **Création du fichier de configuration** :
   Créez un dossier `config` à la racine du projet. À l'intérieur, créez un fichier nommé `BDD.php` et entrez le code suivant pour établir la connexion à la base de données via PDO :
   ```php
   <?php
   // config/BDD.php

   try {
     $pdo = new PDO("mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}", $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
   } catch (Exception $e) {
     $errors[] = "Erreur de connexion à la BDD : {$e->getMessage()}";
   }
   ?>
   ```

3. **Renommage du fichier d'exemple** :
   Copiez le fichier `.env.example` et renommez-le en `.env`.

4. **Configuration de la connexion à la base de données** :
   Ouvrez le fichier `.env` et remplissez les informations nécessaires pour configurer la connexion à la base de données, notamment les paramètres suivants :
   - `DB_HOST` : L'adresse de votre serveur de base de données.
   - `DB_NAME` : Le nom de votre base de données.
   - `DB_USER` : Le nom d'utilisateur pour accéder à la base de données.
   - `DB_PASSWORD` : Le mot de passe associé à l'utilisateur.

5. **Génération des données** :
   Pour insérer des données de test dans la base de données, accédez à `fixture.php`. Vous pouvez le faire soit via un navigateur web, soit via la ligne de commande.

### 4.1 Accès via ligne de commande :

- **Vérifiez** que vous êtes dans le dossier du projet `e_commerce`.
- **Ouvrez** votre terminal et **déplacez-vous** dans le dossier `helper` :
  ```bash
  cd helper
  ```
- **Exécutez** le script `fixture.php` en tapant la commande suivante :
  ```bash
  php fixture.php
  ```

### 4.2 Accès via l'URL :

Si vous préférez accéder à `fixture.php` via un navigateur web, assurez-vous d'être dans le répertoire racine du projet et accédez à l'URL suivante :

```
http://localhost/e_commerce/helper/fixture.php
```

Après l'exécution de ce fichier, une redirection automatique vers la page principale se produira si les données ont été générées avec succès.
```


