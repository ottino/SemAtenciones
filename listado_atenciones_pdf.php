<?php
require('fpdf.php');

class PDF extends FPDF
{
//Cabecera de página
function Header()
{
    //Logo
    $this->Image('imagenes\Logo_a_tiempo2.jpg',10,8,10);
    //Arial bold 15
    $this->SetFont('Arial','B',10);
    //Movernos a la derecha
    $this->Cell(125);
    //Título
    $this->Cell(30,10,'Listado de atenciones',0,0,'C');
    //Salto de línea
    $this->Ln(15);
}

//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
    $this->SetY(-15);
    //Arial italic 8
    $this->SetFont('Arial','I',8);
    //Número de página
    $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');
}
}

//Creación del objeto de la clase heredada
$pdf=new PDF('L','mm','A4');

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',7);
$pdf->Cell(1);
$pdf->Cell(0,5,'ID      FECHA       PLAN             NOMBRE               FONO       E 	S             CALLE             NRO            LOCALIDAD    OPERADOR  COL   MEDICO           C.MED            COS   M G LLAM    DESP      SAL       LLEG        SAL      DIS      DIAGNOSTICO',0,1,'L');
for($i=1;$i<=40;$i++)
   {
	$pdf->Cell(0,5,'xxx',0,1,'R');
   }
$pdf->Output();
?>  


