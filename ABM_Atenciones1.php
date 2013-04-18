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
?>


<HTML>
<HEAD>
<TITLE>ABM_Atenciones1.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>" style="font-size:<?echo $fontef?>">
<BODY>

<?
echo titulo_encabezado ('Listado de Atenciones' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$plan1 = $_POST["cla_plan"];
$fechad = $_POST["cla_fecha"];
$fechah = $_POST["cla_fecha1"];
$nombre = $_POST["cla_nombre"];
$idestado = $_POST["cla_estado"];


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

$lit_plan = "* TODOS *";

if ($idestado == 'A')
   { $sqlnombre = $sqlnombre." and motanulacion <> '0' ";
     $lit_plan = "* ANULADOS *";
   }
  else
   if ($idestado == 'D')
     {  $sqlnombre = $sqlnombre." and motanulacion < '1' ";
        $lit_plan = "* DESPACHADOS  *";
     }

if ($plan1 < '1')
  {    $result=mysql_query("select *, a.impcoseguro as coseg from atenciones a, planes b WHERE fecha >= '".$fechad."' and fecha <= '".$fechah."' and a.plan = b.idplan ".$sqlnombre." order by id ");
      $lit_plan = $lit_plan."* PLAN:  TODOS  *  ";
  }
  else
  {  $result=mysql_query("select *, a.impcoseguro as coseg from atenciones a, planes b WHERE fecha >= '".$fechad."' and fecha <= '".$fechah."' and
                     plan = '".$plan1."' and a.plan = b.idplan ".$sqlnombre." order by id ");
      $lit_plan = $lit_plan."* PLAN: ".$plan1." * ";
   }

$literal = "     LISTADO DE: ".$lit_plan."       DESDE ".$fechad1." HASTA ".$fechah1;

?>
</p>

<table width="100%">
 <tr> <td>
  <table width="100%" border="1" align="left">
  <tr>
    <td><INPUT TYPE="BUTTON" value="Imprimir" ALIGN ="left" onclick ="window.print()"></td><td><div align="center"><?echo $literal ?></div></td>
    <td style="width:60px"><th> <a href="javascript:history.back(1)"/a> <img border="0" src="imagenes/Volver.ico" width="30" height="30"  align="top" /></th></td>
      </td></tr></tr></table></tr> </td>
  <table width="100%" border="0" align="left">
    <td width="100%" rowspan="3" valign="top"><div align="center">
      <table style="font-size:10px"border = "0" cellspacing="1" cellpadding="1" align="left" >
          <tr style="font-size:10px">
            <th>ID</th>
            <th>FECHA</th>
            <th>PLAN</th>
            <th>NOMBRE</th>
            <th>FONO</th>
            <th>E</th>
            <th>S</th>
            <th>CALLE</th>
            <th>NRO</th>
            <th>LOCALIDAD</th>
            <th>OPERADOR </th>
            <th>COL</th>
            <th>MEDICO</th>
            <th>C.MED</th>
            <th>$ COS</th>
            <th>M</th>
            <th>G</th>
            <th>LLAM</th>
            <th>DESP</th>
            <th>SAL</th>
            <th>LLEG</th>
            <th>SAL</th>
            <th>LLEG</th>
            <th>SAL</th>
            <th>DIS</th>
            <th>DIAGNOSTICO</th>
        </tr>

<?

$totanul = '0';
$totaten = '0';
$totadi  = '0';

while ($row=mysql_fetch_array($result))
{

$id = $row["id"] + 0;
echo '<tr><td align="left">'.$id.'</td>';
$fecha  =  cambiarFormatoFecha($row["fecha"]);

$operador  =  buscopersonal($row["operec"]);
$medico  =  buscopersonal($row["medico"]);
$color   =  buscocolor($row["color"]);
$colorm  =  buscocolor($row["colormedico"]);
$diagnostico  =  buscodiagnostico($row["diagnostico"]);
$chofer  =  buscopersonal($row["chofer"]);

if ($medico == '')
  $medico = $chofer;

if ($row["motanulacion"] > '0')
{   $medico = 'ANULADO';
   $diagnostico = buscoanulacion($row["motanulacion"]);
   $totanul = $totanul +1;
}
else
   $totaten = $totaten +1;

echo '<td align="left">'.$fecha.'</td>';
echo '<td align="left">'.$row["descabrev"].'</td>';
echo '<td align="left">'.substr($row["nombre"],0,15).'</td>';
echo '<td align="left">'.$row["telefono"].'</td>';
echo '<td align="right">'.$row["edad"].'</td>';
echo '<td align="left">'.$row["sexo"].'</td>';
echo '<td align="left">'.$row["calle"].'</td>';
echo '<td align="left">'.$row["numero"].'</td>';
echo '<td align="left">'.substr($row["localidad"],0,17).'</td>';

echo '<td align="left">'.substr($operador,0,8).'</td>';
echo '<td align="center">'.substr($color,0,1).'</td>';
echo '<td align="left">'.substr($medico,0,10).'</td>';
echo '<td align="center">'.substr($colorm,0,1).'</td>';
echo '<td align="right">'.$row["coseg"].'</td>';
echo '<td align="right">'.$row["movil"].'</td>';
echo '<td align="right">'.$row["movil_2"].'</td>';


$horallam = cambiarFormatoHora($row["horallam"]);
$horadesp = cambiarFormatoHora($row["horadesp"]);
$horasalbase = cambiarFormatoHora($row["horasalbase"]);
$horallegdom = cambiarFormatoHora($row["horallegdom"]);
$horasaldom = cambiarFormatoHora($row["horasaldom"]);
$horalleghosp = cambiarFormatoHora($row["horalleghosp"]);
$horasalhosp = cambiarFormatoHora($row["horasalhosp"]);
$horadisp = cambiarFormatoHora($row["horalib"]);

echo '<td align="right">'.$horallam.'</td>';
echo '<td align="right">'.$horadesp.'</td>';
echo '<td align="right">'.$horasalbase.'</td>';
echo '<td align="right">'.$horallegdom.'</td>';
echo '<td align="right">'.$horasaldom.'</td>';
echo '<td align="right">'.$horalleghosp.'</td>';
echo '<td align="right">'.$horasalhosp.'</td>';
echo '<td align="right">'.$horadisp.'</td>';
echo '<td align="left">'.substr($diagnostico,0,15).'</td></tr>';

if ($row["motanulacion"] < '1')
    {
     $resulta=mysql_query("select * from clientes_nopadron WHERE idatencion = ".$id." order by idatencion, idnopadron");
     while ($rowa=mysql_fetch_array($resulta))
      {
        echo '<tr><td align="left">'.$id.'</td>';
        echo '<td align="left">'.$fecha1.'</td>';
        echo '<td align="left">'.$row["descabrev"].'</td>';
        echo '<td align="left">'.substr($rowa["nombre"],0,15).'</td>';
        echo '<td align="left">'.$row["telefono1"].'</td>';
        echo '<td align="right">'.$rowa["edad"].'</td>';
        echo '<td align="left">'.$rowa["sexo"].'</td></tr>';
        $totadi = $totadi +1;
     }
   mysql_free_result($resulta);
   }

}

$total = $totanul + $totaten + $totadi;

$totaten = $totaten + $totadi;

$ltotal = "TOTAL GENERAL DESDE ".$fechad1." HASTA ".$fechah1;
echo '<tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>';
echo '<tr style="font-size:15px"><td colspan=8 align="left">'.$ltotal.'</td>';
echo '<td colspan=5 align="left"> ATENCIONES: '.$totaten.' ('.$totadi.' adicionales)</td>';
echo '<td colspan=6  align="left">ANULADOS: '.$totanul.'</td>';
echo '<td colspan=4 align="left">TOTAL: '.$total.'</td></tr></tr>';

echo '</table></tD></table></TR></table></table>';
mysql_free_result($result);

?>





</BODY>
</HTML>