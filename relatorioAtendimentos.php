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

    <title>FMS Suporte - Relatório de Atendimentos</title>

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
                            Relatório de Atendimentos
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Relatório de Atendimentos
                            </li>
                        </ol>
                    </div>
                </div>

                <div class="row">
                    <form method="POST" action="relatorios/relatorioAtendimentos.php" autocomplete="off" target="_blank">
                    <div class="col-lg-12">
                            <?php 
                                include 'dao/selectUsuario.php';
                                include 'dao/selectClientes.php';
                                $result = selectUsuarios(); 
                                $resultCliente = selectCliente();
                            ?>
                            <div class="form-group col-lg-12">
                                <label>Visualização Relatório:</label>
                                <br>
                                <label class="radio-inline"><input type="radio" name="visualizacao" value="detalhado" checked>Detalhado</label>
                                <label class="radio-inline"><input type="radio" name="visualizacao" value="cliente">Quantitativo Cliente</label>
                                <label class="radio-inline"><input type="radio" name="visualizacao" value="usuario">Quantitativo Usuário</label>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Cliente:</label>
                                <input id="inputNomeCliente" name="idCliente" class="form-control" type="text" list="clientes">
                                <datalist id="clientes">
                                    <?php 
                                    foreach($resultCliente as $row) {
                                        echo "<option value='".$row['id'].' - '.$row['nomeFantasia']."'>".$row['nomeFantasia']."</option>";
                                    }                   
                                    ?>
                                </datalist>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Categoria:</label>
                                <select class="form-control" name="categoria" id="">
                                <option value="">Selecione Categoria</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Subcategoria:</label>
                                <select class="form-control" name="subcategoria" id="codSubcategoria">
                                </select>
                            </div>

                            <div class="form-group col-lg-4">
                                <label>Data Inicial:</label>
                                <input id="dtInicial" class="form-control" name="dtInicial" type="date" required>
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Data Final:</label>
                                <input id="dtFinal" class="form-control" name="dtFinal" type="date" required>
                            </div>

                            <div class="form-group col-lg-4">
                                <label>Técnico:</label>
                                <select class="form-control" name="idUsuario" id="">
                                    <option value="">Selecione Ténico</option>
                                    <?php foreach($result as $row ) { ?>
                                        <option value="<?php echo $row['id'];?>"><?php echo $row['nome'];?></option>
                                    <?php } ?>    
                                </select>
                            </div>

                                
                            </div>
                            <div class="form-row">
                            <div class="col-md-12">
                                    <div class="form-label-group">
                                        <button class="btn btn-success btn-block" type="submit"
                                            target="_blank">Gerar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
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
    <script src="js/jqujquery.mask.min.js"></script>

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

        $('#dtFinal').val(today);
    </script>
</body>

</html>