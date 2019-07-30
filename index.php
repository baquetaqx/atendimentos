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

    <title>FMS Suporte - Atendimento/OS</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

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
                            Dashboard
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Dashboard/Acesso Rápido
                            </li>
                        </ol>
                        <?php if(isset($_GET['msg']))
                            echo '<div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <strong></strong>'.$_GET['msg'].'
                            </div>';
                        ?>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <?php 
                                            try{
                                                include 'dao/countAtendimentos.php';
                                                $stmt = countAtendimentoConcluido($_SESSION['idusuario']);
                                                $result = $stmt;
                                                if (count($result)) {
                                                    foreach ($result as $row) {
                                                        //output your rows
                                                        echo '
                                                        <div class="huge">'.$row['cnt'].'</div>
                                                        <div>Suportes Concluídos</div>';
                                                    } 
                                                }
                                        }catch(PDOException $e) {
                                            echo 'ERROR: ' . $e->getMessage();
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-tasks fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">

                                        <?php 
                                            try{
                                                $stmt = countAtendimentoPendente($_SESSION['idusuario']);
                                                $result = $stmt;
                                                if (count($result)) {
                                                    foreach ($result as $row) {
                                                        //output your rows
                                                        echo '
                                                        <div class="huge">'.$row['cnt'].'</div>
                                                        <div>Suportes Pendentes</div>';
                                                    } 
                                                }else{
                                                    echo '
                                                        <div class="huge">0</div>
                                                        <div>Suportes Pendentes</div>';
                                                }
                                        }catch(PDOException $e) {
                                            echo 'ERROR: ' . $e->getMessage();
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-list fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                    <?php 
                                            try{
                                                include 'dao/countOS.php';
                                                $stmt = countOSConcluido($_SESSION['idusuario']);
                                                $result = $stmt;
                                                if (count($result)) {
                                                    foreach ($result as $row) {
                                                        //output your rows
                                                        echo '
                                                        <div class="huge">'.$row['cnt'].'</div>
                                                        <div>OS Concluídas</div>';
                                                    } 
                                                }
                                        }catch(PDOException $e) {
                                            echo 'ERROR: ' . $e->getMessage();
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-list fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                    <?php 
                                            try{
                                                
                                                $stmt = countOSPendente($_SESSION['idusuario']);
                                                $result = $stmt;
                                                if (count($result)) {
                                                    foreach ($result as $row) {
                                                        //output your rows
                                                        echo '
                                                        <div class="huge">'.$row['cnt'].'</div>
                                                        <div>OS Pendentes</div>';
                                                    } 
                                                }
                                        }catch(PDOException $e) {
                                            echo 'ERROR: ' . $e->getMessage();
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.row -->


                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="panel panel-red">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-phone fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">Registro</div>
                                        <div>de atendimentos</div>
                                    </div>
                                </div>
                            </div>
                            <a href="cadastroAtendimento.php">
                                <div class="panel-footer">
                                    <span class="pull-left">Ir para atendimentos</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-building fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                    <div class="huge">Ordens</div>
                                        <div>de serviços</div>
                                    </div>
                                </div>
                            </div>
                            <a href="cadastroServico.php">
                                <div class="panel-footer">
                                    <span class="pull-left">Ir para OS</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-book fa-5x"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">GRFood</div>
                                        <div>autenticação</div>
                                    </div>
                                </div>
                            </div>
                            <a href="listaGRFood.php">
                                <div class="panel-footer">
                                    <span class="pull-left">Ir para grfood</span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
                <!-- /.row -->

                                        <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-building"></i> Clientes Bloqueados
                            </li>
                        </ol>
                    </div>
                </div>
                <?php
                    echo'
                        <div class="card mb-3">
                        <div class="card-body">
                            <div class="table-responsive">';
                            echo'
                            <table id="dataTable" class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                            <tr>
                                <th>Nome Fantasia</th>
                                <th>Razão Social</th>
                                <th>CNPJ/CPF</th>';
                                if($_SESSION['funcao']=="1"){
                                    echo '<th>Opções</th>';    
                                }
                        echo '</tr>
                            </thead>';
                            try{
                                include 'dao/selectClienteBloqueado.php';
                                $stmt = selectClienteBloqueado();
                                $result = $stmt;
                                echo '<tbody>';
                                if ( count($result) ) { 
                                    foreach($result as $row) {
                                        $idCliente=$row['id'];
                                        echo '<tr>';
                                            echo '<td style="color: red"><b>'.$row['nomeFantasia'].'</b></td>';
                                            echo '<td style="color: red"><b>'.$row['razaoSocial'].'</b></td>';
                                            echo '<td style="color: red"><b>'.$row['cpfCnpj'].'</b></td>';
                                            if($_SESSION['funcao']=="1"){
                                                echo '<td>
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalEditar'.$idCliente.'">Editar</button>
                                                </td>';    
                                            }
//MODAL Editar
echo '
<div class="modal fade" id="modalEditar'.$idCliente.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form method="POST" action="dao/editClienteBloqueado.php" autocomplete="off">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar informações de Clientes</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="id" value="'.$idCliente.'"></input>
                        <div class="form-group col-lg-6">
                            <p>Nome Fantasia:
                            <input type="text" value="'.$row['nomeFantasia'].'" id="firstName" name="nomeFantasia" class="form-control" placeholder="Nome Fantasia" required="required" autofocus="autofocus" disabled>
                            <label>Bloqueado?:</label>
                            <select class="form-control" name="bloqueado">
                                <option value="1" selected>Sim</option>
                                <option value="2">Nao</option>
                            </select>
                        </div>
                        <div class="form-group col-lg-6">
                            <p>Razao Social:
                            <input type="text" value="'.$row['razaoSocial'].'" name="razaoSocial" class="form-control" placeholder="Razão Social" required="required" autofocus="autofocus" disabled>
                            <p>CPF / CNPJ:
                            <input type="text" value="'.$row['cpfCnpj'].'" id="firstName" name="cpfCnpj" class="form-control" placeholder="CPF/CNPJ" required="required" autofocus="autofocus" disabled>
                        </div>         
                </div>
            </div>
            <div class="modal-footer">
                <button type="submitt" class="btn btn-primary">Salvar</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </form>
    </div>
</div>';
                                        echo '</tr>';    
                                    }
                                }else{
                                    echo "Nenhum Cliente Bloqueado Para Suporte.";
                                }

                            }catch(PDOException $e) {
                                echo 'ERROR: ' . $e->getMessage();
                            }
                            echo '</tbody>';  
                            echo '</table>';
                ?>

                <!-- /.row -->

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

    <!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>

</body>

</html>