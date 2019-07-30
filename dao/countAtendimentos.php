<?php

try {
  function countAtendimentoConcluido ($idUsuario){
    include 'conexao.php';
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT COUNT(*) as cnt FROM atendimento WHERE idUsuario = $idUsuario AND situacao=1");
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}   
} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
    // $redirect = "novo.php?message=false";
}
try {
  function countAtendimentoPendente ($idUsuario){
    
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT COUNT(*) as cnt FROM atendimento WHERE idUsuario = $idUsuario AND situacao=2");
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
}   
} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
    // $redirect = "novo.php?message=false";
}

?>


  