<div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav side-nav">
                    <li class="active">
                        <a href="index.php"><i class="fa fa-fw fa-dashboard"></i> Inicio</a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#cadastro"><i
                                class="fa fa-fw fa-plus-circle"></i> Cadastro <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="cadastro" class="collapse">
                            <?php if($_SESSION['funcao']=="1" || $_SESSION['funcao']=='2'){
                                echo '<li>
                                        <a href="cadastroUsuario.php"> <i class="fa fa-fw fa-user"> </i> Usuários</a>
                                    </li>';
                                }
                        ?>
                            <li>
                                <a href="cadastroCliente.php"> <i class="fa fa-fw fa-building"> </i> Clientes</a>
                            </li>
                            <li>
                                <a href="cadastrarConhecimento.php"><i class="fa fa-fw fa-tree"></i> Árvore de
                                    conhecimento</a>
                            </li>
                            <?php if($_SESSION['funcao']=="1" || $_SESSION['funcao']=='2'){
                                echo '<li>
                                        <a href="cadastroProduto.php"> <i class="fa fa-fw fa-tasks"> </i> Produto</a>
                                    </li>';
                                }
                             ?>
                            <li>
                                <a href="cadastroCategoria.php"><i class="fa fa-fw fa-angle-right"></i> Categoria</a>
                            </li>
                            <li>
                                <a href="cadastroSubcategoria.php"><i class="fa fa-fw fa-angle-double-right"></i>
                                    Subcategoria</a>
                            </li>

                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#registro"><i
                                class="fa fa-fw fa-clipboard"></i> Registro <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="registro" class="collapse">
                            <li>
                                <a href="cadastroAtendimento.php"> <i class="fa fa-fw fa-phone"> </i> Atendimento</a>
                            </li>
                            <li>
                                <a href="cadastroServico.php"> <i class="fa fa-fw fa-paperclip"> </i> Ordem de
                                    serviço</a>
                            </li>
                            <li>
                                <a href="grfood.php"> <i class="fa fa-fw fa-book"> </i> GRFood</a>
                            </li>

                        </ul>
                    </li>

                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#lista"><i
                                class="fa fa-fw fa-book"></i> Lista <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="lista" class="collapse">
                            <?php if($_SESSION['funcao']=="1" || $_SESSION['funcao']=='2'){
                            echo '<li>
                                <a href="listaUsuarios.php"> <i class="fa fa-fw fa-user"> </i> Usuários</a>
                            </li>';
                        }
                        ?>
                            <?php if($_SESSION['funcao']=="1" || $_SESSION['funcao']=='2'){
                                echo '<li>
                                        <a href="listaProdutos.php"> <i class="fa fa-fw fa-tasks"> </i> Produtos</a>
                                    </li>';
                                }
                             ?>
                            
                            <li>
                                <a href="listaClientes.php"><i class="fa fa-fw fa-building"> </i> Clientes</a>
                            </li>

                            <li>
                                <a href="listaAtendimentos.php"><i class="fa fa-fw fa-phone"> </i> Atendimentos</a>
                            </li>

                            <li>
                                <a href="listaServicos.php"><i class="fa fa-fw fa-paperclip"> </i> Ordem de serviço</a>
                            </li>

                            <li>
                                <a href="listaCategoria.php"><i class="fa fa-fw fa-angle-right"> </i> Categorias</a>
                            </li>
                            <li>
                                <a href="listaSubcategoria.php"><i class="fa fa-fw fa-angle-double-right"> </i>
                                    Subcategorias</a>
                            </li>
                            <li>
                                <a href="listaGRFood.php"> <i class="fa fa-fw fa-book"> </i> GRFood</a>
                            </li>
                        </ul>
                    </li>
                    
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#relatorios"><i
                                class="fa fa-fw fa-clipboard"></i> Relatórios <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="relatorios" class="collapse">
                           <!-- <li>
                                <a href="relatorioAtendimentos.php"> <i class="fa fa-fw fa-building"> </i> Clientes</a>
                            </li>
                            -->
                            <li>
                                <a href="relatorioAtendimentos.php"> <i class="fa fa-fw fa-phone"> </i> Atendimentos</a>
                            </li>

                        </ul>
                    </li>

                    <li>
                        <a href="conhecimento.php"><i class="fa fa-fw fa-tree"></i> Árvore de conhecimento</a>
                    </li>
                    
                    

                </ul>
            </div>