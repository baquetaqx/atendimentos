<?php
//session_start();
$nome = $_POST['nome'];
$usuario = $_POST['usuario'];
$senha = $_POST['senha'];
$funcao = $_POST['funcao'];
$situacao = $_POST['situacao'];

try {
  include 'conexao.php';
  $pdo = getConnection();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  $stmt = $pdo->prepare('INSERT INTO usuario (usuario, nome, senha, funcao, situacao) VALUES (:usuario, :nome, :senha, :funcao, :situacao)');
    $stmt->execute(array(
    ':nome' =>$nome,
    ':usuario' =>$usuario,
    ':senha' =>md5($senha),
    ':funcao' =>$funcao,
    ':situacao' =>$situacao,
  ) 
); 
  
$redirect = "../index.php"; 
    
  echo $stmt->rowCount(); 

} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
}

header("location:$redirect");

?>


  