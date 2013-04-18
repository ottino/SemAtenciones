<?php
require('fpdf.php');

class pdf extends FPDF
{

    public function Header(){
    }

    public function Footer(){
    }
}

$pdf=new PDF('P','cm','A4');


$pdf->SetFont('Arial','U',4.4);
$pdf->SetY(4);
$pdf->SetX(4);
$pdf->Cell(3.5,0.22,'Abonado');

$pdf->Output();

?>
