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

    <title>FMS Suporte - Ordem de Serviço</title>

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
                            Ordem de Serviço
                            <a class="btn btn-primary col-lg-2" href="listaServicos.php" style="float:right"><i class="fa fa-paperclip"></i>Lista OS</a>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
                            </li>
                            <li>
                                <i class="fa fa-file"></i> Ordem de Serviço
                            </li>
                        </ol>
                    </div>
                </div>

                <form id="formulario" name="formulario" method="POST" action="dao/cadServico.php"
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
                            $result = selectCliente(); 
                        ?>
                        <div class="col-lg-12">
                            <div class="form-group col-lg-12">
                                <label>Cliente:</label>
                                <input id="inputNomeCliente" name="idCliente" class="form-control" type="text" list="clientes" required>
                                <datalist id="clientes">
                                    <?php 
                                    foreach($result as $row) {
                                        echo "<option value='".$row['id'].' - '.$row['nomeFantasia']."'>".$row['nomeFantasia']."</option>";
                                    }                   
                                    ?>
                                </datalist>
                            </div>

                            <div class="form-group col-lg-3">
                                <label>Data:</label>
                                <input id="dataAtendimento" class="form-control" name="dataAtendimento" type="date" required>
                            </div>

                            
                            <!--Novo-->
                            <div class="form-group col-lg-3">
                                <label>Tipo de atendimento:</label>
                                <select class="form-control" name="tipoAtendimento">
                                    <option value="1">Externo</option>
                                    <option value="2">Assistência Técnica</option>
                                    <option value="3">Serviço Interno</option>
                                    <option value="4">Treinamento</option>
                                </select>
                            </div>
                            <!--Novo-->
                            <div class="form-group col-lg-3">
                                <label>Software:</label>
                                <select class="form-control" name="software">
                                    <option value="1">ACS</option>
                                    <option value="2">SysLoja</option>
                                    <option value="3">GRFood</option>
                                </select>
                            </div>
                           
                            <div class="form-group col-lg-3">
                                <label>Situação:</label>
                                <select class="form-control" name="situacao">
                                    <option value="1">Concluído</option>
                                    <option value="2">Pendente</option>
                                </select>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Hora de Entrada:</label>
                                <input type="time" name="horaEntrada" required>
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Hora de Saída:</label>
                                <input type="time" name="horaSaida" required>
                            </div>
                        </div>
                         <!--Novo-->
                        <div class="col-lg-12">
                            <div class="form-group col-lg-12">
                                <label>Ocorrência:</label>
                                <textarea class="form-control rounded-0" name="ocorrencia" rows="5" required></textarea>
                            </div>
                        </div>
                        <!--Novo-->
                        <div class="col-lg-12">
                            <div class="form-group col-lg-12">
                                <label>Observações:</label>
                                <textarea class="form-control rounded-0" name="observacoes" rows="5"></textarea>
                            </div>
                            <div class="form-group col-lg-12">
                                <label>Solução:</label>
                                <textarea class="form-control rounded-0" name="solucao" rows="5" required></textarea>
                            </div>
                        <!--Novo-->
                                    
                        <!--Novo-->
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
    <script src="js/jqujquery.mask.min.js"></script>

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
   <script language="JavaScript" type="text/javascript">
        var now = new Date();

        var day = ("0" + now.getDate()).slice(-2);
        var month = ("0" + (now.getMonth() + 1)).slice(-2);

        var today = now.getFullYear() + "-" + (month) + "-" + (day);

        $('#dataAtendimento').val(today);
    </script>

</body>

</html>