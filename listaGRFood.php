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

    <title>FMS Suporte - Grfood</title>

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
                            Lista de Clientes GRFood
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
                            </li>
                            <li>
                                <i class="fa fa-file"></i> Lista de Clientes GRFood
                            </li>
                        </ol>
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
            <div class="table-responsive">';
            echo'
            <table id="dataTable" class="table table-striped table-bordered" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Cliente</th>
                <th>CNPJ</th>
                <th>Registro</th>
                <th>Versão</th>
                <th>Expira em</th>
                <th>Opções</th>

                
              </tr>
            </thead>';
            try{
            

              include 'dao/selectGRFood.php';
              $stmt = selectGRFood();
              $result = $stmt;
              echo '<tbody>';
                          if ( count($result) ) { 
                            foreach($result as $row) {
                            $idGRFood = $row['id'] ;
                            $cliente = $row['nomeCliente'];
                            $cnpj = $row['cnpj'];
                            $registro=$row['registro'];
                            $versao=$row['versao'];
                            $expira=date("d/m/Y", strtotime($row['expira']));
                            $chave = $row['chave'];

                            echo '<tr>';
                            echo '<td>'.$cliente.'</td>';
                            echo '<td>'.$cnpj.'</td>';
                            echo '<td>'.$registro.'</td>';
                            echo '<td>'.$versao.'</td>';
                            echo '<td>'.$expira.'</td>';
                            echo '<td> <center>
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalExibir'.$idGRFood.'"><i class="fa fa-eye"></i>Visualizar</button>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalEditar'.$idGRFood.'"><i class="fa fa-edit"></i>Editar</button>
                            </center></td>';

                            //MODAL EXIBIR CLIENTES
                            echo '
                            <div class="modal fade" id="modalExibir'.$idGRFood.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Usuário</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    <p>Cliente: <b>'.$cliente.'</b></p>
                                    <p>CNPJ: <b>'.$cnpj.'</b></p>
                                    <p>Registro: <b>'.$registro.'</b></p>
                                    <p>Versão: <b>'.$versao.'</b></p>
                                    <p>Expira em: <b>'.$expira.'</b></p>
                                    <p>Chave: <b>'.$chave.'</b></p>
                                    
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                  </div>
                                </div>
                              </div>
                            </div>';

                            //MODAL REGISTRAR
                            echo '
                            <div class="modal fade" id="modalEditar'.$idGRFood.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <form method="POST" action="dao/editGRFood.php" autocomplete="off">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Editar GRFood</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="id" value="'.$idGRFood.'"></input>
                                                <div class="row">
                                                    <div class="form-group col-lg-6">
                                                        <p>Cliente: </p>
                                                        <input type="text" value="'.$cliente.'" id="firstName" name="cliente" class="form-control" placeholder="nome" required="required" autofocus="autofocus">
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                        <p>CNPJ: </p>
                                                        <input type="text" value="'.$cnpj.'" id="firstName" name="cnpj" class="form-control" placeholder="nome" required="required" autofocus="autofocus">
                                                    </div>
                                                    <div class="form-group col-lg-4">
                                                        <p>Registro: </p>
                                                        <input type="text" value="'.$registro.'" id="firstName" name="registro" class="form-control" placeholder="nome" required="required" autofocus="autofocus">
                                                    </div>
                                                    <div class="form-group col-lg-4">
                                                        <p>Versão: </p>
                                                        <input type="text" value="'.$versao.'" id="firstName" name="versao" class="form-control" placeholder="nome" required="required" autofocus="autofocus">
                                                    </div>
                                                    <div class="form-group col-lg-4">
                                                        <p>Expira: </p>
                                                        <input type="date" value="'.$row['expira'].'" id="firstName" name="expira" class="form-control" placeholder="nome" required="required" autofocus="autofocus">
                                                    </div>
                                                    <div class="form-group col-lg-12">
                                                        <p>Chave: </p>
                                                        <input type="text" value="'.$chave.'" id="firstName" name="chave" class="form-control" placeholder="nome" required="required" autofocus="autofocus">
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                            <button type="submitt" class="btn btn-primary">Salvar</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>';

                            echo'</tr>';
                            echo '</form>';
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
                }
            });
        });
    </script>

</body>

</html>