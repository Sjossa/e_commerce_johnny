

# 📦 e_commerce

## ⚙️ Configuration du projet

### 1. **Installation des Dépendances**

Ce projet utilise **Composer** pour gérer ses dépendances. Pour installer toutes les dépendances nécessaires, exécutez la commande suivante dans le dossier du projet :

```bash
composer install
```

Cela installera les dépendances et garantira que tous les développeurs utilisent la même version des librairies, grâce aux fichiers `composer.lock` et `composer.json`.

Le projet utilise notamment **Faker** pour générer des données fictives.

### 2. **Mise à Jour des Dépendances**

Pour mettre à jour **Faker** ou toute autre dépendance, exécutez la commande suivante :

```bash
composer update fakerphp/faker
```

Cela mettra à jour la version de Faker dans les fichiers `composer.json` et `composer.lock`. Après la mise à jour, tous les autres utilisateurs devront exécuter `composer install` pour obtenir la nouvelle version des dépendances.

### 3. **Problèmes de Version**

Si vous rencontrez des problèmes de version après avoir cloné le projet, assurez-vous que votre version de Composer est à jour et que vous avez exécuté `composer install` dans le répertoire du projet.

En cas de problème persistant, vous pouvez me contacter à l'adresse suivante : **johnny.sass2001@gmail.com**.

---

### 4. **Configuration de la Base de Données**

1. **Importez** le fichier SQL `e_commerce.sql` dans votre base de données.
2. **Créez un fichier `BDD.php`** dans le dossier `config` et entrez le code suivant :

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

3. **Renommez** le fichier `.env.example` en `.env`.
4. **Complétez** les informations nécessaires pour la connexion à la base de données dans le fichier `.env`.

---

#### Configuration Locale

Si vous souhaitez générer des données dans une autre langue, configurez Faker dans le fichier `fixture.php` comme suit :

```php
$faker = Faker\Factory::create('fr_FR');
```

Cela générera des données en français. Vous pouvez aussi utiliser d'autres codes de langue pour générer des données dans d'autres langues.

---

### 5. **Génération des Données via `fixture.php`**

Une fois la base de données configurée, vous pouvez générer des données en utilisant le fichier `fixture.php`. Vous avez deux méthodes pour l'exécuter : via la ligne de commande ou un navigateur.

#### 5.1 Accès via ligne de commande

- **Assurez-vous** que vous êtes dans le dossier du projet `e_commerce`.
- **Ouvrez** votre terminal et déplacez-vous dans le dossier `helper` :

  ```bash
  cd helper
  ```

- **Exécutez** le fichier avec la commande suivante :

  ```bash
  php fixture.php
  ```

#### 5.2 Accès via l'URL

Si vous préférez exécuter `fixture.php` via un navigateur, assurez-vous d'être dans le répertoire racine du projet et accédez à l'URL suivante :

```
http://localhost/e_commerce/helper/fixture.php
```

Une fois les données générées, vous serez redirigé vers la page principale.

---

## 🎯 Objectifs du Projet

- **Créer une plateforme e-commerce** avec gestion des utilisateurs et des produits.
- **Générer des données fictives** pour tester les fonctionnalités de l'application.
- **Gérer les dépendances** du projet avec Composer pour assurer une installation cohérente.

---

## 📄 Licence

Ce projet est sous licence MIT. Consultez le fichier `LICENSE` pour plus de détails.


