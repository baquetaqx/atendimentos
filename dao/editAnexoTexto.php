<?php
//session_start();
$id=$_POST['id'];
$idConhecimento=$_GET['id'];
$nomeConhecimento=$_GET['nomeConhecimento'];
$editor=$_POST['editor'];

try {
  include 'conexao.php';
  $pdo = getConnection();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  $stmt = $pdo->prepare('UPDATE anexotexto SET editor=:editor WHERE id=:id');
    $stmt->execute(array(
    ':editor' =>$editor,
    ':id'=>$id,
  ) 
); 
$msg = "Alterações efetuadas com sucesso!";
$redirect = "../anexoTexto.php?id=".$idConhecimento."&msg=".$msg."&nomeConhecimento=".$nomeConhecimento;
    
  echo $stmt->rowCount(); 

} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
    // $redirect = "novo.php?message=false";

}

header("location:$redirect");

?>


  