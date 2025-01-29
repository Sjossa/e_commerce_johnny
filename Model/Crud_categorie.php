<?php

function GetCategorie(PDO $pdo)
{
  $queryCategories = "SELECT * FROM categories";
  $stmt = $pdo->prepare($queryCategories);
  $stmt->execute();
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function AjoutCategorie(PDO $pdo, $categorie)
{
  if (!empty($categorie)) {
    try {
      $query = "INSERT INTO categories (nom) VALUES (:categorie)";
      $stmt = $pdo->prepare($query);
      $stmt->bindParam(':categorie', $categorie, PDO::PARAM_STR);
      $stmt->execute();
      echo "Catégorie ajoutée avec succès !";
    } catch (PDOException $e) {
      echo "Erreur lors de l'ajout de la catégorie : " . $e->getMessage();
    }
  } else {
    echo "Erreur : le nom de la catégorie ne peut pas être vide.";
  }
}

function DeleteCategorie(PDO $pdo, $id_categorie)
{
  if ($id_categorie) {
    // Vérification de l'existence de la catégorie
    $checkQuery = "SELECT COUNT(*) FROM categories WHERE id_categorie = :id";
    $stmt = $pdo->prepare($checkQuery);
    $stmt->bindValue(':id', $id_categorie, PDO::PARAM_INT);
    $stmt->execute();
    $categorieExists = $stmt->fetchColumn();

    if ($categorieExists) {
      // Suppression de la catégorie si elle existe
      $query = "DELETE FROM categories WHERE id_categorie = :id";
      $stmt = $pdo->prepare($query);
      $stmt->bindValue(':id', $id_categorie, PDO::PARAM_INT);
      $stmt->execute();
      echo "Catégorie supprimée avec succès.";
    } else {
      echo "Erreur : La catégorie avec l'ID $id_categorie n'existe pas.";
    }
  } else {
    echo "Erreur : L'ID de la catégorie est invalide.";
  }
}

function ModiCategorie(PDO $pdo, $id_categorie, $nom)
{
  if ($id_categorie && !empty($nom)) {
    try {
      $checkQuery = "SELECT COUNT(*) FROM categories WHERE id_categorie = :id";
      $stmt = $pdo->prepare($checkQuery);
      $stmt->bindValue(':id', $id_categorie, PDO::PARAM_INT);
      $stmt->execute();
      $categorieExists = $stmt->fetchColumn();

      if ($categorieExists) {
        $query = "UPDATE categories SET nom = :nom WHERE id_categorie = :id";
        $stmt = $pdo->prepare($query);
        $stmt->bindValue(':nom', $nom, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id_categorie, PDO::PARAM_INT);
        $stmt->execute();
        echo "Catégorie mise à jour avec succès.";
      } else {
        echo "Erreur : La catégorie avec l'ID $id_categorie n'existe pas.";
      }
    } catch (PDOException $e) {
      echo "Erreur lors de la mise à jour de la catégorie : " . $e->getMessage();
    }
  } else {
    echo "Erreur : L'ID de la catégorie ou le nom est invalide.";
  }
}
