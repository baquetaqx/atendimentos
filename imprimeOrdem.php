<?php 
    include("mpdf60/mpdf.php");
    $aspaSimples="'"; 

    $idOS = $_GET['id'];

    include 'dao/selectOrdemServico.php';
    include 'dao/selectCliente.php';
    include 'dao/selectUsuario.php';
    include 'dao/selectProduto.php';
    include 'dao/selectOrdemProduto.php';
    $stmt = selectOrdemServicoPorId($idOS);
    $result = $stmt;

    if ( count($result) ) { 
        foreach($result as $row) {
            $usuario=$row['idUsuario'];
            $data =date("d/m/Y", strtotime($row['dataLancamento']));
            $ocorrencia=$row['ocorrencia'];
            $solucao=$row['solucao'];
            $horaEntrada=$row['horaEntrada'];
            $horaSaida=$row['horaSaida'];
            $observacoes=$row['observacoes'];
            $tipoAtendimento=$row['tipoAtendimento'];
            if ($tipoAtendimento==1) {
                $tipoAtendimento='Externo';
            }else if($tipoAtendimento==2){
                $tipoAtendimento='Assistência Técnica';
            }else if($tipoAtendimento==3){
                $tipoAtendimento='Serviço Interno';
            }else{
                $tipoAtendimento='Treinamento';
            }

            $software=$row['software'];
            if ($software==1) {
                $software='ACS';
            }else if ($software==2) {
                $software='SysLoja';
            }else if($software==3){
                $software='GRFood';
            }else{
                $software='-----';
            }

            $situacao=$row['situacao'];
            if ($situacao==1){
                $situacao='Ativo';
            }else{
                $situacao='Inativo';
            }

            $stmtCliente = selectClienteById($row['idCliente']);
            $resultCliente = $stmtCliente;
            if (count($resultCliente)) {
                foreach($resultCliente as $rowCliente) {

                    $stmtUsuario = selectUsuariosById($usuario);
                    $resultUsuario = $stmtUsuario;
                    if (count($resultUsuario)) {
                        foreach($resultUsuario as $rowUsuario) {
                            $nomeUsuario = $rowUsuario['nome'];
                                $html = '<!DOCTYPE html>
                                <html>
                                    <head>
                                    
                                    </head>
                                    <body>
                                        <div style="border: 1px solid">
                                            <img src="img/logo.png" style="float:left" />
                                            <div style="margin:0px 10px 0px 15px">
                                                <b><label>FREDERICO DE MENEZES SANT'.$aspaSimples.'ANA ME</label></b>
                                                <br>
                                                Rua Oscar Barbosa - 483
                                                <br>
                                                Centro - CEP: 63980-230
                                                <br>
                                                Tel: (88) 3412.3090 - Quixadá-Ce
                                                <br>
                                                <b>ORDEM DE SERVIÇO Nº: '.$row['id'].' </b>
                                            </div>
                                        </div>
                                    
                                        <table style="width:100%; margin-top:10px">
                                            <tr>
                                                <th style="text-align:left; font-size:11px margin:0;">CPF/CNPJ</th>
                                                <th style="text-align:left; font-size:11px margin:0;">Nome Fantasia</th> 
                                                <th style="text-align:left; font-size:11px margin:0;">Razão Social</th>
                                            </tr>
                                            <tr>
                                                <td style="text-align:left; font-size:11px; margin:0;">'.$rowCliente['cpfCnpj'].' &nbsp;&nbsp;&nbsp;</td>
                                                <td style="text-align:left; font-size:11px; margin:0;">'.$rowCliente['nomeFantasia'].' &nbsp;&nbsp;&nbsp;</td> 
                                                <td style="text-align:left; font-size:11px; margin:0;">'.$rowCliente['razaoSocial'].' &nbsp;&nbsp;&nbsp;</td>
                                            </tr>
                                        </table>
    
                                        <table style="width:65%;">
                                            <tr>
                                                <th style="text-align:left; font-size:11px margin:0;">Endereço</th>
                                                <th style="text-align:left; font-size:11px margin:0;">Cidade</th> 
                                            </tr>
                                            <tr>
                                                <td style="text-align:left; font-size:11px; margin:0;">'.$rowCliente['endereco'].' </td>
                                                <td style="text-align:left; font-size:11px; margin:0;">'.$rowCliente['cidade'].' </td> 
                                            </tr>
                                        </table>
    
                                        <table style="width:65%;">
                                            <tr>
                                                <th style="text-align:left; font-size:11px margin:0;">Telefone</th>
                                            </tr>
                                            <tr>
                                                <td style="text-align:left; font-size:11px; margin:0;">'.$rowCliente['telefone1'].'/'.$rowCliente['telefone2'].' </td>
                                            </tr>
                                        </table>
                                        <hr style="margin:0">
    
                                        <table style="width:90%;">
                                            <tr>
                                                <th style="text-align:left; font-size:11px margin:0;">Data Lançamento</th>
                                                <th style="text-align:left; font-size:11px margin:0;">Software</th>
                                                <th style="text-align:left; font-size:11px margin:0;">Tipo de Atendimento</th>
                                            </tr>
                                            <tr>
                                                <td style="text-align:left; font-size:11px; margin:0;">'.$data.' </td>
                                                <td style="text-align:left; font-size:11px; margin:0;">'.$software.' </td>
                                                <td style="text-align:left; font-size:11px; margin:0;">'.$tipoAtendimento.' </td>
                                            </tr>
                                        </table>
    
                                        <table style="width:100%;">
                                            <tr>
                                                <th style="text-align:left; font-size:11px">Técnico</th>
                                                <th style="text-align:left; font-size:11px">Hora de Entrada</th>
                                                <th style="text-align:left; font-size:11px">Hora de Saída</th>
                                            </tr>
                                            <tr>
                                                <td style="text-align:left; font-size:11px; margin:0;">'.$nomeUsuario.' </td>
                                                <td style="text-align:left; font-size:11px; margin:0;">'.$horaEntrada.' </td>
                                                <td style="text-align:left; font-size:11px; margin:0;">'.$horaSaida.' </td>
                                            </tr>
                                        </table>
                                        <hr style="margin:0">
                                        <p style="margin:0; font-size:11px"><b>Ocorrência</b></p>
                                        <p style="margin:0; font-size:11px">'.$ocorrencia.'</p>
                                        <p style="margin-bottom:0; font-size:11px"><b>Observação do equipamento</b></p>
                                        <p style="margin:0; font-size:11px">'.$observacoes.'</p>
                                        <p align="justify" style="margin-bottom:0; font-size:11px"><b>Solução</b></p>
                                        <p align="justify" style="margin:0; font-size:11px">'.$solucao.'</p>
                                        <p align="justify" style="margin-bottom:0; font-size:12px"><b>Serviços</b></p>
                                        <table style="width:100%;">
                                            <tr>
                                                <th style="text-align:left; font-size:11px">Produto</th>
                                                <th style="text-align:left; font-size:11px">Val Unitário</th>
                                                <th style="text-align:left; font-size:11px">Qtde</th>
                                                <th style="text-align:left; font-size:11px">Val Total</th>
                                            </tr>';
                                            
                                        $stmtOrdemProduto = selectOrdemProduto($idOS);
                                        $resultOrdemProduto = $stmtOrdemProduto;
                                        if ( count($resultOrdemProduto) ) { 
                                            foreach($resultOrdemProduto as $rowOrdemProduto) {

                                                $stmtProduto = selectProdutoPorId($rowOrdemProduto['idProduto']);
                                                $resultProduto = $stmtProduto;
                                                if ( count($resultProduto) ) { 
                                                    foreach($resultProduto as $rowProduto) {
                                                        $quantidadeProduto = $rowOrdemProduto['quantidade'];
                                                        $valorUnitario = $rowOrdemProduto['valorUnitario'];
                                                        $valorTotalProduto = $rowOrdemProduto['valor'];
                                                        $nomeProduto=$rowProduto['nome'];
                                                        $valorTotal = $valorTotal+$valorTotalProduto;
                                                        $html .='<tr>
                                                                    <td style="text-align:left; font-size:11px; margin:0;">'.$nomeProduto.' </td>
                                                                    <td style="text-align:left; font-size:11px; margin:0;">R$ '.str_replace('.',',', $valorUnitario).' </td>
                                                                    <td style="text-align:left; font-size:11px; margin:0;">'.$quantidadeProduto.' </td>
                                                                    <td style="text-align:left; font-size:11px; margin:0;">R$ '.str_replace('.',',', $valorTotalProduto).' </td>
                                                                </tr>';
                                                    }
                                                }
                                            }
                                        }
                                        $html.='</table>
                                        <p align="justify" style="margin-bottom:0; font-size:11px"><b>Total da OS: R$ '.str_replace('.',',', number_format($valorTotal,2)).' </b></p>
                                        <hr>
                                        <br>
                                        <br>
                                        <table style="width:100%;">
                                            <tr>
                                                <th style="text-align:left; font-size:11px">________________________________________________________________</th>
                                                <th style="text-align:left; font-size:11px">________________________________________________________________</th>
                                            </tr>
                                            <tr>
                                                <td style="text-align:center; font-size:11px; margin:0;">Visto Supervisor/ Técnico </td>
                                                <td style="text-align:center; font-size:11px; margin:0;">Cliente</td>
                                            </tr>
                                        </table>
                                        <br>
                                        <p align="justify" style="margin-bottom:0; font-size:12px"><b>Data:______/_______/___________</b></p>
                                        </body>
                                    </html>';                    
                        }
                    }
                }
            }
        }
    }
    $mpdf=new mPDF(); 
    
 $mpdf->allow_charset_conversion=true;
 $mpdf->charset_in='UTF-8';

 $mpdf->SetDisplayMode('fullwidth');
 $mpdf->WriteHTML($html);
 $mpdf->Output('OS Nº '.$idOS.'.pdf', 'I');

 exit;
 ?>