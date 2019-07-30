<?php
try {
  function selectCategoriaPorId ($idCategoria){
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT * FROM categoria WHERE id = $idCategoria");
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}   
} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
    // $redirect = "novo.php?message=false";
}

?>


  