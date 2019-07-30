<?php
 
try {
  function selectAtendimentos(){
    $usuario = $_SESSION['idusuario'];
    $funcao = $_SESSION['funcao'];
    include 'conexao.php';
    $conn = getConnection();
    if ($funcao == '1'|| $funcao == '2') {
      $stmt = $conn->prepare("SELECT * FROM atendimento ORDER BY id DESC LIMIT 500");
    }else{
      $stmt = $conn->prepare("SELECT * FROM atendimento WHERE idUsuario = $usuario");
    }
    $stmt->execute();
    $result = $stmt->fetchAll();
    return $result;
  }   
} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
    // $redirect = "novo.php?message=false";
}

?>


  