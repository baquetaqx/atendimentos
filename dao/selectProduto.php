<?php

try {
  function selectProduto(){
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT * FROM produto");
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
  }   
} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
    // $redirect = "novo.php?message=false";
}

try {
  function selectProdutoPorId($id){
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT * FROM produto WHERE id=$id");
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
  }   
} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
    // $redirect = "novo.php?message=false";
}

?>


  