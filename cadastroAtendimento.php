<?php
    session_start();
    if($_SESSION['usuario'] == null){
        $redirect = 'login.php';
        header("location:$redirect");
    }
?>

<!DOCTYPE html>
<html lang="pt">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>FMS Suporte - Cadastro Atendimento</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

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

    <style type="text/css">
			.carregando{
				color:#666;
				display:none;
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
                            Cadastro Atendimento
                            <a class="btn btn-primary btn-primary col-lg-2" href="listaAtendimentos.php" style="float:right"><i class="fa fa-phone"></i>Atendimentos</a>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
                            </li>
                            <li>
                                <i class="fa fa-file"></i> Cadastro de Atendimento
                            </li>
                        </ol>
                    </div>
                </div>

                <form id="formulario" name="formulario" method="POST" action="dao/cadAtendimento.php"
                    autocomplete="off">
                    <div class="row">
                        <?php if(isset($_GET['msg']))
                            echo '<div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong></strong>'.$_GET['msg'].'
                            </div>';
                        ?>
                        <?php 
                            include 'dao/selectCliente.php';
                            include 'dao/selectCategorias.php';
                            $result = selectCliente(); 
                            $resultCategoria = selectCategoria();


                        ?>
                        <div class="col-lg-12">
                            <div class="form-group col-lg-12">
                                <label>Cliente:</label>
                                <input id="inputNomeCliente" name="idCliente" class="form-control" type="text" list="clientes" required>
                                <datalist id="clientes">
                                    <?php 
                                    foreach($result as $row) {
                                        echo "<option value='".$row['id'].' - '.$row['nomeFantasia']."'>".$row['razaoSocial']."</option>";
                                    }                   
                                    ?>
                                </datalist>
                            </div>

                            <div class="form-group col-lg-2">
                                <label>Data:</label>
                                <input id="dataAtendimento" class="form-control" name="dataAtendimento" type="date" required>
                            </div>
                            <div class="form-group col-lg-2">
                                <label>Hora de Inicio:</label>
                                <input type="time" id="horaEntrada" name="horaEntrada" class="form-control" required>
                            </div>
                            <div class="form-group col-lg-2">
                                <label>Hora de Término:</label>
                                <input type="time" id="horaFinal" name="horaSaida" class="form-control" required>
                            </div>

                            <div class="form-group col-lg-6">
                                <label>Situação:</label>
                                <select class="form-control" name="situacao">
                                    <option value="1">Concluido</option>
                                    <option value="2">Pendente</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Categoria:</label>
                                <select class="form-control" name="categoria" id="">
                                <option value="">Selecione Categoria</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Subcategoria:</label>
                                <select class="form-control" name="subcategoria" id="codSubcategoria" required>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <div class="form-group col-lg-12">
                                <label>Problema:</label>
                                <textarea class="form-control rounded-0" name="problema" rows="5" required></textarea>
                            </div>
                            <div class="form-group col-lg-12">
                                <label>Solução:</label>
                                <textarea class="form-control rounded-0" name="solucao" rows="5" required></textarea>
                            </div>
                            <div class="form-group col-lg-12">
                                <label>Observação:</label>
                                <textarea class="form-control rounded-0" name="observacao" rows="5" ></textarea>
                            </div>
                        </div>

                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary col-lg-6">Concluir</button>
                            <a class="btn btn-primary btn-danger col-lg-6" href="index.php">Cancelar</a>
                        </div>

                    </div>
                </form>
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
    <script src="js/jquery-3.4.1.min.js" type="text/javascript"></script>
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


   <script language="JavaScript" type="text/javascript">
        var now = new Date();

        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);

        var today = now.getFullYear() + "-" + (month) + "-" + (day);

        $('#dataAtendimento').val(today);
    </script>

    <script language="JavaScript" type="text/javascript">
        var date = new Date();
        var currentTime = date.getHours() + ':' + date.getMinutes();

        if (currentTime.length==4) {
            $('#horaFinal').val('0'+currentTime);
        }else{
            $('#horaFinal').val(currentTime);
        }
    </script>

</body>

</html>