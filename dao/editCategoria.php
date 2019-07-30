<?php
//session_start();
$id=$_POST['id'];
$nome = $_POST['nome'];
$situacao = $_POST['situacao'];

try {
  include 'conexao.php';
  $pdo = getConnection();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  $stmt = $pdo->prepare('UPDATE categoria SET nome=:nome, situacao=:situacao WHERE id=:id');
    $stmt->execute(array(
    ':nome' =>$nome,
    ':situacao' =>$situacao,
    ':id'=>$id,
  ) 
); 
$msg = "Alterações efetuadas com sucesso!";
$redirect = "../listaCategoria.php?msg=".$msg;
    
  echo $stmt->rowCount(); 

} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
    // $redirect = "novo.php?message=false";

}

header("location:$redirect");

?>


  