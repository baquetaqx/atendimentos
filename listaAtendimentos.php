<?php
    session_start();
    if($_SESSION['usuario'] == null){
        $redirect = 'login.php';
        header("location:$redirect");
    }


/* Constantes de configuração */  
 define('QTDE_REGISTROS', 10);   
 define('RANGE_PAGINAS', 1);   
   
 /* Recebe o número da página via parâmetro na URL */  
 $pagina_atual = (isset($_GET['page']) && is_numeric($_GET['page'])) ? $_GET['page'] : 1;   
   
 /* Calcula a linha inicial da consulta */  
 $linha_inicial = ($pagina_atual -1) * QTDE_REGISTROS;  
   
 /* Cria uma conexão PDO com MySQL */  
 $pdo = new PDO("mysql:host=localhost; dbname=fmssuporte;", "root", "");  
   
 /* Instrução de consulta para paginação com MySQL */  
 $sql = "SELECT * FROM atendimento ORDER BY dataAtendimento DESC LIMIT {$linha_inicial}, " . QTDE_REGISTROS;  
 $stm = $pdo->prepare($sql);   
 $stm->execute();   
 $dados = $stm->fetchAll(PDO::FETCH_OBJ);   
   
 /* Conta quantos registos existem na tabela */  
 $sqlContador = "SELECT COUNT(*) AS total_registros FROM atendimento";   
 $stm = $pdo->prepare($sqlContador);   
 $stm->execute();   
 $valor = $stm->fetch(PDO::FETCH_OBJ);   
   
 /* Idêntifica a primeira página */  
 $primeira_pagina = 1;   
   
 /* Cálcula qual será a última página */  
 $ultima_pagina  = ceil($valor->total_registros / QTDE_REGISTROS);   
   
 /* Cálcula qual será a página anterior em relação a página atual em exibição */   
 $pagina_anterior = ($pagina_atual > 1) ? $pagina_atual -1 :  "";   
   
 /* Cálcula qual será a pŕoxima página em relação a página atual em exibição */   
 $proxima_pagina = ($pagina_atual < $ultima_pagina) ? $pagina_atual +1 : "" ;  
   
 /* Cálcula qual será a página inicial do nosso range */    
 $range_inicial  = (($pagina_atual - RANGE_PAGINAS) >= 1) ? $pagina_atual - RANGE_PAGINAS : 1 ;   
   
 /* Cálcula qual será a página final do nosso range */    
 $range_final   = (($pagina_atual + RANGE_PAGINAS) <= $ultima_pagina ) ? $pagina_atual + RANGE_PAGINAS : $ultima_pagina ;   
   
 /* Verifica se vai exibir o botão "Primeiro" e "Pŕoximo" */   
 $exibir_botao_inicio = ($range_inicial < $pagina_atual) ? 'mostrar' : 'esconder'; 
   
 /* Verifica se vai exibir o botão "Anterior" e "Último" */   
 $exibir_botao_final = ($range_final > $pagina_atual) ? 'mostrar' : 'esconder';  

?>

