<?php
session_start();

$idCliente = $_POST['idCliente'];
$dataLancamento = $_POST['dataAtendimento'];
$horaEntrada = $_POST['horaEntrada'];
$horaSaida = $_POST['horaSaida'];
$tipoAtendimento = $_POST['tipoAtendimento'];
$software = $_POST['software'];
$situacao = $_POST['situacao'];
$ocorrencia = nl2br($_POST['ocorrencia']);
$observacoes = nl2br($_POST['observacoes']);
$solucao =nl2br($_POST['solucao']);
$idUsuario = $_SESSION['idusuario'];

try {
  include 'conexao.php';
  $pdo = getConnection();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  $stmt = $pdo->prepare("INSERT INTO ordemdeservico (idCliente, dataLancamento, horaEntrada, horaSaida, tipoAtendimento, software, situacao, ocorrencia, observacoes, solucao, idUsuario)
   VALUES (:idCliente, :dataLancamento, :horaEntrada, :horaSaida, :tipoAtendimento, :software, :situacao, :ocorrencia, :observacoes, :solucao, :idUsuario)");
    $stmt->execute(array(
    ':idCliente' =>$idCliente,
    ':dataLancamento' =>$dataLancamento,
    ':horaEntrada' => $horaEntrada,
    ':horaSaida' => $horaSaida,
    ':dataLancamento' =>$dataLancamento,
    ':tipoAtendimento' =>$tipoAtendimento,
    ':software' =>$software,
    ':situacao' =>$situacao,
    ':ocorrencia' =>$ocorrencia,
    ':observacoes' =>$observacoes,
    ':solucao' =>$solucao,
    ':idUsuario' =>$idUsuario,

  ) 
); 
    $lastid =  $pdo->lastInsertId();
    $redirect = "../anexoProdutos.php?id=".$lastid; 
    
  echo $stmt->rowCount(); 

} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
}

header("location:$redirect");

?>


  