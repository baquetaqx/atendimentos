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

    <title>FMS Suporte - Lista de Clientes</title>

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
                        Lista de Clientes
                        <a class="btn btn-success col-lg-2" href="cadastroCliente.php" style="float:right"><i class="fa fa-building"></i>Cad Clientes</a>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
                            </li>
                            <li>
                                <i class="fa fa-file"></i> Lista de Clientes
                            </li>
                        </ol>
                    </div>
                </div>

                <div class="row">
                    <!-- DataTables Example -->
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
                <th>CNPJ/CPF</th>
                <th>Situação</th>
                <th>Opções</th>
                
              </tr>
            </thead>';
            try{
              include 'dao/selectCliente.php';
              $stmt = selectCliente();
              $result = $stmt;
              echo '<tbody>';
                          if ( count($result) ) { 
                              
                            foreach($result as $row) {
                                $situacao=$row['situacao'];
                                if ($situacao==1){
                                    $situacao='Ativos';
                                }else if($situacao==2){
                                    $situacao='Inativo';
                                }else{
                                  $situacao='Suspender Suporte';
                                }

                                $bloqueado =$row['bloqueado'];
                                if ($bloqueado==1) {
                                  $bloqueado = 'Sim';
                                }else{
                                  $bloqueado = 'Nao';
                                }
                                $idCliente=$row['id'];
                            echo '<tr>';
                            echo '<td>'.$row['nomeFantasia'].'</td>';
                            echo '<td>'.$row['razaoSocial'].'</td>';
                            echo '<td>'.$row['cpfCnpj'].'</td>';
                            echo '<td>'.$situacao.'</td>';
                            echo '<td> <center>
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modalExibir'.$idCliente.'">Exibir</button>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalEditar'.$idCliente.'">Editar</button>
                             </center></td>';

                            //MODAL EXIBIR CLIENTES
                            echo '
                            <div class="modal fade" id="modalExibir'.$idCliente.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Consulta de Clientes</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>
                                  <div class="modal-body">
                                    
                                      <p>Nome Fantasia: <b>'.$row['nomeFantasia'].'</b></p>
                                      <p>Razão Social: <b>'.$row['razaoSocial'].'</b></p>
                                      <p>CPNJ/CPF: <b>'.$row['cpfCnpj'].'</b></p>
                                      <p>Endereco: <b>'.$row['endereco'].'</b></p>
                                      <p>Bairro: <b>'.$row['bairro'].'</b></p>
                                      <p>Numero: <b>'.$row['numero'].'</b></p>
                                      <p>Cep: <b>'.$row['cep'].'</b></p>
                                      <p>Cidade: <b>'.$row['cidade'].'</b></p>
                                      <p>Telefone 1: <b>'.$row['telefone1'].'</b></p>
                                      <p>Telefone 2: <b>'.$row['telefone2'].'</b></p>
                                      <p>Situação: <b>'.$situacao.'</b></p>
                                      <p>Observação: <b>'.$row['observacao'].'</b></p>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                  </div>
                                </div>
                              </div>
                            </div>';
                           
                            //MODAL Editar
                            echo '
                            <div class="modal fade" id="modalEditar'.$idCliente.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog modal-lg" role="document">
                              <form method="POST" action="dao/editCliente.php" autocomplete="off">
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
                                            <input type="text" value="'.$row['nomeFantasia'].'" id="firstName" name="nomeFantasia" class="form-control" placeholder="Nome Fantasia" required="required" autofocus="autofocus">
                                            <br>

                                            <p>Endereco:
                                            <input type="text" value="'.$row['endereco'].'" name="endereco" class="form-control" placeholder="Endereço" required="required" autofocus="autofocus">
                                            <br>
                                            
                                            <p>Cidade:
                                            <input type="text" value="'.$row['cidade'].'" name="cidade" class="form-control" placeholder="Cidade" required="required" autofocus="autofocus">
                                            <br>
                                            
                                            <p>Telefone 1:
                                            <input type="text" value="'.$row['telefone1'].'" name="telefone1" class="form-control" placeholder="Telefone 1" required="required" autofocus="autofocus">
                                            <br>
                                            
                                            <p>Telefone 2:
                                            <input type="text" value="'.$row['telefone2'].'" name="telefone2" class="form-control" placeholder="Telefone 2" autofocus="autofocus">
                                        </div>
                                    <div class="form-group col-lg-6">
                                        <p>Razao Social:
                                        <input type="text" value="'.$row['razaoSocial'].'" name="razaoSocial" class="form-control" placeholder="Razão Social" required="required" autofocus="autofocus">
                                          <br>

                                          <p>Bairro:
                                        <input type="text" value="'.$row['bairro'].'" name="bairro" class="form-control" autofocus="autofocus">
                                        <br>
                                        
                                        <p>Numero:
                                        <input type="text" value="'.$row['numero'].'" id="firstName" name="numero" class="form-control" autofocus="autofocus">
                                        <br>

                                        <p>CEP:
                                        <input type="text" value="'.$row['cep'].'" id="firstName" name="cep" class="form-control" autofocus="autofocus">
                                        <br>

                                        <p>CPF / CNPJ:
                                        <input type="text" value="'.$row['cpfCnpj'].'" id="firstName" name="cpfCnpj" class="form-control" placeholder="CPF/CNPJ" required="required" autofocus="autofocus">         
                                        
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <p>Situação:
                                        <select class="form-control" name="situacao">
                                            <option value="1"'; if($situacao=='Ativo'){echo 'selected';} echo' >Ativo</option>
                                            <option value="2"'; if($situacao=='Inativo'){echo 'selected';} echo'>Inativo</option>
                                            <option value="3"'; if($situacao=='Suspender Suportes'){echo 'selected';} echo'>Suspender Suporte</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-lg-6">
                                      <label>Bloqueado?:</label>
                                      <select class="form-control" name="bloqueado">
                                        <option value="1"'; if($bloqueado=='Sim'){echo 'selected';} echo'>Sim</option>
                                        <option value="2"'; if($bloqueado=='Nao'){echo 'selected';} echo'>Nao</option>
                                      </select>
                                    </div>
                                    <div class="form-group col-lg-12">
                                      <p>Observacao:
                                      <textarea class="form-control rounded-0" name="observacao" rows="5" >'.$row['observacao'].'</textarea>
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
    $(document).ready(function(){
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

<script>
$('.fone1').mask('(00) 0000-00009');
$('.fone1').blur(function(event) {
   if($(this).val().length == 15){ // Celular com 9 dígitos + 2 dígitos DDD e 4 da máscara
      $('.fone1').mask('(00) 00000-0009');
   } else {
      $('.fone1').mask('(00) 0000-00009');
   }
});
    </script>

<script>
$('.fone2').mask('(00) 0000-00009');
$('.fone2').blur(function(event) {
   if($(this).val().length == 15){ // Celular com 9 dígitos + 2 dígitos DDD e 4 da máscara
      $('.fone2').mask('(00) 00000-0009');
   } else {
      $('.fone2').mask('(00) 0000-00009');
   }
});
    </script>
</body>

</html>