<!DOCTYPE html>
<html lang="pt">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>FMS Suporte - Lista de Atendimentos</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/jquery.dataTables.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
        .pagination {
            display: inline-block;
        }

        .pagination a {
            color: black;
            float: left;
            padding: 8px 16px;
            text-decoration: none;
        }
    </style>

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">FMS Suporte</a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>
                        <?php
                            if (isset($_SESSION['nome'])) {
                                echo $_SESSION['nome'];
                            }
                        ?>
                        <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="sair.php"><i class="fa fa-fw fa-power-off"></i> Log Out</a>
                        </li>
                    </ul>
                </li>
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <?php
                include('templates/menu.php');
            ?>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Lista de Atendimentos
                            <a class="btn btn-success col-lg-2" href="cadastroAtendimento.php" style="float:right"><i class="fa fa-phone"></i>Cad Atendimentos</a>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
                            </li>
                            <li>
                                <i class="fa fa-file"></i> Lista de Atendimento
                            </li>
                        </ol>
                    </div>
                </div>

                <div class="row">
                    <?php 
                        include 'dao/selectUsuario.php';
                        include 'dao/selectClientes.php';
                        $result = selectUsuarios(); 
                        $resultCliente = selectCliente();
                    ?>
                    <div class="form-group col-lg-3">
                        <label>Cliente:</label>
                        <input id="idCliente" name="idCliente" class="form-control" type="text" list="clientes">
                        <datalist id="clientes">
                            <?php 
                            foreach($resultCliente as $row) {
                                echo "<option value='".$row['id'].' - '.$row['nomeFantasia']."'>".$row['nomeFantasia']."</option>";
                            }                   
                            ?>
                        </datalist>
                    </div>
                    <div class="form-group col-lg-3">
                        <label>Data Inicial:</label>
                        <input id="dtInicial" class="form-control" name="dtInicial" type="date" required>
                    </div>
                    <div class="form-group col-lg-3">
                        <label>Data Final:</label>
                        <input id="dtFinal" class="form-control" name="dtFinal" type="date" required>
                    </div>
                    <div class="form-group col-lg-3">
                        <label>Técnico:</label>
                        <select class="form-control" name="idUsuario" id="idUsuario">
                            <option value="">Selecione Ténico</option>
                            <?php foreach($result as $row ) { ?>
                            <option value="<?php echo $row['id'];?>"><?php echo $row['nome'];?></option>
                            <?php } ?>
                        </select>
                    </div>
                    
                    <div class="form-group col-lg-4">
                        <label>Categoria:</label>
                        <select class="form-control" name="categoria" id="categoria">
                        <option value="">Selecione Categoria</option>
                        </select>
                    </div>
                    <div class="form-group col-lg-4">
                        <label>Subcategoria:</label>
                        <select class="form-control" name="subcategoria" id="subcategoria" required>
                        </select>
                    </div>

                    <div class="form-group col-lg-2">
                        <label>&nbsp;</label>
                        <button id="filter" class="btn btn-success btn-block" name="filter" type="submit"><i class="fa fa-search"></i>Procurar</button>
                    </div>
                </div>
                <div class="row">
                    <!-- DataTables Example -->

                    <?php if(isset($_GET['msg']))
                            echo '<div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong></strong>'.$_GET['msg'].'
                            </div>';
                        ?>

                    <?php
      echo'
        

        <div class="card mb-3">
          <div class="card-body">
            <div id="" class="table-responsive">';
            echo'
                <table id="order_table" class="table table-striped table-bordered" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Cliente</th>
                        <th>Data</th>
                        <th>Categoria</th>
                        <th>SubCategoria</th>
                        <th>Usuário</th>
                        <th>Situação</th>
                        <th>Operação</th>
                    </tr>
                    </thead>';
                try{
                    include 'dao/selectAtendimento.php';
                    include 'dao/selectCategoriaPorId.php';
                    include 'dao/selectSubCategoriaPorId.php';
                    if ( count($dados) ) {
                        foreach ($dados as $artigo){
                            if ($artigo->situacao==1) {
                                $situacao = "Concluido";
                                } else{
                                $situacao = "Pendente";
                                }
                                $categoria = $artigo->categoria;
                                $subcategoria = $artigo->subcategoria;
                                $observacao = $artigo->observacao;
                                $idAtendimento = $artigo->id;
                                $dataAtendimento = date("d/m/Y", strtotime($artigo->dataAtendimento));
                                $descProblema = $artigo->descProblema;
                                $descSolucao = $artigo->descSolucao;
                                $cliente = $artigo->idCliente;
                                $usuario = $artigo->idUsuario;
                                $observacao = $artigo->observacao;

                                $stmtCliente = selectClienteById($cliente);
                                $resultCliente = $stmtCliente;
                        if (count($resultCliente)) {
                            foreach($resultCliente as $rowCliente) {
                                $stmtUsuario = selectUsuariosById($usuario);
                                $resultUsuario = $stmtUsuario;
                                if (count($resultUsuario)) {
                                    foreach($resultUsuario as $rowUsuario) {
                                        $nomeCliente = $rowCliente['nomeFantasia'];
                                        $nomeUsuario = $rowUsuario['nome'];
                                    
                                    
                                        $stmtCategoria = selectCategoriaPorId($categoria);
                                        $resultCategoria = $stmtCategoria;
                                        if (count($resultCategoria)) {
                                            foreach($resultCategoria as $rowCategoria) {
                                                $nomeCategoria = $rowCategoria['nome'];
                                                
                                                $stmtSubcategoria = selectSubcategoriaPorId($subcategoria);
                                                $resultSubcategoria = $stmtSubcategoria;
                                                if (count($resultSubcategoria)) {
                                                    foreach($resultSubcategoria as $rowSubcategoria) {
                                                        $nomeSubcategoria = $rowSubcategoria['nome'];
                                                        echo '<tr>';
                                                        echo '<td>'.$nomeCliente.'</td>';
                                                        echo '<td>'.$dataAtendimento.'</td>';
                                                        echo '<td>'.$nomeCategoria.'</td>';
                                                        echo '<td>'.$nomeSubcategoria.'</td>';
                                                        echo '<td>'.$nomeUsuario.'</td>';
                                                        echo '<td>'.$situacao.'</td>';
                                                        echo '<td> <center>
                                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalExibir'.$idAtendimento.'"><i class="fa fa-eye"></i>Visualizar</button>
                                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalEditar'.$idAtendimento.'"><i class="fa fa-edit"></i>Editar</button>
                                                        </center></td>';

                                                }
                                            }

                                        }
                                    }
                                }
                            }
                        }
                    }


                        //MODAL EXIBIR CLIENTES
                        echo '
                        <div class="modal fade" id="modalExibir'.$idAtendimento.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Atendimento '.$idAtendimento.'</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">
                                <p>Cliente: <b>'.$nomeCliente.'</b></p>
                                <p>Data Atendimento: <b>'.$dataAtendimento.'</b></p>
                                <p>Categoria: <b>'.$nomeCategoria.'</b></p>
                                <p>Subcategoria: <b>'.$nomeSubcategoria.'</b></p>
                                <p>Usuário: <b>'.$nomeUsuario.'</b></p>
                                <p>Descrição do Problema: <b>'.$descProblema.'</b></p>
                                <p>Descrição do Solução: <b>'.$descSolucao.'</b></p>
                                <p>Observação: <b>'.$observacao.'</b></p>
                                <p>Situação: <b>'.$situacao.'</b></p>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                </div>
                            </div>
                            </div>
                        </div>';

                        //MODAL REGISTRAR
                        echo '
                        <div class="modal fade" id="modalEditar'.$idAtendimento.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <form method="POST" id="editAtendimento" action="dao/editAtendimento.php" autocomplete="off">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Editar Atendimento</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="id" value="'.$idAtendimento.'"></input>
                                            <div class="row">
                                                <div class="form-group col-lg-6">
                                                    <p>Cliente: </p>
                                                    <p><b>'.$nomeCliente.'</b></p>
                                                </div>
                                                <div class="form-group col-lg-6">
                                                    <p>Data Atendimento: </p>
                                                    <input type="date" value="'.$artigo->dataAtendimento.'" id="dataAtendimento" name="dataAtendimento" class="form-control" placeholder="nome" required="required" autofocus="autofocus" disabled>
                                                </div>
                                                <div class="form-group col-lg-6">
                                                    <p>Categoria: </p>
                                                    <input value="'.$nomeCategoria.'" id="categoria" name="categoria" class="form-control" placeholder="nome" required="required" autofocus="autofocus" disabled>
                                                </div>
                                                <div class="form-group col-lg-6">
                                                    <p>Subcategoria: </p>
                                                    <input value="'.$nomeSubcategoria.'" id="subcategoria" name="subcategoria" class="form-control" placeholder="nome" required="required" autofocus="autofocus" disabled>
                                                </div>
                                                <div class="form-group col-lg-6">
                                                    <p>Problema: </p>
                                                    <textarea id="problema" name="problema" class="form-control rounded-0" rows="5" required="required" autofocus="autofocus" disabled>'.$descProblema.'</textarea>
                                                </div>
                                                <div class="form-group col-lg-6">
                                                    <p>Solução: </p>
                                                    <textarea id="solucao" name="solucao" class="form-control rounded-0" rows="5" required="required" autofocus="autofocus" disabled>'.$descSolucao.'</textarea>
                                                </div>
                                                <div class="form-group col-lg-12">
                                                    <p>Situação: </p>
                                                    <select class="form-control" name="situacao" '; echo '>
                                                    <option value="1"'; if($situacao == 'Concluido'){echo ' selected';} echo '>Concluido</option>
                                                    <option value="2"'; if($situacao == 'Pendente'){echo ' selected';} echo '>Pendente</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-lg-12">
                                                    <p>Observacao: </p>
                                                    <textarea id="solucao" name="observacao" class="form-control rounded-0" rows="5" autofocus="autofocus">'.$observacao.'</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Salvar</button>
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                            
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>';

                        echo'</tr>';
                        } 
                            
                    } else {
                    echo "Nenhum resultado retornado.";
                    }
                } catch(PDOException $e) {
                    echo 'ERROR: ' . $e->getMessage();
                }
                  echo '</tbody>';  
                  echo '</table>';
                  ?>
                    <div class='box-paginacao pagination'>
                        <a class='box-navegacao <?=$exibir_botao_inicio?>'
                            href="listaAtendimentos.php?page=<?=$primeira_pagina?>" title="Primeira Página">Primeira</a>
                        <a class='box-navegacao <?=$exibir_botao_inicio?>'
                            href="listaAtendimentos.php?page=<?=$pagina_anterior?>" title="Página Anterior">Anterior</a>

                        <?php  
                /* Loop para montar a páginação central com os números */   
                for ($i=$range_inicial; $i <= $range_final; $i++):   
                    $destaque = ($i == $pagina_atual) ? 'destaque' : '' ;  
                    ?>
                        <a class='box-numero <?=$destaque?>' href="listaAtendimentos.php?page=<?=$i?>"><?=$i?></a>
                        <?php endfor; ?>

                        <a class='box-navegacao <?=$exibir_botao_final?>'
                            href="listaAtendimentos.php?page=<?=$proxima_pagina?>" title="Próxima Página">Próxima</a>
                        <a class='box-navegacao <?=$exibir_botao_final?>'
                            href="listaAtendimentos.php?page=<?=$ultima_pagina?>" title="Última Página">Último</a>
                    </div>

                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Mask Core JavaScript -->
    <script src="js/jquery.mask.js"></script>
    <script src="js/jquery.mask.min.js"></script>

    <script language="JavaScript" type="text/javascript">
        var options = {
            onKeyPress: function (cpf, ev, el, op) {
                var masks = ['000.000.000-000', '00.000.000/0000-00'];
                $('.cpfOuCnpj').mask((cpf.length > 14) ? masks[1] : masks[0], op);
            }
        }

        $('.cpfOuCnpj').length > 11 ? $('.cpfOuCnpj').mask('00.000.000/0000-00', options) : $('.cpfOuCnpj').mask(
            '000.000.000-00#', options);
    </script>

    <script src="//code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="//cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable({
                "language": {
                    "lengthMenu": "Mostrando _MENU_ registros por página",
                    "zeroRecords": "Nada encontrado",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "Nenhum registro disponível",
                    "infoFiltered": "(filtrado de _MAX_ registros no total)"
                },
            });
        });
    </script>
