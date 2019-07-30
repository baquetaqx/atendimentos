<?php
try {
  function selectCategoria (){
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


  