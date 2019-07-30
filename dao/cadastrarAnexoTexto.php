<?php
session_start();
$id=$_GET['id'];
$editor = $_POST['editor'];
$nomeConhecimento=$_GET['nomeConhecimento'];

try {
    include 'conexao.php';
    $pdo = getConnection();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->prepare("INSERT INTO anexotexto(idConhecimento, editor) VALUES (:idConhecimento, :editor)");
    $stmt->execute(array(
        ':idConhecimento' =>$id,
        ':editor' =>$editor,
      ) 
    ); 
    $msg="Texto Atualizado com Sucesso";
    $redirect = "../anexoTexto.php?id=$id&msg=$msg&nomeConhecimento=$nomeConhecimento"; 
} catch(PDOException $e) {
echo 'Error: ' . $e->getMessage();
    // $redirect = "novo.php?message=false";
}
header("location:$redirect");
?>