<?php
//session_start();
$cliente = $_POST['nomeCliente'];
$cnpj = $_POST['cnpj'];
$registro = $_POST['registro'];
$versao = $_POST['versao'];
$expira = $_POST['expira'];
$chave = $_POST['chave'];

try {
  include 'conexao.php';
  $pdo = getConnection();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  $stmt = $pdo->prepare('INSERT INTO grfood (nomeCliente, cnpj, registro, versao, expira, chave) VALUES (:cliente, :cnpj, :registro, :versao, :expira, :chave)');
    $stmt->execute(array(
    ':cliente' =>$cliente,
    ':cnpj' =>$cnpj,
    ':registro' =>$registro,
    ':versao' =>$versao,
    ':expira' =>$expira,
    ':chave' =>$chave,
  ) 
); 
  
$redirect = "../grfood.php"; 
    
  echo $stmt->rowCount(); 

} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
}

header("location:$redirect");

?>


  