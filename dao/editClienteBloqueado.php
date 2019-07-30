<?php
//session_start();
$id=$_POST['id'];
$bloqueado=$_POST['bloqueado'];
try {
  include 'conexao.php';
  $pdo = getConnection();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  $stmt = $pdo->prepare('UPDATE cliente SET bloqueado=:bloqueado WHERE id=:id');
    $stmt->execute(array(
    ':bloqueado' =>$bloqueado,
    ':id'=>$id,
  ) 
); 

$msg = "Alterações efetuadas com sucesso!";
$redirect = "../index.php?msg=".$msg;
    
  echo $stmt->rowCount(); 

} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
    // $redirect = "novo.php?message=false";

}

header("location:$redirect");

?>


  