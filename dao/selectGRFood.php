<?php
try {
  function selectGRFood(){
  include 'conexao.php';
  $conn = getConnection();
  $stmt = $conn->prepare("SELECT * FROM grfood");
  $stmt->execute();
  $result = $stmt->fetchAll();
  return $result;
}   
} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
    // $redirect = "novo.php?message=false";
}

?>


  