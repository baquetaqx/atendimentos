<?php


 function verificarid($id){
    try{
        include 'conexao.php';
        $conn = getConnection();
        $stmt = $conn->prepare("select * from conhecimento where id =$id");
        $stmt->execute();
        $result = $stmt->fetchAll();
        $condicao = false;

        foreach($result as $row) {
          $condicao = true;
        }
        return $condicao;   

    }catch(PDOException $e) {
    echo 'Error: ' . $e->getMessage();
    // $redirect = "novo.php?message=false";
    }   
}

function verificaridProduto($id){
  try{
      include 'conexao.php';
      $conn = getConnection();
      $stmt = $conn->prepare("SELECT * FROM ordemdeservico WHERE id = $id");
      $stmt->execute();
      $result = $stmt->fetchAll();
      $condicao = false;

      foreach($result as $row) {
        $condicao = true;
      }
      return $condicao;   

  }catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
  // $redirect = "novo.php?message=false";
  }   
}
?>