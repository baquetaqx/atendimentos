<?php
session_start();

$id=$_GET['id'];
$idOS=$_GET['idOS'];

try{
    include 'conexao.php';
    $pdo = getConnection();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare("DELETE FROM ordem_produto where id=$id");
    $stmt->execute();

    $msg="Produto excluido da OS";

    $redirect = "../anexoProdutos.php?id=$idOS&msg=$msg"; 
}catch(PDOException $e) {
    echo 'Error: ' . $e->getMessage();
        // $redirect = "novo.php?message=false";
    }
header("location:$redirect");

?>
