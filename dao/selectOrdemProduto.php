<?php
function selectOrdemProduto ($idOrdem){
  try{
    $conn = getConnection();
    $stmt = $conn->prepare('select * from ordem_produto where idOrdem ='.$idOrdem.';' );
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
  } catch(PDOException $e) {

    echo 'Error: ' . $e->getMessage();
    // $redirect = "novo.php?message=false";
  }
}

?>


  