<?php
//session_start();
$nome = $_POST['nome'];

try {
  include 'conexao.php';
  $pdo = getConnection();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  $stmt = $pdo->prepare('INSERT INTO conhecimento (nome) VALUES (:nome)');
    $stmt->execute(array(
    ':nome' =>$nome,
  ) 
); 
$msg = "Cadastro efetuado com sucesso!";
$redirect = "../cadastrarConhecimento.php?msg=".$msg;
    
  echo $stmt->rowCount(); 

} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
}

header("location:$redirect");

?>


  