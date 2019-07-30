<?php
 
 $user = $_POST['usuario'];
 $senha = md5($_POST['senha']);

try {
  include 'conexao.php';
  $pdo = getConnection();
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
   $stmt = $pdo->prepare('select usuario.id as idusuario, usuario.usuario, usuario.nome, usuario.senha, usuario.funcao, usuario.situacao
   from usuario where usuario = :usuario and senha = :senha');
   $stmt->execute(['usuario' => $user, 'senha' => $senha]);
   $resultado = $stmt->fetch();
   $userb = $resultado['usuario'];
   $senhab = $resultado['senha'];
   $funcao = $resultado['funcao'];
   $situacao = $resultado['situacao'];
   $nome = $resultado['nome'];
   $idusuario = $resultado['idusuario'];

} catch(PDOException $e) {
  echo 'Error: ' . $e->getMessage();
    // $redirect = "novo.php?message=false";  
}
if($senha == $senhab && $userb == $user && $situacao == '1'){
    //criar verificar registro
    session_start();
    $_SESSION['usuario'] = $user;
    $_SESSION['funcao']= $funcao;
    $_SESSION['situacao'] = $situacao;
    $_SESSION['logado']= "s";
    $_SESSION['nome'] = $nome;
    $_SESSION['idusuario'] = $idusuario;
    $redirect = '../index.php';
    header("location:$redirect");
}else{
    $msg = "Dados Incorretos!";
    if($situacao == '2'){
        $msg = "Verifique sua situação junto ao suporte!";
    }
    $redirect = "../login.php?msg=".$msg;
    header("location:$redirect");

}
function soNumero($str) {
    return preg_replace("/[^0-9]/", "", $str);
}
//header("location:$redirect");

?>


  