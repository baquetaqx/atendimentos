<?php
    if (isset($_POST["dtInicial"], $_POST["dtFinal"])) {
        include 'dao/conexao.php';
        $output='';
        $conn = getConnection();
        $idUsuario=$_POST['idUsuario'];
        $idCliente=$_POST['idCliente'];
        $categoria=$_POST['categoria'];
        $subcategoria=$_POST['subcategoria'];
        if ($subcategoria=="Selecione a subcategoria") {
            $subcategoria="";
        }

        if ($idUsuario!="" && $idCliente!="" && $categoria!="" && $subcategoria!="") {
            $sql = "SELECT * FROM atendimento WHERE categoria=$categoria and subcategoria=$subcategoria and idUsuario=$idUsuario AND idCliente=$idCliente AND dataAtendimento BETWEEN"." '". $_POST['dtInicial']."' "." AND "." '".$_POST['dtFinal']."'";
        }else if($idUsuario!="" && $categoria!="" && $subcategoria!="" && $idCliente==""){
            $sql = "SELECT * FROM atendimento WHERE idUsuario=$idUsuario and categoria=$categoria and subcategoria=$subcategoria AND dataAtendimento BETWEEN"." '". $_POST['dtInicial']."' "." AND "." '".$_POST['dtFinal']."'";
        }else if($idUsuario=="" && $categoria!="" && $subcategoria!="" && $idCliente!=""){
            $sql = "SELECT * FROM atendimento WHERE idCliente=$idCliente and categoria=$categoria and subcategoria=$subcategoria AND dataAtendimento BETWEEN"." '". $_POST['dtInicial']."' "." AND "." '".$_POST['dtFinal']."'";
        }else if($idUsuario=="" && $categoria!="" && $subcategoria!="" && $idCliente==""){
            $sql = "SELECT * FROM atendimento WHERE categoria=$categoria and subcategoria=$subcategoria AND dataAtendimento BETWEEN"." '". $_POST['dtInicial']."' "." AND "." '".$_POST['dtFinal']."'";
        }else if($idUsuario=="" && $categoria!="" && $subcategoria=="" && $idCliente==""){
            $sql = "SELECT * FROM atendimento WHERE categoria=$categoria AND dataAtendimento BETWEEN"." '". $_POST['dtInicial']."' "." AND "." '".$_POST['dtFinal']."'";
        }else if($idUsuario!="" && $categoria!="" && $subcategoria=="" && $idCliente==""){
            $sql = "SELECT * FROM atendimento WHERE idUsuario = $idUsuario and categoria=$categoria AND dataAtendimento BETWEEN"." '". $_POST['dtInicial']."' "." AND "." '".$_POST['dtFinal']."'";
        }else if($idUsuario!="" && $categoria=="" && $subcategoria=="" && $idCliente==""){
            $sql = "SELECT * FROM atendimento WHERE idUsuario = $idUsuario AND dataAtendimento BETWEEN"." '". $_POST['dtInicial']."' "." AND "." '".$_POST['dtFinal']."'";
        }else if($idUsuario=="" && $categoria=="" && $subcategoria=="" && $idCliente!=""){
            $sql = "SELECT * FROM atendimento WHERE idCliente = $idCliente AND dataAtendimento BETWEEN"." '". $_POST['dtInicial']."' "." AND "." '".$_POST['dtFinal']."'";
        }else if($idUsuario!="" && $categoria=="" && $subcategoria=="" && $idCliente!=""){
            $sql = "SELECT * FROM atendimento WHERE idCliente = $idCliente and idUsuario=$idUsuario AND dataAtendimento BETWEEN"." '". $_POST['dtInicial']."' "." AND "." '".$_POST['dtFinal']."'";
        }else{
            $sql = "SELECT * FROM atendimento WHERE dataAtendimento BETWEEN"." '". $_POST['dtInicial']."' "." AND "." '".$_POST['dtFinal']."'";
        }
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $dados = $stmt->fetchAll(PDO::FETCH_OBJ);    
        
        echo'<table id="order_table" class="table table-striped table-bordered" width="100%" cellspacing="0">
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
            include 'dao/selectUsuario.php';
            include 'dao/selectClientes.php';
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
                                            <option value="1"'; if($situacao == 'Concluido'){echo 'selected';} echo '>Concluido</option>
                                            <option value="2"'; if($situacao == 'Pendente'){echo 'selected';} echo '>Pendente</option>
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
            
    }  
?>