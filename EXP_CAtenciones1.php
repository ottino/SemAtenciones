<?
session_start();
######################INCLUDES################################
//archivo de configuracion
include_once ('config.php');

//funciones propias
include ('funciones.php');

//incluímos la clase ajax
require ('xajax/xajax.inc.php');
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

################### Conexion a la base de datos##########################

$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
//ob_start("ob_gzhandler");
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=atenciones.xls");
header("Pragma: no-cache");
header("Expires: 0");


$plan1 = $_POST["cla_plan"];
$fechad = $_POST["cla_fecha"];
$fechah = $_POST["cla_fecha1"];

if (substr($fechad,2,1) == "/")
    $fechad = cambiarFormatoFecha2($fechad);

if (substr($fechah,2,1) == "/")
    $fechah = cambiarFormatoFecha2($fechah);

$nombre = $_POST["cla_nombre"];
$idatencion = $_POST["cla_idatencion"];
$idord = $_POST["cla_ord"];
$imagen_volver = "imagenes/Volver.ico";

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

if ($idatencion > '0')
    $sqlnombre = $sqlnombre." and id = '".$idatencion."' ";

$sqlnombre1 = " order by id";


 if ($idord == 'I')
     $sqlnombre1 = " order by id desc";

 if ($idord == 'F')
     $sqlnombre1 = " order by fecha desc";

 if ($idord == 'P')
     $sqlnombre1 = " order by plan";

 if ($idord == 'N')
     $sqlnombre1 = " order by nombre";



if ($plan1 < '1')
  {    $result=mysql_query("select * from atenciones a, planes b WHERE motanulacion < 1 and fecha >= '".$fechad."' and fecha <= '".$fechah."' and a.plan = b.idplan ".$sqlnombre."  ".$sqlnombre1." ");
      $lit_plan = "****  TODOS  ****  ";
  }
  else
  {  $result=mysql_query("select * from atenciones a, planes b WHERE motanulacion < 1 and fecha >= '".$fechad."' and fecha <= '".$fechah."' and
                     plan = '".$plan1."' and a.plan = b.idplan ".$sqlnombre."  ".$sqlnombre1." ");
      $lit_plan = $row["descplan"];
   }


$exporta = '<table border="1" >
          <tr style="font-size:'.$fontt.'">
            <th>ID</th>
            <th>FECHA</th>
            <th>HS</th>
            <th>HLL</th>
            <th>PLAN</th>
            <th>IDENTIF/AUTORIZ</th>
            <th>NOMBRE</th>
            <th>FONO</th>
            <th>E</th>
            <th>S</th>
            <th>CALLE</th>
            <th>NRO</th>
            <th>LOCALID</th>
            <th>COLOR</th>
            <th>C.MED</th>
            <th>MEDICO</th>
            <th>MOVIL</th>
            <th>COSEG</th>
            <th>DIAGNOSTICO</th>
            </td></tr>';

echo $exporta;
$exporta = '';

while ($row=mysql_fetch_array($result))
{

$id = $row["id"] + 0;
$fecha  =  cambiarFormatoFecha($row["fecha"]);

$medico  =  buscopersonal($row["medico"]);
$color   =  buscocolor($row["color"]);
$colorm  =  buscocolor($row["colormedico"]);
$diagnostico  =  buscodiagnostico($row["diagnostico"]);
$zona  =  buscozona($row["zona"]);

if ($row["motanulacion"] > '0')
{   $medico = 'ANULADO';
   $diagnostico = buscoanulacion($row["motanulacion"]);
}

$horallam = cambiarFormatoHora($row["horallam"]);
$horallegdom = cambiarFormatoHora($row["horallegdom"]);
$exporta = $exporta.'<tr><td>'.$id.'</td><td>'.$fecha.'&nbsp;</td><td>'.$horallam.'&nbsp;</td><td>'.$horallegdom.'&nbsp;</td><td>'.$row["descabrev"].'&nbsp;</td>';
$exporta = $exporta.'<td>'.$row["identificacion"].'&nbsp;</td><td>'.$row["nombre"].'&nbsp;</td><td>'.$row["telefono"].'&nbsp;</td><td>'.$row["edad"].'&nbsp;</td>';
$exporta = $exporta.'<td>'.$row["sexo"].'&nbsp;</td><td>'.$row["calle"].'&nbsp;</td><td>'.$row["numero"].'&nbsp;</td><td>'.$zona.'&nbsp;</td><td>'.$color.'&nbsp;</td>';
$exporta = $exporta.'<td>'.$colorm.'&nbsp;</td><td>'.$medico.'&nbsp;</td><td>'.$row["movil_2"].'-'.$row["movil"].'&nbsp;</td><td>'.$row[44].'&nbsp;</td>';
$exporta = $exporta.'<td>'.$diagnostico.'&nbsp;</td></tr>';

echo $exporta;
$exporta = '';

$resulta=mysql_query("select * from clientes_nopadron WHERE idatencion = ".$id." order by idatencion, idnopadron");
while ($rowa=mysql_fetch_array($resulta))
 {
   if ($rowa["diagnostico"] > '0')
      $diagnostico  =  buscodiagnostico($rowa["diagnostico"]);
    else
      $diagnostico  =  ' ';

   $fecha1  =  cambiarFormatoFecha($row["fecha"]);
   $exporta = $exporta.'<tr><td>'.$id.'</td><td>'.$fecha1.'&nbsp;</td><td>'.$horallam.'&nbsp;</td><td>'.$horallegdom.'&nbsp;</td><td>'.$row["descabrev"].'&nbsp;</td>';
   $exporta = $exporta.'<td>'.$rowa["os"].'&nbsp;</td><td>'.$rowa["nombre"].'&nbsp;</td><td>'.$row["telefono1"].'&nbsp;</td><td>'.$rowa["edad"].'&nbsp;</td>';
   $exporta = $exporta.'<td>'.$rowa["sexo"].'&nbsp;</td><td>'.$row["calle"].'&nbsp;</td><td>'.$row["numero"].'&nbsp;</td><td>'.$zona.'&nbsp;</td><td>'.$color.'&nbsp;</td>';
   $exporta = $exporta.'<td>'.$colorm.'&nbsp;</td><td>'.$medico.'&nbsp;</td><td>'.$row["movil_2"].'-'.$row["movil"].'&nbsp;</td><td>'.$row[44].'&nbsp;</td>';
   $exporta = $exporta.'<td>'.$diagnostico.'&nbsp;</td></tr>';
   echo $exporta;
   $exporta = '';

 }


}

//$exporta=utf8_decode($exporta);
//echo $exporta;
ob_end_flush();

mysql_free_result($resulta);
mysql_free_result($result);
?>

</table>
</table>
