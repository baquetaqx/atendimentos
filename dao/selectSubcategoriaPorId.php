<?php
try {
  function selectSubcategoriaPorId ($idSubcategoria){
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT * FROM subcategoria WHERE id = $idSubcategoria");
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}   
} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
    // $redirect = "novo.php?message=false";
}

?>


  