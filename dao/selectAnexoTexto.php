<?php
function selectAnexoTexto ($id){
  try{
    $conn = getConnection();
    $stmt = $conn->prepare('select * from anexotexto where idConhecimento ='.$id.';' );
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
  } catch(PDOException $e) {

    echo 'Error: ' . $e->getMessage();
    // $redirect = "novo.php?message=false";
  }
}

?>


  