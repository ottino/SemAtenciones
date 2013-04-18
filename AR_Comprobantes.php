<?
session_start();
######################INCLUDES################################
//archivo de configuracion
include_once ('config.php');

//funciones propias
include ('funciones.php');

//incluímos la clase ajax
require ('xajax/xajax.inc.php');

// libreria para crear pdf
require('fpdf.php');

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

################### Conexion a la base de datos##########################

$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

//echo titulo_encabezado ('Comprobantes' , $path_imagen_logo);
$segmenu = valida_menu();
//if ($segmenu <> "OK")
//  { mensaje_error ('Principal.php', 'Usuario no autorizado');
//   exit;
//  }

//Ejecutamos la sentencia SQL

$per     = $_POST["cla_periodo"];

$result=mysql_query("select *, b.observaciones as observa from comprobantes a, contratos b, clientes c, planes d, cobrador g where
                     a.idcontrato = b.idcontrato and b.idcliente = c.idcliente  and
                     b.idplan = d.idplan and b.codcobrador = g.idcob and a.tipocomprob = 'C'
                     and a.periodo = ".$per." order by cobrador, 1");


// obejetos
class PDF extends FPDF
{
//Cabecera de página
var $titulo;
function Header()
{

}

//Pie de página
function Footer()
{
    //Posición: a 1,5 cm del final
 //   $this->SetY(-5);
    //Arial italic 8
 //   $this->SetFont('Arial','I',8);
    //Número de página
 //   $this->Cell(0,10,'Pagina '.$this->PageNo().'/{nb}',0,0,'C');

}

} // cierre de class PDF extends FPDF

//
// PARAMETROS PARA LA SALIDA EN PDF
$pdf=new PDF('P','mm',array(210,330));
//$pdf->titulo = $literal;
$pdf->SetMargins(14,13);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',10);
//$pdf->Cell(1);
$pdf->AddFont('I2OF5NT','','i2of5nt.php'); //Fuente de windows convertida con el proceso.
$pdf->AddFont('v100015','','v100015.php'); //Fuente de windows convertida con el proceso.
$pdf->AddFont('v100017','','v100017.php'); //Fuente de windows convertida con el proceso.




//Mostramos los registros
while ($row=mysql_fetch_array($result))
{

$conta = $conta +1;

if ($conta == '4')
  {
    $conta = 1;
    $pdf->AddPage();
  }

$idcomprob =  $row["idcomprob"];
$codbarras =  $row["codbarras"];
$periodo   =  "Período: ".$row["periodo"];
$monto     =  $row["monto"];
$desccob   =  $row["desccob"];
$calle     =  $row["callecob"];
$nrocalle  =  $row["nrocallecob"];
$entre1    =  $row["entre1"];
$entre2    =  $row["entre2"];
$piso      =  $row["pisocob"];
$depto     =  $row["deptocob"];
$barrio    =  $row["barriocob"];
$localidad =  $row["localidadcob"];
$provincia =  $row["provinciacob"];
$cpostal   =  $row["cpostalcob"];
$cobrador  =  $row["desccob"];
$telefono  =  $row["telefonocob"];
$observaciones = "OBS: ".$row["observa"];
$plan      =  $row["descabrev"];
$idplan    =  $row["idplan"];
$ordenmax  =  $row[ordenmax];
$fechavto  =  cambiarFormatoFecha($row["fechavto"]);
$leyenda   =  $row[leyenda];
$leyenda1  =  $row[leyenda1];

$sep       = ' - ';
$vacio     = '';
$direccion = $calle.$sep.$nrocalle.$sep.$entre1.$sep.$entre2.$sep.$piso.$sep.$depto.$sep.$barrio.$sep.$localidad.$sep.$provincia.$sep.$cpostal.$sep.$telefono;
$dir1      = "Calle: ".$calle;
$dir2      = "Nro: ".$nrocalle;
$dir3      = "Localidad: (".$cpostal.") - ".$localidad;

if ($piso == '0' || strlen($piso) == '0')
   $piso1 = "";
  else
   $piso1 = "Piso: ".$piso;

if (strlen($depto) == '0')
   $depto1 = "";
  else
   $depto1 = " Depto: ".$depto;

$dir4      = $piso1.$depto1." Barrio: ".$barrio." Tel: ".$telefono;
$dir5      = "Prov: ".$provincia;

$linea1 = "Socio: ".$row["nroafiliado"]." - ".substr($row['nombre'],0,25);
$linea2 = "Plan: ".$idplan." (".$plan.")";

$cobrador = "Cobrador: ".$desccob;
$vencimiento = "Vencimiento: ".$fechavto;
$importe = "Importe: $".$monto;
$hoy = date ("d-m-Y");

$lit = "Cobrador: ";
$imp = "Importe: $";

$pdf->Ln(25);
$pdf->Cell(40,5,$periodo,0);
$pdf->Cell(30,5,$hoy,0);
$pdf->Cell(40,5,$vacio,0);
$pdf->Cell(33,5,$idcomprob,0);
$pdf->Cell(46,5,$row["nroafiliado"]." / ".$idcomprob,1,0,'C');
$pdf->Ln(10);
$pdf->SetFont('Arial','',12);
$pdf->Cell(95,7,$linea1,0);
$pdf->SetFont('Arial','',10);
$pdf->Cell(48,7,$linea2,0);
$pdf->Cell(46,7,$linea2,0,0,'C');
$pdf->Ln(10);
$pdf->Cell(55,5,$cobrador,0);
$pdf->Cell(50,5,$vencimiento,0);
$pdf->Cell(38,5,$importe,0);
$pdf->Cell(46,5,$cobrador,0,0,'C');
$pdf->Ln(10);
$pdf->Cell(95,5,$dir1,0);
$pdf->Cell(48,5,$dir2,0);
$pdf->Cell(46,5,$importe,0,0,'C');
$pdf->Ln(7);
$pdf->Cell(143,5,$dir3,0);
$pdf->Cell(46,5,$vencimiento,0,0,'C');
$pdf->Ln(7);
$pdf->Cell(85,5,$dir4,0);
$pdf->Cell(35,5,$dir5,0);
$pdf->Cell(23,5,$vacio,0);
$pdf->Cell(46,5,$periodo,0,0,'C');
$pdf->Ln(7);
$pdf->SetFont('Arial','',8);
$pdf->Cell(143,5,$observaciones,0);
$pdf->Cell(23,5,$vacio,0,0,'C');
$pdf->Cell(23,5,$vacio,0,0,'C');
$pdf->Ln(5);
$pdf->Cell(143,5,$leyenda,0);
$pdf->Cell(23,5,$vacio,0,0,'C');
$pdf->Cell(23,5,$vacio,0,0,'C');
$pdf->Ln(5);
$pdf->Cell(145,5,$leyenda1,0);
$pdf->SetFont('v100015','',26);
$pdf->Cell(44,5,$codbarras,0,0,'C');
$pdf->SetFont('Arial','',8);
$pdf->Cell(143,5,$deuda,0);
$pdf->Cell(46,5,$vacio,0,0,'C');
$pdf->SetFont('Arial','',10);

if ($conta == '1')
  {
  $pdf->Ln(9);
  }

if ($conta == '2')
  {
  $pdf->Ln(9);
  }
}

mysql_free_result($result);
$pdf->Output();

?>
