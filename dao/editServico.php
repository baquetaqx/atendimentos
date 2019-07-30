<?php
//session_start();
$id=$_POST['idServico'];
$situacao=$_POST['situacao'];
$ocorrencia = nl2br($_POST['ocorrencia']);
$solucao = nl2br($_POST['solucao']);
$observacoes = nl2br($_POST['observacoes']);

try {
  include 'conexao.php';
  $pdo = getConnection();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  $stmt = $pdo->prepare('UPDATE ordemdeservico SET observacoes=:observacoes, solucao=:solucao, ocorrencia=:ocorrencia, situacao=:situacao WHERE id=:id');
    $stmt->execute(array(
    ':observacoes' =>$observacoes,
    ':solucao'=>$solucao,
    ':ocorrencia'=>$ocorrencia,
    ':situacao'=>$situacao,
    ':id'=>$id,
  ) 
); 
$msg = "Alterações efetuadas com sucesso!";
$redirect = "../listaServicos.php?msg=".$msg;
    
  echo $stmt->rowCount(); 

} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
    // $redirect = "novo.php?message=false";

}

header("location:$redirect");

?>


  