<?php
try {
  function selectCliente (){
    $conn = getConnection();
    $stmt = $conn->prepare('SELECT * FROM cliente');
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}   
} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
    // $redirect = "novo.php?message=false";
}
try {
  function selectClienteById ($idCliente){
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT * FROM cliente WHERE id = $idCliente");
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}   
} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
    // $redirect = "novo.php?message=false";
}

?>


  