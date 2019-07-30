<?php
//session_start();
$id=$_POST['id'];
$cliente = $_POST['cliente'];
$dataAtendimento = $_POST['dataAtendimento'];
$problema = $_POST['problema'];
$solucao = $_POST['solucao'];
$situacao = $_POST['situacao'];
$observacao = $_POST['observacao'];

try {
  include 'conexao.php';
  $pdo = getConnection();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  $stmt = $pdo->prepare('UPDATE atendimento SET observacao=:observacao, situacao=:situacao WHERE id=:id');
    $stmt->execute(array(
    ':observacao' =>$observacao,
	  ':situacao'=>$situacao,
    ':id'=>$id,
  )); 
$msg = "Alterações efetuadas com sucesso!";
$redirect = "../listaAtendimentos.php?msg=".$msg;
    
  echo $stmt->rowCount(); 

} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
    // $redirect = "novo.php?message=false";

}

header("location:$redirect");

?>
