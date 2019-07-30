<?php
try {
  function selectConhecimento(){
  include 'conexao.php';
  $conn = getConnection();
  $stmt = $conn->prepare('SELECT * FROM conhecimento');
  $stmt->execute();
  $result = $stmt->fetchAll();
  return $result;
}   
} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
    // $redirect = "novo.php?message=false";
}

try {
    function selectUsuariosById($id){
      $conn = getConnection();
      $stmt = $conn->prepare("SELECT * FROM usuario where id=$id");
      $stmt->execute();
      $result = $stmt->fetchAll();
      return $result;
    }   
} catch(PDOException $e) {
    echo 'Error: ' . $e->getMessage();
  }

?>


  