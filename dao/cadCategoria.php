<?php
//session_start();
$nome = $_POST['nome'];
$situacao = $_POST['situacao'];

try {
  include 'conexao.php';
  $pdo = getConnection();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  $stmt = $pdo->prepare('INSERT INTO categoria (nome, situacao) VALUES (:nome, :situacao)');
    $stmt->execute(array(
    ':nome' =>$nome,
    ':situacao' =>$situacao,
  ) 
); 
$msg = "Cadastro efetuado com sucesso!";
$redirect = "../cadastroCategoria.php?msg=".$msg;
    
  echo $stmt->rowCount(); 

} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
}

header("location:$redirect");

?>


  