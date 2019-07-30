<?php

session_start();  
    if($_SESSION['usuario'] == null){
        $redirect = '../login.php';
        header("location:$redirect");
    }
$idurl = $_GET['id'];

try{
 include 'conexao.php';
  $conn = getConnection();
  $stmt = $conn->prepare("select nome, referencia, idConhecimento from anexos where id =$idurl");
  $stmt->execute();
  $result = $stmt->fetchAll();
  $condicao = false;
  $ref = null;
  $conhecimento = null;
  foreach ($result as $row) {
  	$condicao = true;
  	$ref = $row['referencia'];
      $conhecimento = $row['idConhecimento'];
      echo $condicao;
  }
  if($condicao){
  	unlink("../tsqws/arquivos/".$ref);
  	$conn = getConnection();
  	$stmt = $conn->prepare('delete from anexos where id ='.$idurl.'');
  	$stmt->execute();
  	$redirect = "../anexoConhecimento.php?id=".$conhecimento;
  	header("location:$redirect");

  }
 
} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
    // $redirect = "novo.php?message=false";
}






?>