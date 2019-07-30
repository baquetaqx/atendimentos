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

    <title>FMS Suporte - Cadastro de Cliente</title>

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
                            Cadastro de Cliente
                            <a class="btn btn-primary col-lg-2" href="listaClientes.php" style="float:right"><i class="fa fa-building"></i>Lista Clientes</a>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Cadastro de Cliente
                            </li>
                        </ol>
                    </div>
                </div>

                <div class="row">
                    <form id="formulario" name="formulario" method="POST" action="dao/cadCliente.php"
                        autocomplete="off">
                        <div class=" col-lg-12">
                            <?php if(isset($_GET['msg']))
                            echo '<div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong></strong>'.$_GET['msg'].'
                            </div>';
                        ?>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group col-lg-12">
                                <label>Nome Fantasia:</label>
                                <input class="form-control" name="nomeFantasia" required>
                            </div>
                            <div class="form-group col-lg-9">
                                <label>Endereço:</label>
                                <input class="form-control" name="endereco">
                            </div>
                            <div class="form-group col-lg-3">
                                <label>Número:</label>
                                <input class="form-control" name="numero">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Cidade:</label>
                                <input class="form-control" name="cidade">
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Bairro:</label>
                                <input class="form-control" name="bairro">
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Cep:</label>
                                <input class="form-control" name="cep" id="cep">
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Telefone 1:</label>
                                <input class="form-control fone1" name="telefone1">
                            </div>
                            <div class="form-group col-lg-4">
                                <label>Telefone 2:</label>
                                <input class="form-control fone2" name="telefone2">
                            </div>
                            <?php if($_SESSION['funcao']=="1"){
                                echo '<div class="form-group col-lg-4">
                                    <label>Bloqueado?:</label>
                                    <select class="form-control" name="bloqueado">
                                        <option value="1">Sim</option>
                                        <option value="2" selected>Nao</option>
                                    </select>
                                </div>';
                                }
                            ?>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-group col-lg-12">
                                <label>Razão Social:</label>
                                <input class="form-control" name="razaoSocial" required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>CNPJ/CPF:</label>
                                <input type="text" class="form-control cpfOuCnpj" name="cpfCnpj" id="cpfOuCnpj"
                                    required>
                            </div>
                            <div class="form-group col-lg-6">
                                <label>Situação:</label>
                                <select class="form-control" name="situacao">
                                    <option value="1">Ativo</option>
                                    <option value="2">Inativo</option>
                                </select>
                            </div>
                            
                            <div class="form-group col-lg-12">
                                <label>Observacao:</label>
                                <textarea class="form-control rounded-0" name="observacao" rows="5" ></textarea>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button type="submit" class="btn btn-primary col-lg-6">Concluir</button>
                            <a class="btn btn-primary btn-danger col-lg-6" href="index.php">Cancelar</a>
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

    <script>
        $('.fone1').mask('(00) 0000-00009');
        $('.fone1').blur(function (event) {
            if ($(this).val().length == 15) { // Celular com 9 dígitos + 2 dígitos DDD e 4 da máscara
                $('.fone1').mask('(00) 00000-0009');
            } else {
                $('.fone1').mask('(00) 0000-00009');
            }
        });
    </script>

    <script>
        $('.fone2').mask('(00) 0000-00009');
        $('.fone2').blur(function (event) {
            if ($(this).val().length == 15) { // Celular com 9 dígitos + 2 dígitos DDD e 4 da máscara
                $('.fone2').mask('(00) 00000-0009');
            } else {
                $('.fone2').mask('(00) 0000-00009');
            }
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#cep").mask("99999-999");
        });
    </script>
</body>


</html>