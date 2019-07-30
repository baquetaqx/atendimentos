<?php
//session_start();
$id=$_POST['id'];
$nome = $_POST['nome'];
$preco = $_POST['preco'];

try {
  include 'conexao.php';
  $pdo = getConnection();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  $stmt = $pdo->prepare('UPDATE produto SET nome=:nome, preco=:preco WHERE id=:id');
    $stmt->execute(array(
    ':nome' =>$nome,
    ':preco' =>$preco,
    ':id'=>$id,
  ) 
); 
$msg = "Alterações efetuadas com sucesso!";
$redirect = "../listaProdutos.php?msg=".$msg;
    
  echo $stmt->rowCount(); 

} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
    // $redirect = "novo.php?message=false";

}

header("location:$redirect");

?>


  