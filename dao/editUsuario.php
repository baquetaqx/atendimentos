<?php
//session_start();
$id=$_POST['id'];
$nome = $_POST['nome'];
$usuario = $_POST['usuario'];
$senha = $_POST['senha'];
$funcao = $_POST['funcao'];
$situacao = $_POST['situacao'];

try {
  include 'conexao.php';
  $pdo = getConnection();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  $stmt = $pdo->prepare('UPDATE usuario SET nome=:nome, usuario=:usuario, senha=:senha, funcao=:funcao, situacao=:situacao WHERE id=:id');
    $stmt->execute(array(
    ':nome' =>$nome,
    ':usuario' =>$usuario,
    ':senha' =>md5($senha),
    ':funcao' =>$funcao,
    ':situacao' =>$situacao,
    ':id'=>$id,
  ) 
); 
$msg = "Alterações efetuadas com sucesso!";
$redirect = "../listaUsuarios.php?msg=".$msg;
    
  echo $stmt->rowCount(); 

} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
    // $redirect = "novo.php?message=false";

}

header("location:$redirect");

?>


  