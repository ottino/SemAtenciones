<?
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
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$plan1 = $_POST["cla_plan"];
$fechad = $_POST["cla_fecha"];
$fechah = $_POST["cla_fecha1"];
$nombre = $_POST["cla_nombre"];


if (substr($fechad,2,1) == "/")
    $fechad = cambiarFormatoFecha2($fechad);

if (substr($fechah,2,1) == "/")
    $fechah = cambiarFormatoFecha2($fechah);

if ($fechah == '')
    $fechah = '2999/12/31';
if ($fechad == '')
    $fechad = '2000/01/01';


$fechad1=  cambiarFormatoFecha1($fechad);
$fechah1=  cambiarFormatoFecha1($fechah);



//Ejecutamos la sentencia SQL

if ($nombre == '')
    $sqlnombre = '';
   else
    $sqlnombre = " and nombre like '%".$nombre."%' ";


if ($plan1 < '1')
  {
      $consulta_atenciones=mysql_query("select *, a.impcoseguro as coseg from atenciones a, planes b WHERE fecha >= '".$fechad."' and fecha <= '".$fechah."' and a.plan = b.idplan ".$sqlnombre." order by id ");
      $lit_plan = "****  TODOS  ****  ";
  }
  else
  {
      $consulta_atenciones=mysql_query("select *, a.impcoseguro as coseg from atenciones a, planes b WHERE fecha >= '".$fechad."' and fecha <= '".$fechah."' and
                     plan = '".$plan1."' and a.plan = b.idplan ".$sqlnombre." order by id ");
      $lit_plan = $plan1;
   }

$literal = "     LISTADO DEL PLAN: ".$lit_plan."       DESDE ".$fechad1." HASTA ".$fechah1;

// obejetos
class PDF extends FPDF
{
//Cabecera de página
var $titulo;
function Header()
{
    //Logo
    $this->Image('imagenes/Logo_a_tiempo2.jpg',10,5,22,13);
    //Arial bold 15
    $this->SetFont('Arial','B',10);
    //Movernos a la derecha
    $this->Cell(125);
    //Título
    $this->Cell(30,10,$this->titulo,0,0,'C');
    //Salto de línea
    $this->Ln(15);
    $this->SetFont('Times','',7);
    $this->Cell(10,5,"ID",1);
    $this->Cell(16,5,"FECHA",1);
    $this->Cell(20,5,"PLAN",1);
    $this->Cell(26,5,"NOMBRE",1);
    $this->Cell(20,5,"FONO",1);
    $this->Cell( 6,5,"E",1);
    $this->Cell( 5,5,"S",1);
    $this->Cell(28,5,"CALLE",1);
    $this->Cell(12,5,"NRO",1);
    $this->Cell(20,5,"LOCALIDAD",1);
    $this->Cell(16,5,"OPERADOR",1);
    $this->Cell( 7,5,"COL",1);
    $this->Cell(16,5,"MEDICO",1);
    $this->Cell( 7,5,"C.MED",1);
    $this->Cell(12,5,"$ COS",1);
    $this->Cell( 7,5,"M",1);
    $this->Cell( 7,5,"G",1);
    $this->Cell(10,5,"LLAM",1);
    $this->Cell(10,5,"DESP",1);
    $this->Cell(10,5,"SAL",1);
    $this->Cell(10,5,"LLEG",1);
    $this->Cell(10,5,"SAL",1);
    $this->Cell(10,5,"LLEG",1);
    $this->Cell(10,5,"SAL",1);
    $this->Cell(10,5,"DIS",1);
    $this->Cell(26,5,"DIAGNOSTICO",1,1);
    $this->Ln(1);
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

//
// PARAMETROS PARA LA SALIDA EN PDF
$pdf=new PDF('L','mm','Legal');
$pdf->titulo = $literal;
$pdf->SetMargins(10,5);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',7);
//$pdf->Cell(1);


$totanul = '0';
$totaten = '0';
$totadi  = '0';

while ($fila=mysql_fetch_array($consulta_atenciones))
{
// busca datos, funciones creadas por Gustavo
$id = $fila["id"] + 0;
$fecha  =  cambiarFormatoFecha($fila["fecha"]);

$operador  =  buscopersonal($fila["operec"]);
$medico  =  buscopersonal($fila["medico"]);
$color   =  buscocolor($fila["color"]);
$colorm  =  buscocolor($fila["colormedico"]);
$diagnostico  =  buscodiagnostico($fila["diagnostico"]);
$chofer  =  buscopersonal($fila["chofer"]);
$horallam = cambiarFormatoHora($fila["horallam"]);
$horadesp = cambiarFormatoHora($fila["horadesp"]);
$horasalbase = cambiarFormatoHora($fila["horasalbase"]);
$horallegdom = cambiarFormatoHora($fila["horallegdom"]);
$horasaldom = cambiarFormatoHora($fila["horasaldom"]);
$horalleghosp = cambiarFormatoHora($fila["horalleghosp"]);
$horasalhosp = cambiarFormatoHora($fila["horasalhosp"]);
$horadisp = cambiarFormatoHora($fila["horalib"]);

if ($fila["motanulacion"] > '0')
{   $medico = 'ANULADO';
   $diagnostico = buscoanulacion($fila["motanulacion"]);
   $totanul = $totanul +1;
}
else
   $totaten = $totaten +1;

if ($medico == '')
  $medico = $chofer;


$pdf->Cell(10,3,$id,0);
$pdf->Cell(16,3,$fecha,0);
$pdf->Cell(20,3,$fila["descabrev"],0);
$pdf->Cell(26,3,substr($fila["nombre"],0,15),0);
$pdf->Cell(20,3,$fila["telefono"],0);
$pdf->Cell( 6,3,$fila["edad"],0,0,'R');

$pdf->Cell( 5,3,$fila["sexo"],0,0,'R');
$pdf->Cell(28,3,substr($fila["calle"],0,15),0,0);
$pdf->Cell(12,3,substr($fila["numero"],0,6)."..",0);
$pdf->Cell(20,3,substr($fila["localidad"],0,14),0);
$pdf->Cell(16,3,substr($operador,0,8),0);
$pdf->Cell( 7,3,substr($color,0,1),0);
$pdf->Cell(16,3,substr($medico,0,7),0);
$pdf->Cell( 7,3,substr($colorm,0,1),0);
$pdf->Cell(12,3,$fila["coseg"],0,0,'R');
$pdf->Cell( 7,3,$fila["movil"],0,0,'R');
$pdf->Cell( 7,3,$fila["movil_2"],0,0,'R');
$pdf->Cell(10,3,$horallam,0);
$pdf->Cell(10,3,$horadesp,0);
$pdf->Cell(10,3,$horasalbase,0);
$pdf->Cell(10,3,$horallegdom,0);
$pdf->Cell(10,3,$horasaldom,0);
$pdf->Cell(10,3,$horalleghosp,0);
$pdf->Cell(10,3,$horasalhosp,0);
$pdf->Cell(10,3,$horadisp,0);
$pdf->Cell(26,3,substr($diagnostico,0,15),0,1);

$resulta=mysql_query("select * from clientes_nopadron WHERE idatencion = ".$id);
while ($fila2=mysql_fetch_array($resulta))
 {
  $pdf->Cell(10,3,$id,0);
  $pdf->Cell(16,3,$fecha,0);
  $pdf->Cell(20,3,$fila["descabrev"],0);
  $pdf->Cell(26,3,substr($fila2["nombre"],0,15),0);
  $pdf->Cell(20,3,$fila["telefono"],0);
  $pdf->Cell( 6,3,$fila2["edad"],0,0,'R');
  $pdf->Cell( 5,3,$fila2["sexo"],0,1,'R');
  $totadi = $totadi +1;
 }
   mysql_free_result($resulta);

}
$total = $totanul + $totaten + $totadi;

$totaten = $totaten + $totadi;

$ltotal = "TOTAL GENERAL DESDE ".$fechad1." HASTA ".$fechah1;

  $pdf->Ln(5);
  $pdf->SetFont('Arial','B',10);
  $pdf->Cell(105,3,$ltotal,0);
  $pdf->Cell(27,3,"ATENCIONES: ",0);
  $pdf->Cell(10,3,$totaten,0);
  $pdf->Cell(29,3,"(SIMULTANEOS: ",0);
  $pdf->Cell(10,3,$totadi,0);
  $pdf->Cell(3,3,")",0);
  $pdf->Cell(25,3,"ANULADOS: ",0);
  $pdf->Cell(10,3,$totanul,0);
  $pdf->Cell(20,3,"TOTAL: ",0);
  $pdf->Cell(10,3,$total,0);

//echo '<tr style="font-size:15px"><td colspan=8 align="left">'.$ltotal.'</td>';
//echo '<td colspan=5 align="left"> ATENCIONES: '.$totaten.' ('.$totadi.' adicionales)</td>';
//echo '<td colspan=6  align="left">ANULADOS: '.$totanul.'</td>';
//echo '<td colspan=4 align="left">TOTAL: '.$total.'</td></tr></tr>';

$pdf->Output();




?>
