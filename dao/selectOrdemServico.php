<?php
  function selectOrdemServico(){
    try{
      include 'conexao.php';
      $conn = getConnection();
      $stmt = $conn->prepare("SELECT * FROM ordemdeservico ORDER BY id ASC");
      $stmt->execute();
      $result = $stmt->fetchAll();
      return $result;
  } catch(PDOException $e) {

    echo 'Error: ' . $e->getMessage();
    // $redirect = "novo.php?message=false";
  }
}

function selectOrdemServicoPorId($id){
  try{
    include 'conexao.php';
    $conn = getConnection();
    $stmt = $conn->prepare("SELECT * FROM ordemdeservico where id=$id");
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
} catch(PDOException $e) {

  echo 'Error: ' . $e->getMessage();
  // $redirect = "novo.php?message=false";
}
}

?>


  