<?php
//session_start();
$id = $_POST['idConhecimento'];
$nome = $_POST['nome'];

try {
  include 'conexao.php';
  $pdo = getConnection();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  $stmt = $pdo->prepare('UPDATE conhecimento SET nome=:nome WHERE id=:id');
    $stmt->execute(array(
    ':nome' =>$nome,
    ':id'=>$id,
  ) 
); 
$msg = "Alterações efetuadas com sucesso!";
$redirect = "../conhecimento.php?msg=".$msg;
    
  echo $stmt->rowCount(); 

} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
    // $redirect = "novo.php?message=false";

}

header("location:$redirect");

?>


  