<?php
//session_start();
$id=$_POST['id'];
$nomeFantasia = $_POST['nomeFantasia'];
$endereco = $_POST['endereco'];
$bairro=$_POST['bairro'];
$numero=$_POST['numero'];
$cep=$_POST['cep'];
$cidade = $_POST['cidade'];
$telefone1 = $_POST['telefone1'];
$telefone2 = $_POST['telefone2'];
$razaoSocial = $_POST['razaoSocial'];
$cpfCnpj = $_POST['cpfCnpj'];
$situacao = $_POST['situacao'];
$observacao=$_POST['observacao'];
$bloqueado = $_POST['bloqueado'];
try {
  include 'conexao.php';
  $pdo = getConnection();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  $stmt = $pdo->prepare('UPDATE cliente SET bloqueado=:bloqueado, nomeFantasia=:nomeFantasia, endereco=:endereco, bairro=:bairro, numero=:numero, cep=:cep, cidade=:cidade, telefone1=:telefone1, telefone2=:telefone2, razaoSocial=:razaoSocial, cpfCnpj=:cpfCnpj, situacao=:situacao, observacao=:observacao WHERE id=:id');
    $stmt->execute(array(
    ':bloqueado'=>$bloqueado,
    ':nomeFantasia' =>$nomeFantasia,
    ':endereco' =>$endereco,
    ':bairro' =>$bairro,
    ':numero' =>$numero,
    ':cep' =>$cep,
    ':cidade' =>$cidade,
    ':telefone1' =>$telefone1,
    ':telefone2' =>$telefone2,
    ':razaoSocial' =>$razaoSocial,
    ':cpfCnpj' =>$cpfCnpj,
    ':situacao' =>$situacao,
    ':observacao' =>$observacao,
    ':id'=>$id,
  ) 
); 

$msg = "Alterações efetuadas com sucesso!";
$redirect = "../listaClientes.php?msg=".$msg;
    
  echo $stmt->rowCount(); 

} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
    // $redirect = "novo.php?message=false";

}

header("location:$redirect");

?>


  