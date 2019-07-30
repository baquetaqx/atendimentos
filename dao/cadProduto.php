<?php
//session_start();
$nome = $_POST['nome'];
$preco = $_POST['preco'];

try {
  include 'conexao.php';
  $pdo = getConnection();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  $stmt = $pdo->prepare('INSERT INTO produto (nome, preco) VALUES (:nome, :preco)');
    $stmt->execute(array(
    ':nome' =>$nome,
    ':preco' =>$preco,
  ) 
); 
$msg = "Cadastro efetuado com sucesso!";
$redirect = "../cadastroProduto.php?msg=".$msg;
    
  echo $stmt->rowCount(); 

} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
}

header("location:$redirect");

?>


  