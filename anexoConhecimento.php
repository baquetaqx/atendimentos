<?php
    session_start();
    $recursos = filter_input_array(INPUT_GET, FILTER_DEFAULT);
    $id= $recursos['id'];

    include 'dao/securityUrlAnexo.php';
    $redi = verificarid($id);
    if (!$redi) {
        $redirect = "index.php";
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

    <title>FMS Suporte - Anexos Conhecimentos</title>

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
    <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
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
                        Conhecimento
                        </h1>
                        <ol class="breadcrumb">
                        <li>
                                <i class="fa fa-dashboard"></i> <a href="index.php">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Conhecimento
                            </li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                <?php if(isset($_GET['msg']))
                    echo '<div class="alert alert-danger">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <strong>Erro! </strong>'.$_GET['msg'].'
                    </div>';
                ?>
        <!-- DataTables Example -->
        <?php
        $recursos = filter_input_array(INPUT_GET, FILTER_DEFAULT);
        $id= $recursos['id'];
        
      echo'
        <div class="card mb-3">
        <div class="card-body">
        <div class="table-responsive">';
        echo'
        <table id="dataTable" class="table table-striped table-bordered" width="100%" cellspacing="0">
                <form name="form" id="form" method="POST" enctype="multipart/form-data" action="dao/upload.php?id='.$id.'">
                    <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-6">
                        <div class="form-label-group">
                        <label for="firstName">Descrição do anexo:</label>
                            <input type="text" name="nome" id="firstName" required="required" class="form-control" placeholder="Descricao" autofocus="autofocus">
                            <br>
                            <input type="file" name="arquivo" required>
                            <br>
                            <br>
                            <button type="submit" class="btn btn-primary btn-block">Registrar</button>
                            <br>
                        </div>
                        </div>
                    </div>
                    </div>
                </form>

            <thead>
              <tr>
                <th>Descricao</th>
                <th>Excluir</th>
                <th>Download</th>
              </tr>
            </thead>';
            try{
              include 'dao/selectArquivos.php';
              $stmt = selectAnexos($id);
              $result = $stmt;
              
              echo '<tbody>';
                        if ( count($result) ) { 
                            foreach($result as $row) {  
                                echo '<tr>';
                                echo '<td> <center>'.$row['nome'].'</center></td>';
                                echo '<td><center><a class="btn btn-danger" href="dao/excluirArquivo.php?id='.$row['id'].'" > Excluir</a><center></td>';
                                echo '<td><center><a class="btn btn-primary" href="download.php?file='.$row['referencia'].'" > Download </a><center></td>';
                                echo'</tr>';
                                echo '</form>';
                            }                       
                        } else {
                            
                        }
                    } catch(PDOException $e) {
                        echo 'ERROR: ' . $e->getMessage();
                    }
                             
                  echo '</tbody>';  
                  echo '</table>';
                  ?>
                </div>
                <!-- /.row -->

                
                <!-- /.row -->

                <div class="row">

                </div>
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