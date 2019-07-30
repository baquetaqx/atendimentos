<?php
try {
  function selectSubcategoria (){
    include 'conexao.php';
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT * FROM subcategoria ORDER BY idCategoria DESC");
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}   
} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
    // $redirect = "novo.php?message=false";
}
?>


  