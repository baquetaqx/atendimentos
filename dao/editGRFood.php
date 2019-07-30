<?php
//session_start();
$id=$_POST['id'];
$cliente = $_POST['cliente'];
$cnpj = $_POST['cnpj'];
$registro = $_POST['registro'];
$versao = $_POST['versao'];
$expira = $_POST['expira'];
$chave = $_POST['chave'];

try {
  include 'conexao.php';
  $pdo = getConnection();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  $stmt = $pdo->prepare('UPDATE grfood SET nomeCliente=:nomeCliente, cnpj=:cnpj, registro=:registro, 
  versao=:versao, expira=:expira, chave=:chave WHERE id=:id');
    $stmt->execute(array(
    ':nomeCliente' =>$cliente,
    ':cnpj' =>$cnpj,
    ':registro' =>$registro,
    ':versao' =>$versao,
    ':expira' =>$expira,
    ':chave'=>$chave,
    ':id'=>$id,
  ) 
); 
$msg = "Alterações efetuadas com sucesso!";
$redirect = "../listaGRFood.php?msg=".$msg;
    
  echo $stmt->rowCount(); 

} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
    // $redirect = "novo.php?message=false";

}

header("location:$redirect");

?>


  