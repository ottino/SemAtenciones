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
/*
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }
*/
//Ejecutamos la sentencia SQL
$consulta_atenciones=mysql_query("SELECT * FROM atenciones_temp, colores WHERE color = idcolor  AND abierta <> '2' AND traslado_aux <= now( ) ORDER BY orden ASC , id ASC");
$literal = "     LISTADO DE ATENCIONES Y TRASLADOS PENDIENTES      ";

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
//$pdf->SetMargins(3,5); 
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',6);
//$pdf->Cell(1);

$pdf->Cell(15,5,"ID",1);
$pdf->Cell(14,5,"FECHA",1);
$pdf->Cell(11,5,"LLAM",1);
$pdf->Cell(22,5,"NOMBRE",1);
$pdf->Cell(5,5,"E",1);
$pdf->Cell(5,5,"S",1);
$pdf->Cell(70,5,"DOMICILIO",1);
$pdf->Cell(25,5,"LOCALIDAD",1);
$pdf->Cell(15,5,"ZONA",1);
$pdf->Cell(15,5,"FONO",1);
$pdf->Cell(19,5,"PLAN",1);
$pdf->Cell(10,5,"COL",1);
$pdf->Cell(30,5,"MOTIVO",1,1);


								 
while ($fila=mysql_fetch_array($consulta_atenciones))
{			 
// busca datos, funciones creadas por Gustavo
$id = $fila["id"] + 0;
$fecha  =   cambiarFormatoFecha($fila["fecha"]);
$color   =  buscocolor($fila["color"]);
$motivo  =  buscomotivo($fila["motivo1"],$fila["motivo2"]);
$zona    =  buscozona($fila["zona"]);
$horallam = cambiarFormatoHora($fila["horallam"]);
$plan    =  buscoplan($fila["plan"]);

 if ($fila['piso'] == '')
  {
   $mpiso = '';
  } else $mpiso = ' - Piso: ';

 if ($fila['depto'] == '')
  {
   $mdepto = '';
  } else $mdepto = ' - Dpto: ';



$pdf->Cell(15,3,$id ,0);
$pdf->Cell(14,3,$fecha,0);
$pdf->Cell(10,3,$horallam,0);
$pdf->Cell(22,3,substr($fila["nombre"],0,15),0);
$pdf->Cell(5,3,$fila["edad"],0);
$pdf->Cell(5,3,$fila["sexo"],0);
$pdf->Cell(70,3,substr($fila["calle"].' - '.$fila["numero"].$mpiso.$fila["piso"].$mdepto.$fila["depto"].' - '.$fila["barrio"],0,69),0);
$pdf->Cell(25,3,substr($fila["localidad"],0,12),0);
$pdf->Cell(15,3,substr($zona,0,10),0);
$pdf->Cell(15,3,$fila["telefono"],0);
$pdf->Cell(19,3,substr($plan,0,15),0);
$pdf->Cell(10,3,substr($color,0,5),0);
$pdf->Cell(30,3,substr($motivo,0,25),0,1);

}   
$pdf->Output();

mysql_free_result($consulta_atenciones);

?>  