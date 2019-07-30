<?php
require('../fpdf/fpdf.php');
session_start();
$idOS = $_GET['id'];
class PDF extends FPDF
{
    // Page header
    function Header()
    {
        $idOS = $_GET['id'];
        // Logo
        $this->Image('../img/logo.png',9,11,36);
        // Arial bold 15
        $this->SetFont('Arial','B',9);
        // Move to the right
        $this->Cell(1);
        // Title
        $this->Cell(60,19,"Ordem nº - $idOS",0,1,'R');
        // Line break
        $this->Ln(2);
    }

    // Page footer  
}

// Instanciation of inherited class
include '../dao/selectOrdemServico.php';
include '../dao/selectCliente.php';
include '../dao/selectUsuario.php';
include '../dao/selectProduto.php';
include '../dao/selectOrdemProduto.php';
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
                        $pdf = new PDF('P', "mm",array(80,10000));
                        $pdf->AddPage();
                        $pdf->SetFont('Arial','B',6);
                        $pdf->Cell(20,4,"CPF/CNPJ",1,0,'L');
                        $pdf->Cell(40,4,"Nome Fantasia",1,1,'L');

                        $pdf->SetFont('');
                        $pdf->Cell(20,4,$rowCliente['cpfCnpj'],0,0,'L');
                        $pdf->MultiCell(40, 3,$rowCliente['nomeFantasia'],0, 'J');

                        
                        $pdf->SetFont('Arial','B',6);
                        $pdf->Cell(60,4,"Razão Social/Endereço",1,1,'L');

                        $pdf->SetFont('');
                        $pdf->Cell(30,4,$rowCliente['razaoSocial'].'/',0,1,'L');
                        $pdf->Cell(30,4,$rowCliente['endereco'],0,1,'L');
                        
                        $pdf->SetFont('Arial','B',6);
                        $pdf->Cell(20,4,"Telefone",1,1,'L');

                        $pdf->SetFont('');
                        $pdf->Cell(20,4,$rowCliente['telefone1'],0,1,'L');
                        $pdf->Ln(4);
                        //$pdf->Line(10, 45, 110-20, 45);

                        $pdf->SetFont('Arial','B',6);
                        $pdf->Cell(20,4,"Dt Lançamento",1,0,'L');
                        $pdf->Cell(15,4,"Software",1,0,'L');
                        $pdf->Cell(25,4,"Atendimento",1,1,'L');

                        $pdf->SetFont('');
                        $pdf->Cell(20,4,$data,0,0,'L');
                        $pdf->Cell(15,4,$software,0,0,'L');
                        $pdf->Cell(25,4,$tipoAtendimento,0,1,'L');

                        $pdf->SetFont('Arial','B',6);
                        $pdf->Cell(30,4,"Técnico",1,0,'L');
                        $pdf->Cell(15,4,"Hora Entrada",1,0,'L');
                        $pdf->Cell(15,4,"Hora Saida",1,1,'L');

                        $pdf->SetFont('');
                        $pdf->Cell(30,4,$nomeUsuario,0,0,'L');
                        $pdf->Cell(15,4,$horaEntrada,0,0,'L');
                        $pdf->Cell(15,4,$horaSaida,0,1,'L');
                        $pdf->Ln(4);

                        $pdf->SetFont('Arial','B',6);
                        $pdf->Cell(60,4,"Ocorrência",1,1,'L');
                        $pdf->SetFont('');
                        $pdf->MultiCell(60, 3, str_replace("<br />","",$ocorrencia), 0, 'J');
                        $pdf->Ln(4);

                        $pdf->SetFont('Arial','B',6);
                        $pdf->Cell(60,4,"Solução",1,1,'L');
                        $pdf->SetFont('');
                        $pdf->MultiCell(60, 3, str_replace("<br />","",$solucao), 0, 'J');

                        $pdf->SetFont('Arial','B',6);
                        $pdf->Cell(60,4,"Observação",1,1,'L');
                        $pdf->SetFont('');
                        $pdf->MultiCell(60, 3, str_replace("<br />","",$observacoes), 0, 'J');

                        $pdf->Ln(6);
                        $pdf->Cell(60,0,"",1,1,'L');
                        $pdf->Ln(2);
                        $pdf->Cell(60,0,"Visto Supervisor/ Técnico ",0,1,'C');

                        $pdf->Ln(9);
                        $pdf->Cell(60,0,"",1,1,'L');
                        $pdf->Ln(2);
                        $pdf->Cell(60,0,"Cliente ",0,1,'C');

                        $pdf->Ln(10);
                        $pdf->Cell(60,0,"Data _____/_____/__________ ",0,1,'L');
                        
                        $pdf->Ln(10);
                        $pdf->Cell(60,0,"",0,1,'L');
                        $pdf->Output();

                    }
                }
            }
        }
    }
}



?>