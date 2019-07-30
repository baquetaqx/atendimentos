<?php
session_start();

$usuario = $_SESSION['idusuario'];
$cliente = $_POST['idCliente'];
$dataAtendimento = $_POST['dataAtendimento'];
$horaInicio = $_POST['horaEntrada'];
$horaFinal = $_POST['horaSaida'];
$situacao = $_POST['situacao'];
$categoria = $_POST['categoria'];
$subcategoria = $_POST['subcategoria'];
$problema = $_POST['problema'];
$solucao = $_POST['solucao'];
$observacao = $_POST['observacao'];

echo $usuario;
try {
  include 'conexao.php';
  $pdo = getConnection();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  $stmt = $pdo->prepare('INSERT INTO atendimento (idCliente, idUsuario, dataAtendimento, horaInicio, horaFinal, situacao, categoria, subcategoria, descProblema, descSolucao, observacao) VALUES (:idCliente, :idUsuario, :dataAtendimento, :horaInicio, :horaFinal, :situacao, :categoria, :subcategoria, :descProblema, :descSolucao, :observacao)');
    $stmt->execute(array(
    ':idCliente' =>$cliente,
    ':dataAtendimento' =>$dataAtendimento,
    ':horaInicio'=>$horaInicio,
    ':horaFinal'=>$horaFinal,
    ':situacao' =>$situacao,
    ':categoria' =>$categoria,
    ':subcategoria' =>$subcategoria,
    ':descProblema' =>$problema,
    ':descSolucao' =>$solucao,
    ':idUsuario'=>$usuario,
    ':observacao'=>$observacao,
  ) 
);

$msg = "Atendimento Cadastrado Com Sucesso!";
$redirect = "../cadastroAtendimento.php?msg=".$msg;
    
  echo $stmt->rowCount(); 

} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
}

header("location:$redirect");

?>


  