<?php

	include 'dao/conexao.php';
	$retorno = array();
	$con = getConnection();
	if ($_GET['acao']=='categoria') {
		$sql=$con->prepare("SELECT * FROM categoria WHERE situacao=1");
		$sql->execute();
		$n=0;
		$retorno['qtd'] = $sql->rowCount();
		while ($ln = $sql->fetchObject()) {
			$retorno['id'][$n]=$ln->id;
			$retorno['nome'][$n]=$ln->nome;
			$n++;
		}
	}

	if($_GET['acao'] == 'subcategoria'){
		$id = $_GET['id'];
		$sql = $con->prepare("SELECT * FROM subcategoria WHERE idCategoria = :id ORDER BY nome ASC");
		$sql->bindValue(":id", $id, PDO::PARAM_INT);
		$sql->execute();
		$n = 0;
		$retorno['qtd'] = $sql->rowCount();
		while($ln = $sql->fetchObject()){
			$retorno['id'][$n] = $ln->id;
			$retorno['nome'][$n] = $ln->nome;
			$n++;
		}	
	}
	
	die(json_encode($retorno));
?>