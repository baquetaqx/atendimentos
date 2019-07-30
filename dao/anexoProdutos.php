<?php
session_start();
$id=$_GET['id'];
$produto = $_POST['produto'];
$quantidade = $_POST['quantidade'];

try {
    include 'conexao.php';
    $pdo = getConnection();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->prepare("SELECT preco FROM produto where id=$produto");
    $stmt->execute();
    $resultPreco = $stmt->fetch(PDO::FETCH_ASSOC);
    $valorUnitario = $resultPreco['preco'];
    $valor = $resultPreco['preco'] * $quantidade;
    
    $stmt = $pdo->prepare("INSERT INTO ordem_produto(idOrdem, idProduto, quantidade, valorUnitario, valor) VALUES (:idOrdem, :idProduto, :quantidade, :valorUnitario, :valor)");
    $stmt->execute(array(
        ':idOrdem' =>$id,
        ':idProduto' =>$produto,
        ':quantidade'=>$quantidade,
        ':valorUnitario'=>$valorUnitario,
        ':valor'=>$valor,
      ) 
    ); 
    $msg="Produto adicionado a OS";
    $redirect = "../anexoProdutos.php?id=$id&msg=$msg"; 
} catch(PDOException $e) {
echo 'Error: ' . $e->getMessage();
    // $redirect = "novo.php?message=false";
}
header("location:$redirect");
?>