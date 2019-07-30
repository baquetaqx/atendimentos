<?php

try {
  function countOSConcluido ($idUsuario){
   // include 'conexao.php';
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT COUNT(*) as cnt FROM ordemdeservico where situacao=1");
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}   
} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
    // $redirect = "novo.php?message=false";
}
try {
    function countOSPendente ($idUsuario){
      
      $conn = getConnection();
      $stmt = $conn->prepare("SELECT COUNT(*) as cnt FROM ordemdeservico WHERE situacao=2");
      $stmt->execute();
      $result = $stmt->fetchAll();
      return $result;
  }   
  } catch(PDOException $e) {
    echo 'Error: ' . $e->getMessage();
      // $redirect = "novo.php?message=false";
  }

?>


  