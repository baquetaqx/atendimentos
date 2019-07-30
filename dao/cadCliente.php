<?php
//session_start();
$nomeFantasia = $_POST['nomeFantasia'];
$endereco = $_POST['endereco'];
$bairro = $_POST['bairro'];
$cep = $_POST['cep'];
$numero = $_POST['numero'];
$cidade = $_POST['cidade'];
$telefone1 = $_POST['telefone1'];
$telefone2 = $_POST['telefone2'];
$razaoSocial = $_POST['razaoSocial'];
$cpfCnpj = $_POST['cpfCnpj'];
$situacao = $_POST['situacao'];
$observacao = $_POST['observacao'];

try {
  include 'conexao.php';
  $pdo = getConnection();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  $stmt = $pdo->prepare('INSERT INTO cliente (nomeFantasia, endereco, bairro, cep, numero, cidade, telefone1, telefone2, razaoSocial, cpfCnpj, situacao, observacao, bloqueado) VALUES (:nomeFantasia, :endereco, :bairro, :cep, :numero, :cidade, :telefone1, :telefone2, :razaoSocial, :cpfCnpj, :situacao, :observacao, 2)');
    $stmt->execute(array(
    ':nomeFantasia' =>$nomeFantasia,
    ':endereco' =>$endereco,
    ':bairro'=>$bairro,
    ':cep'=>$cep,
    ':numero'=>$numero,
    ':cidade' =>$cidade,
    ':telefone1' =>$telefone1,
    ':telefone2' =>$telefone2,
    ':razaoSocial' =>$razaoSocial,
    ':cpfCnpj' =>$cpfCnpj,
    ':situacao' =>$situacao,
    ':observacao'=>$observacao,
  ) 
); 
$msg = "Cadastro efetuado com sucesso!";
$redirect = "../cadastroCliente.php?msg=".$msg;
    
  echo $stmt->rowCount(); 

} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
    // $redirect = "novo.php?message=false";

}

header("location:$redirect");

?>


  