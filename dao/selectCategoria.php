<?php
try {
  function selectCategoria (){
    include 'conexao.php';
    $conn = getConnection();
    $stmt = $conn->prepare('SELECT * FROM categoria');
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}   
} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
    // $redirect = "novo.php?message=false";
}
?>


  