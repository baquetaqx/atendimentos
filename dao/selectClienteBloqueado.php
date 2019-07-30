<?php
try {
  function selectClienteBloqueado (){
    $conn = getConnection();
    $stmt = $conn->prepare('SELECT * FROM cliente where bloqueado=1');
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}   
} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
    // $redirect = "novo.php?message=false";
}

?>


  