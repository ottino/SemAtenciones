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
    $this->Image('imagenes\Logo_a_tiempo2.jpg',10,8,10);
    //Arial bold 15
    $this->SetFont('Arial','B',10);
    //Movernos a la derecha
    $this->Cell(125);
    //Título
    $this->Cell(30,10,$this->titulo,0,0,'C');
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

//
// PARAMETROS PARA LA SALIDA EN PDF
$pdf=new PDF('L','mm','A4');
$pdf->titulo = $literal;
$pdf->SetMargins(3,5); 
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',6);
//$pdf->Cell(1);

$pdf->Cell(15,5,"ID",1);
$pdf->Cell(14,5,"FECHA",1);
$pdf->Cell(15,5,"PLAN",1);
$pdf->Cell(22,5,"NOMBRE",1);
$pdf->Cell(15,5,"FONO",1);
$pdf->Cell(5,5,"E",1);
$pdf->Cell(5,5,"S",1);
$pdf->Cell(25,5,"CALLE",1);
$pdf->Cell(7,5,"NRO",1);
$pdf->Cell(17,5,"LOCALIDAD",1);
$pdf->Cell(15,5,"OPERADOR",1);
$pdf->Cell(7,5,"COL",1);
$pdf->Cell(12,5,"MEDICO",1);
$pdf->Cell(10,5,"C.MED",1);
$pdf->Cell(12,5,"$ COS",1);
$pdf->Cell(5,5,"M",1);
$pdf->Cell(5,5,"G",1);
$pdf->Cell(9,5,"LLAM",1);
$pdf->Cell(9,5,"DESP",1);
$pdf->Cell(7,5,"SAL",1);
$pdf->Cell(9,5,"LLEG",1);
$pdf->Cell(7,5,"SAL",1);
$pdf->Cell(9,5,"LLEG",1);
$pdf->Cell(7,5,"SAL",1);
$pdf->Cell(7,5,"DIS",1);
$pdf->Cell(20,5,"DIAGNOSTICO",1,1);

								 
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
{   
   $medico = 'ANULADO';
   $diagnostico = buscoanulacion($fila["motanulacion"]);
}

$pdf->Cell(15,3,$id,0);
$pdf->Cell(14,3,$fecha,0);
$pdf->Cell(15,3,$fila["descabrev"],0);
$pdf->Cell(22,3,substr($fila["nombre"],0,15),0);
$pdf->Cell(15,3,$fila["telefono"],0);
$pdf->Cell(5,3,$fila["edad"],0);
$pdf->Cell(5,3,$fila["sexo"],0);
$pdf->Cell(25,3,substr($fila["calle"],0,15),0,0);
$pdf->Cell(7,3,substr($fila["numero"],0,6)."..",0);
$pdf->Cell(17,3,substr($fila["localidad"],0,14),0);
$pdf->Cell(15,3,substr($operador,0,8),0);
$pdf->Cell(7,3,substr($color,0,1),0);
$pdf->Cell(12,3,substr($medico,0,7),0);
$pdf->Cell(10,3,substr($colorm,0,1),0);
$pdf->Cell(12,3,$fila["coseg"],0);
$pdf->Cell(5,3,$fila["movil"],0);
$pdf->Cell(5,3,$fila["movil_2"],0);
$pdf->Cell(9,3,$horallam,0);
$pdf->Cell(9,3,$horadesp,0);
$pdf->Cell(7,3,$horasalbase,0);
$pdf->Cell(9,3,$horallegdom,0);
$pdf->Cell(7,3,$horasaldom,0);
$pdf->Cell(9,3,$horalleghosp,0);
$pdf->Cell(7,3,$horasalhosp,0);
$pdf->Cell(7,3,$horadisp,0);
$pdf->Cell(20,3,substr($diagnostico,0,15),0,1);

$resulta=mysql_query("select * from clientes_nopadron WHERE idatencion = ".$id);
while ($fila2=mysql_fetch_array($resulta))
 {
  $pdf->Cell(15,3,$id,0);
  $pdf->Cell(14,3,$fecha,0);
  $pdf->Cell(15,3,$fila["descabrev"],0);
  $pdf->Cell(22,3,substr($fila2["nombre"],0,15),0);
  $pdf->Cell(15,3,$fila["telefono"],0);
  $pdf->Cell(5,3,$fila2["edad"],0);
  $pdf->Cell(5,3,$fila2["sexo"],0,1); 
 }
   mysql_free_result($resulta);

}   
$pdf->Output();




?>
