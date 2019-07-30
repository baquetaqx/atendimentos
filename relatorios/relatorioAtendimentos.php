<?php 
    include("../mpdf60/mpdf.php");
    $aspaSimples="'"; 

    $idCliente = $_POST['idCliente'];
    $idUsuario = $_POST['idUsuario'];
    $dtInicial = $_POST['dtInicial'];
    $dtFinal = $_POST['dtFinal'];
    $visualizacao = $_POST['visualizacao'];
    $categoria = "categoria LIKE '%".$_POST['categoria']."%'";
    $subcategoria = $_POST['subcategoria'];

    if ($subcategoria == "Selecione a subcategoria") {
        $subcategoria = "subcategoria LIKE '%%'";
    }else{
        $subcategoria = "subcategoria LIKE '%".$_POST['subcategoria']."%'";
    }

    
    if ($idUsuario=="") {
        $idUsuario="idUsuario LIKE '%%' ";
    }else{
        $idUsuario='idUsuario ='.$_POST['idUsuario'].' ';
    }
  
        $idCliente="idCliente LIKE '%".substr($_POST['idCliente'],0,3)."%' ";

    include '../dao/conexao.php';
    include '../dao/selectCliente.php';
    include '../dao/selectUsuario.php';
    $sqlCliente ="SELECT COUNT(idCliente) as qtdCliente, COUNT(CASE WHEN situacao=1 THEN situacao END) AS Concluido, COUNT(CASE WHEN situacao=2 THEN situacao END) AS Pendente, COUNT(situacao) as Total, idCliente from atendimento WHERE $categoria and $subcategoria and dataAtendimento BETWEEN '$dtInicial' and '$dtFinal' AND $idCliente GROUP BY idCliente ORDER BY Total DESC";
    $sqlUsuario ="SELECT COUNT(idUsuario) as qtdUsuario, COUNT(CASE WHEN situacao=1 THEN situacao END) AS Concluido, COUNT(CASE WHEN situacao=2 THEN situacao END) AS Pendente, COUNT(situacao) as Total, idUsuario from atendimento WHERE $categoria and $subcategoria and dataAtendimento BETWEEN '$dtInicial' and '$dtFinal' AND $idUsuario GROUP BY idUsuario ORDER BY Total DESC";
    $sqlDetalhado= "SELECT * FROM atendimento WHERE $categoria and $subcategoria and $idUsuario and $idCliente and dataAtendimento BETWEEN '$dtInicial' and '$dtFinal' ORDER BY dataAtendimento DESC";
    try {
        if ($visualizacao=="detalhado") {

        
        $conn = getConnection();
        $stmt = $conn->prepare($sqlDetalhado);
        $stmt->execute();
        $result = $stmt->fetchAll();

        $html = '<!DOCTYPE html>
        <html>
            <head>
                <title>Relatorio de Atendimento</title>
            </head>
            <body>
                <div style="border: 1px solid">
                    <img src="../img/logo.png" style="float:left" />
                    <div style="margin:0px 10px 0px 15px">
                        <b><label>FREDERICO DE MENEZES SANT'.$aspaSimples.'ANA ME</label></b>
                        <br>
                        Rua Oscar Barbosa - 483
                        <br>
                        Centro - CEP: 63900-089
                        <br>
                        Tel: (88) 3412.3090 - Quixadá-Ce
                        <br>
                        <b>Relatório de Atendimento Período '.date("d/m/Y", strtotime($dtInicial)).' - '.date("d/m/Y", strtotime($dtFinal)).'</b>
                    </div>
                </div>
                <table border=1 style="width:100%; margin-top:10px; border-collapse: collapse">
                    <tr>
                    <th style="text-align:left; font-size:11px margin:0;">Dt Lanc</th>
                        <th style="text-align:left; font-size:11px margin:0;">Técnico</th>
                        <th style="text-align:left; font-size:11px margin:0;">Cliente</th> 
                        <th style="text-align:left; font-size:11px margin:0;">Desc Problema</th>
                        <th style="text-align:left; font-size:11px margin:0;">Desc Solução</th>
                    </tr>';

        if (count($result)) {
            foreach($result as $row) {

                $stmtCliente = selectClienteById($row['idCliente']);
                $resultCliente = $stmtCliente;
                if (count($resultCliente)) {
                    foreach($resultCliente as $rowCliente) {
                        $nomeCliente = $rowCliente['nomeFantasia'];

                        $stmtUsuario = selectUsuariosById($row['idUsuario']);
                        $resultUsuario = $stmtUsuario;
                        if (count($resultUsuario)) {
                            foreach($resultUsuario as $rowUsuario) {
                                $nomeUsuario = $rowUsuario['usuario'];

                                $html .='
                                    <tr>
                                        <td style="text-align:left; font-size:11px; margin:0;">'.date("d/m/Y", strtotime($row['dataAtendimento'])).' &nbsp;&nbsp;&nbsp;</td>
                                        <td style="text-align:left; font-size:11px; margin:0;">'.$nomeUsuario.' &nbsp;&nbsp;&nbsp;</td>
                                        <td style="text-align:left; font-size:11px; margin:0;">'.$nomeCliente.' &nbsp;&nbsp;&nbsp;</td> 
                                        <td style="text-align:left; font-size:11px; margin:0;">'.$row['descProblema'].' &nbsp;&nbsp;&nbsp;</td>
                                        <td style="text-align:left; font-size:11px; margin:0;">'.$row['descSolucao'].' &nbsp;&nbsp;&nbsp;</td>
                                    </tr>
                                    ';
                            }
                        }
                    }
                }
            }
        }       
        $html .='
                    </table>
                </body>
            </html>';           
        }else if ($visualizacao=="cliente") {

            $conn = getConnection();
            $stmt = $conn->prepare($sqlCliente);
            $stmt->execute();
            $result = $stmt->fetchAll();

            $html='<!DOCTYPE html>
            <html>
                <head>
                    <title>Relatorio de Atendimento</title>
                </head>
                <body>
                <div style="border: 1px solid">
                    <img src="../img/logo.png" style="float:left" />
                    <div style="margin:0px 10px 0px 15px">
                        <b><label>FREDERICO DE MENEZES SANT'.$aspaSimples.'ANA ME</label></b>
                        <br>
                        Rua Oscar Barbosa - 483
                        <br>
                        Centro - CEP: 63980-230
                        <br>
                        Tel: (88) 3412.3090 - Quixadá-Ce
                        <br>
                        <b>Relatório de Atendimento Quantitativo Cliente Período '.date("d/m/Y", strtotime($dtInicial)).' - '.date("d/m/Y", strtotime($dtFinal)).'</b>
                    </div>
                </div>
                <table border=1 style="width:100%; margin-top:10px; border-collapse: collapse">
                <tr>
                    <th style="text-align:left; font-size:11px margin:0;">Cliente</th> 
                    <th style="text-align:left; font-size:11px margin:0;">Pendente</th>
                    <th style="text-align:left; font-size:11px margin:0;">Concluido</th>
                    <th style="text-align:left; font-size:11px margin:0;">Total</th>
                </tr>';

                if (count($result)) {
                    foreach($result as $row) {
                        $stmtCliente = selectClienteById($row['idCliente']);
                        $resultCliente = $stmtCliente;
                        if (count($resultCliente)) {
                            foreach($resultCliente as $rowCliente) {
                                $nomeCliente = $rowCliente['nomeFantasia'];
                                $totalSuportes = $totalSuportes+$row['Total'];
                                $html .='
                                <tr>
                                    <td style="text-align:left; font-size:11px; margin:0;">'.$nomeCliente.' &nbsp;&nbsp;&nbsp;</td>
                                    <td style="text-align:left; font-size:11px; margin:0;">'.$row['Pendente'].' &nbsp;&nbsp;&nbsp;</td>
                                    <td style="text-align:left; font-size:11px; margin:0;">'.$row['Concluido'].' &nbsp;&nbsp;&nbsp;</td> 
                                    <td style="text-align:left; font-size:11px; margin:0;">'.$row['Total'].' &nbsp;&nbsp;&nbsp;</td>
                                </tr>
                                ';

                            }
                        }
                    }
                }

                $html .='
                            </table>
                            <p align="right" style="margin-bottom:0; font-size:12px"><b>Total: </b>'.$totalSuportes.'</p>
                        </body>
                    </html>';  
        }else if ($visualizacao=="usuario") {

            $conn = getConnection();
            $stmt = $conn->prepare($sqlUsuario);
            $stmt->execute();
            $result = $stmt->fetchAll();

            $html='<!DOCTYPE html>
            <html>
                <head>
                    <title>Relatorio de Atendimento</title>
                </head>
                <body>
                <div style="border: 1px solid">
                    <img src="../img/logo.png" style="float:left" />
                    <div style="margin:0px 10px 0px 15px">
                        <b><label>FREDERICO DE MENEZES SANT'.$aspaSimples.'ANA ME</label></b>
                        <br>
                        Rua Oscar Barbosa - 483
                        <br>
                        Centro - CEP: 63980-230
                        <br>
                        Tel: (88) 3412.3090 - Quixadá-Ce
                        <br>
                        <b>Relatório de Atendimento Quantitativo Usuário Período '.date("d/m/Y", strtotime($dtInicial)).' - '.date("d/m/Y", strtotime($dtFinal)).'</b>
                    </div>
                </div>
                <table border=1 style="width:100%; margin-top:10px; border-collapse: collapse">
                <tr>
                    <th style="text-align:left; font-size:11px margin:0;">Técnico</th> 
                    <th style="text-align:left; font-size:11px margin:0;">Pendente</th>
                    <th style="text-align:left; font-size:11px margin:0;">Concluido</th>
                    <th style="text-align:left; font-size:11px margin:0;">Total</th>
                </tr>';

                if (count($result)) {
                    foreach($result as $row) {

                        $stmtUsuario = selectUsuariosById($row['idUsuario']);
                        $resultUsuario = $stmtUsuario;
                        if (count($resultUsuario)) {
                            foreach($resultUsuario as $rowUsuario) {
                                $nomeUsuario = $rowUsuario['usuario'];
                                $totalSuportes = $totalSuportes+$row['Total'];
                                $html .='
                                <tr>
                                    <td style="text-align:left; font-size:11px; margin:0;">'.$nomeUsuario.' &nbsp;&nbsp;&nbsp;</td>
                                    <td style="text-align:left; font-size:11px; margin:0;">'.$row['Pendente'].' &nbsp;&nbsp;&nbsp;</td>
                                    <td style="text-align:left; font-size:11px; margin:0;">'.$row['Concluido'].' &nbsp;&nbsp;&nbsp;</td> 
                                    <td style="text-align:left; font-size:11px; margin:0;">'.$row['Total'].' &nbsp;&nbsp;&nbsp;</td>
                                </tr>
                                ';

                            }
                        }
                    }
                }

                $html .='
                            </table>
                            <p align="right" style="margin-bottom:0; font-size:12px"><b>Total: </b>'.$totalSuportes.'</p>
                        </body>
                    </html>';  
        }
        $mpdf=new mPDF('utf-8', 'A4-L'); 
        
        $mpdf->allow_charset_conversion=true;
        $mpdf->charset_in='UTF-8';

        $mpdf->SetDisplayMode('fullwidth');
        $mpdf->WriteHTML($html);
        $mpdf->Output('Atendimentos '.date("d/m/Y", strtotime($dtInicial)).' - '.date("d/m/Y", strtotime($dtFinal)).'.pdf', 'I');
    }catch(PDOException $e){
        echo 'Error: ' . $e->getMessage();
    }
    exit;
 ?>