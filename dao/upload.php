<?php
session_start();
$idConhecimento = $_GET['id'];
$usuario = uniqid();
$descricao = $_POST['nome'];
$referencia = $usuario;
$diretorio = "../tsqws/arquivos";
include '../dao/conexao.php';

//aqui eu preciso verificar se o id da empresa em sessao é o mesmo que está em id anexos

                $formatosPermitidos= array('pdf','png','jpg','jpeg', 'exe', 'doc', 'docx', 'txt', 'xls');
                $maxsize = 100097152;
                $extensao = pathinfo ($_FILES['arquivo']['name'], PATHINFO_EXTENSION);
                if(($_FILES['arquivo']['size'] >= $maxsize) || ($_FILES["arquivo"]["size"] == 0)) {
                    $errors[] = 'Arquivo muito grande. O arquivo deve ter menos 100 megabytes.';
                    foreach ($errors as $error) {
                        $redirect = "../anexoConhecimento.php?id=".$idConhecimento."&msg=".$error;
                    }
                    header("location:$redirect");
                }
                if((!in_array($_FILES['arquivo']['type'], $formatosPermitidos)) && (!empty($_FILES["arquivo"]["type"]))) {
                    $errors[] = 'Tipo de arquivo inválido. Apenas os tipos PDF, JPG, JPEG e PNG são aceitos.';
                    foreach ($errors as $error) {
                        $redirect = "../anexoConhecimento.php?id=".$idConhecimento."&msg=".$error;
                    }
                    header("location:$redirect");
                }

                if(in_array($extensao, $formatosPermitidos)){
                    $pasta = "../tsqws/arquivos/";
                    $temporario = $_FILES['arquivo']['tmp_name'];
                    $nome = $_FILES['arquivo']['name'];
                    //$stringCorrigida = str_replace('.pdf', '', $nome);
                    $novoNome = $usuario.".$extensao";
                    echo $novoNome;
                    if(move_uploaded_file($temporario, $pasta.$novoNome)){
                        try{
                        $redirect = "../anexoConhecimento.php?id=".$idConhecimento;
                        echo 'Entrou';
                        $pdo = getConnection();
                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                         $stmt = $pdo->prepare('INSERT INTO anexos (idConhecimento, nome, referencia) VALUES (:idConhecimento, :nome, :referencia)');
                        $stmt->execute(array(
                            ':idConhecimento'=>$idConhecimento,
                            ':nome' =>$descricao,
                            ':referencia'=>$referencia.'.'.$extensao,
                        )
                        ); 
                        } catch(PDOException $e) {
    
                        echo 'Error: ' . $e->getMessage();
                          // $redirect = "novo.php?message=false";
                      }
                        
                        header("location:$redirect");
                    }      
                }else{
                    //echo "nao existe";
                }

?>