
<?php


  function getNom($pdo)
  {
    $query = "SELECT * FROM articles";
    $result = $pdo->query($query);
  return $result->fetchAll(PDO::FETCH_ASSOC);


}




?>