<script>
        function categoria(){
		$.ajax({
			type: 'GET',
			url: 'subcategoriaPost.php',
			data: {
				acao: 'categoria'
			},
			dataType: 'json',
			success: function(data){
                console.log(data);
				for(i = 0; i < data.qtd; i++){
					$('select[name=categoria]').append('<option value="'+data.id[i]+'">'+data.nome[i]+'</option>');
				}
			}
		});
	    }
        categoria();
        
        function subcategoria(categoria){
            $.ajax({
                type: 'GET',
                url: 'subcategoriaPost.php',
                data: {
                    acao: 'subcategoria',
                    id: categoria
                },
                dataType: 'json',
                beforeSend: function(){
                    $('select[name=subcategoria]').html('<option>Carregando...</option>');
                },
                success: function(data){
                    $('select[name=subcategoria]').html('');
                    $('select[name=subcategoria]').append('<option>Selecione a subcategoria</option>');
                    for(i = 0; i < data.qtd; i++){
                        $('select[name=subcategoria]').append('<option value="'+data.id[i]+'">'+data.nome[i]+'</option>');
                    }
                }
            });        
        }
        $('select[name=categoria]').change(function(){
            var idSubcategoria = $(this).val();
            subcategoria(idSubcategoria);
	    });
    </script>
    
    <script>
        $(document).ready(function(){
            $('#filter').click(function(){
                var dtInicial = $('#dtInicial').val();
                var dtFinal = $('#dtFinal').val();
                var idCliente = $('#idCliente').val().substring(0, 3);;
                var idUsuario = $('#idUsuario').val();
                var categoria = $('#categoria').val();
                var subcategoria = $('#subcategoria').val();
                if (dtInicial=='' || dtFinal=='') {
                    alert('Digite intervalo de datas');
                }else{
                    $.ajax({
                        url:"filterAtendimento.php",
                        method:"POST",
                        data:{dtInicial:dtInicial, dtFinal:dtFinal, idCliente:idCliente, idUsuario:idUsuario, categoria:categoria, subcategoria:subcategoria},
                        success:function(data){
                            $('#order_table').html(data);
                        }
                    });
                }
            });
        });
    </script>

    <script language="JavaScript" type="text/javascript">
        $('#dtFinal').on('focusout', function(){  
            var dateObj1 = new Date($('#dtInicial').val());
            var dateObj2 = new Date($('#dtFinal').val());
            
            if(dateObj1.getTime() > dateObj2.getTime()){
                $(this).css({color: 'red'});
                // mostre alguma mensagem
                $(this).focus(); // Volta o foco para o segundo input
            }else{
                $(this).css({color: 'black'});
            }  
        });
    </script>

    <script language="JavaScript" type="text/javascript">
        var now = new Date();
        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);
        var today = now.getFullYear() + "-" + (month) + "-" + (day);

        $('#dtFinal').val(today);
    </script>



</body>

</html>