<?php

  function selectAnexos ($idConhecimento){
    
  try{
  $conn = getConnection();
  $stmt = $conn->prepare('select * from anexos where idConhecimento ='.$idConhecimento.';' );
  $stmt->execute();
  $result = $stmt->fetchAll();
  return $result;
  } catch(PDOException $e) {
    
  echo 'Error: ' . $e->getMessage();
    // $redirect = "novo.php?message=false";
}
}

?>


  