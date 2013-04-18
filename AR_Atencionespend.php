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
$literal = "LISTADO DE ATENCIONES Y TRASLADOS PENDIENTES";

class PDF extends FPDF
{
//Cabecera de página
var $titulo;
function Header()
{
    //Logo
    $this->Image('imagenes/Logo_a_tiempo2.jpg',10,8,10);
    //Arial bold 15
    $this->SetFont('Arial','B',10);
    //Movernos a la derecha
    $this->Cell(35);
    //Título
    $this->Cell(10,10,$this->titulo,0,0,'L');
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
$pdf=new PDF('P','mm','Legal');
$pdf->titulo = $literal;
//$pdf->SetMargins(3,3);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',6);
//$pdf->Cell(1);

$pdf->Cell(8,5,"ID",1,0,'C');
$pdf->Cell(13,5,"FECHA",1,0,'C');
$pdf->Cell(8,5,"LLAM",1,0,'C');
$pdf->Cell(22,5,"NOMBRE",1);
$pdf->Cell(5,5,"E",1);
$pdf->Cell(5,5,"S",1);
$pdf->Cell(43,5,"DOMICILIO",1);
$pdf->Cell(15,5,"LOCALIDAD",1);
$pdf->Cell(8,5,"ZONA",1);
$pdf->Cell(11,5,"FONO",1);
$pdf->Cell(17,5,"PLAN",1);
$pdf->Cell(3,5,"C",1);
$pdf->Cell(33,5,"MOTIVO",1);
$pdf->Cell(8,5,"MOVIL",1,1);



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



$pdf->Cell(8,3,$id ,1,0,'R');
$pdf->Cell(13,3,$fecha,1,0,'C');
$pdf->Cell( 8,3,$horallam,1,0,'C');
$pdf->Cell(22,3,substr($fila["nombre"],0,15),1);
$pdf->Cell(5,3,$fila["edad"],1,0,'C');
$pdf->Cell(5,3,$fila["sexo"],1,0,'C');
$pdf->Cell(43,3,substr($fila["calle"].' - '.$fila["numero"].$mpiso.$fila["piso"].$mdepto.$fila["depto"].' - '.$fila["barrio"],0,69),1);
$pdf->Cell(15,3,substr($fila["localidad"],0,12),1);
$pdf->Cell(8,3,substr($zona,0,10),1);
$pdf->Cell(11,3,$fila["telefono"],1);
$pdf->Cell(17,3,substr($plan,0,15),1);
$pdf->Cell(3,3,substr($color,0,1),1);
$pdf->Cell(33,3,substr($motivo,0,25),1);
$pdf->Cell(8,3,$fila["movil"],1,1,'R');

}
$pdf->Output();

mysql_free_result($consulta_atenciones);

?>