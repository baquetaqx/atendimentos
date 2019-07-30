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

    <title>FMS Suporte - Lista de OS</title>

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
                            Ordem de serviço
                            <a class="btn btn-success col-lg-2" href="cadastroServico.php" style="float:right"><i class="fa fa-paperclip"></i>Cad OS</a>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
                            </li>
                            <li>
                                <i class="fa fa-file"></i> Ordem de serviço
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
                <th>OS Nº</th>
                <th>Cliente</th>
                <th>Data</th>
                <th>Técnico</th>
                <th>Situacao</th>
                <th>Operacao</th>
                
              </tr>
            </thead>';
            try{
              include 'dao/selectOrdemServico.php';
              include 'dao/selectCliente.php';
              include 'dao/selectUsuario.php';
              $stmt = selectOrdemServico();
              $result = $stmt;
              echo '<tbody>';
                          if ( count($result) ) { 
                            foreach($result as $row) {
                                    if ($row['situacao']==1) {
                                        $situacao = "Concluido";
                                    } else{
                                        $situacao = "Pendente";
                                    }

                                    if ($row['software']==1) {
                                        $software = "ACS";
                                    } else if($row['software']==2){
                                        $software = "SysLoja";
                                    } else{
                                        $software = "GRFood";
                                    }

                                    if ($row['tipoAtendimento']==1) {
                                        $tipoAtendimento="Externo";
                                    }else if($row['tipoAtendimento']==2){
                                        $tipoAtendimento="Assistência Técnica";
                                    }else if($row['tipoAtendimento']==3){
                                        $tipoAtendimento="Serviço Interno";
                                    }else{
                                        $tipoAtendimento="Treinamento";
                                    }

                                    $idOS=$row['id'];
                                    $cliente =$row['idCliente'];
                                    $usuario=$row['idUsuario'];
                                    $data =date("d/m/Y", strtotime($row['dataLancamento']));
                                
                                    $stmtCliente = selectClienteById($cliente);
                                    $resultCliente = $stmtCliente;
                                    if (count($resultCliente)) {
                                        foreach($resultCliente as $rowCliente) {
                                            $stmtUsuario = selectUsuariosById($usuario);
                                            $resultUsuario = $stmtUsuario;
                                            if (count($resultUsuario)) {
                                                foreach($resultUsuario as $rowUsuario) {
                                                    $nomeUsuario = $rowUsuario['nome'];
                                                    echo '<tr>';
                                                    echo '<td>'.$idOS.'</td>';
                                                    echo '<td>'.$rowCliente['nomeFantasia'].'</td>';
                                                    echo '<td>'.$data.'</td>';
                                                    echo '<td>'.$nomeUsuario.'</td>';
                                                    echo '<td>'.$situacao.'</td>';
                                                    echo '<td> <center>
                                                    <a class="btn btn-warning" href="anexoProdutos.php?id='.$idOS.'"><i class="fa fa-tasks"></i>Produtos</a>
                                                    <a class="btn btn-success" target="_blank" href="imprimeOrdem.php?id='.$idOS.'"><i class="fa fa-print"></i>A4</a>
                                                    <a class="btn btn-success" target="_blank" href="relatorios/relatorioOrdemServico.php?id='.$idOS.'"><i class="fa fa-print"></i>Térmica</a>
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalEditar'.$idOS.'"><i class="fa fa-edit"></i>Editar</button>
                                                    </center></td>';
                                                }
                                            }
                                        }
                                    }


                            

                            //MODAL REGISTRAR
                            echo '
                            <div class="modal fade" id="modalEditar'.$idOS.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <form method="POST" action="dao/editServico.php" autocomplete="off">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Dados OS '.$idOS.'</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="idServico" value="'.$idOS.'"></input>
                                                <div class="row">
                                                <div class="form-group col-lg-4">
                                                    <p>Cliente: </p>
                                                    <p><b>'.$rowCliente['nomeFantasia'].'</b></p>
                                                </div>
                                                <div class="form-group col-lg-4">
                                                    <p>Data OS: </p>
                                                    <input type="date" value="'.$row['dataLancamento'].'" id="dataLancamento" name="dataLancamento" class="form-control" placeholder="nome" required="required" autofocus="autofocus" disabled>
                                                </div>
                                                <div class="form-group col-lg-2">
                                                    <p>Hora Entrada: </p>
                                                    <input value="'.$row['horaEntrada'].'" id="categoria" name="categoria" class="form-control" placeholder="nome" required="required" autofocus="autofocus" disabled>
                                                </div>
                                                <div class="form-group col-lg-2">
                                                    <p>Hora Saida: </p>
                                                    <input value="'.$row['horaSaida'].'" id="subcategoria" name="subcategoria" class="form-control" placeholder="nome" required="required" autofocus="autofocus" disabled>
                                                </div>
                                                <div class="form-group col-lg-4">
                                                    <p>Tipo Atendimento: </p>
                                                    <input value="'.$tipoAtendimento.'" id="subcategoria" name="subcategoria" class="form-control" placeholder="nome" required="required" autofocus="autofocus" disabled>
                                                </div>
                                                <div class="form-group col-lg-4">
                                                    <p>Software: </p>
                                                    <input value="'.$software.'" id="subcategoria" name="subcategoria" class="form-control" placeholder="nome" required="required" autofocus="autofocus" disabled>
                                                </div>
                                                <div class="form-group col-lg-4">
                                                    <p>Situação: </p>
                                                    <select class="form-control" name="situacao" '; if($situacao == 'Concluido'){echo 'disabled';} echo '>
                                                    <option value="1"'; if($situacao == 'Concluido'){echo 'selected';} echo '>Concluido</option>
                                                    <option value="2"'; if($situacao == 'Pendente'){echo 'selected';} echo '>Pendente</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-lg-12">
                                                    <p>Ocorrência: </p>
                                                    <textarea id="ocorrencia" name="ocorrencia" class="form-control rounded-0" rows="5" autofocus="autofocus">'.str_replace('<br />','',$row['ocorrencia']).'</textarea>
                                                </div>
                                                <div class="form-group col-lg-12">
                                                    <p>Observações: </p>
                                                    <textarea id="observacoes" name="observacoes" class="form-control rounded-0" rows="5" autofocus="autofocus">'.str_replace('<br />','',$row['observacoes']).'</textarea>
                                                </div>
                                                <div class="form-group col-lg-12">
                                                    <p>Solução: </p>
                                                    <textarea id="solucao" name="solucao" class="form-control rounded-0" rows="5" autofocus="autofocus">'.str_replace('<br />','',$row['solucao']).'</textarea>
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

    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function () {
            var table=$('#dataTable').DataTable({
                "language": {
                    "lengthMenu": "Mostrando _MENU_ registros por página",
                    "zeroRecords": "Nada encontrado",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "infoEmpty": "Nenhum registro disponível",
                    "infoFiltered": "(filtrado de _MAX_ registros no total)",
                },
                "order": [[ 0, "desc" ]], //or asc 
            });
        });
    </script>

</body>

</html>