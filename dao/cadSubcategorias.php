<?php
//session_start();
$nome = $_POST['nome'];
$categoria = $_POST['categoria'];

try {
  include 'conexao.php';
  $pdo = getConnection();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  $stmt = $pdo->prepare('INSERT INTO subcategoria (nome, idCategoria) VALUES (:nome, :categoria)');
    $stmt->execute(array(
    ':nome' =>$nome,
    ':categoria' =>$categoria,
  ) 
); 
$msg = "Cadastro efetuado com sucesso!";
$redirect = "../cadastroSubcategoria.php?msg=".$msg;
    
  echo $stmt->rowCount(); 

} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
}

header("location:$redirect");

?>


  