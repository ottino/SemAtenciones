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
<TITLE>L_Gastobotiquines1.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>

<?
echo titulo_encabezado ('Consulta de Consumo Botiquines' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$fechad = $_POST["cla_fecha"];
$fechah = $_POST["cla_fecha1"];

if ($fechah == '')
    $fechah = '2999/12/31';
if ($fechad == '')
    $fechad = '2000/01/01';



$articulos = $_POST["movil"];

$sSQL="select * from movildisponible a, atenciones b, botiquin_cierre c, articulos d, moviles e where a.idmovildisp = b.movil_2 and b.id = c.id_atencion and
        c.id_articulo = d.idarticulo and c.id_rubro = d.rubro and b.movil = e.idmovil and a.fecalta >= '".$fechad."' and a.fecalta <= '".$fechah."'
        order by b.movil, c.id_articulo, c.id_rubro";

//echo $sSQL;
mysql_query($sSQL);

$result= mysql_query($sSQL);

echo '
<table width="100%">
 <tr style="background-color:'.$td_color.'"> <td>
  <table width="100%" border="1" align="left">
  <tr>
    <td><INPUT TYPE="BUTTON" value="Imprimir" ALIGN ="left" onclick ="window.print()"></td><td></td>
    <td style="width:60px"><th> <a href="javascript:history.back(1)"/a> <img border="0" src="imagenes/Volver.ico" width="30" height="30"  align="right" /></th></td>
      </td></tr></tr></table></tr> </td>
  <table width="100%" border="1" align="left">
    <tr style="background-color:'.$td_color.'">
     <td width="100%" rowspan="3" valign="top"><div align="center">
      <table style="font-size:'.$fontreg.'" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:'.$th_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
          <tr style="font-size:'.$fontt.'; background-color:'.$td_color.'">
            <th>FECHA</th>
            <th>MOVIL</th>
            <th>DESCRIPCION</th>
            <th>CANTIDAD</th>
        </tr>';



//Mostramos los registros
$c = 0;
$cant = 0;
$movilviejo = '0';
$artiviejo  = '0';
$rubroviejo = '0';


while ($row=mysql_fetch_array($result))
{
$c++;


if ($c > '1' || $movilviejo =! $row["idmovil"] || $artiviejo  =! $row["id_articulo"] || $rubroviejo =! $row["id_rubro"])
     {
      echo '<tr style="background-color:'.$td_color.'"><td align="center">'.$fechavieja.'</td>';
      $descmovil = buscomovil($movilviejo);
      echo '<td align="left">'.$movilviejo.' - '.$descmovil.'</td>';
      $descarti= buscoarticulo($artiviejo, $rubroviejo);
      echo '<td align="left">'.$artiviejo.' - '.$rubroviejo.' - '.$descarti.'</td>';
      echo '<td align="center">'.$cant.'</td></tr>';

      $cant = 0;
     };


$fechavieja = cambiarFormatoFecha($row['fecalta']);
$movilviejo = $row["idmovil"];
$artiviejo  = $row["id_articulo"];
$rubroviejo = $row["id_rubro"];

$cant = $cant + $row["cantidad"];

}

      echo '<tr style="background-color:'.$td_color.'"><td align="center">'.$fechavieja.'</td>';
      $descmovil = buscomovil($movilviejo);
      echo '<td align="left">'.$movilviejo.' - '.$descmovil.'</td>';
      $descarti= buscoarticulo($artiviejo, $rubroviejo);
      echo '<td align="left">'.$artiviejo.' - '.$rubroviejo.' - '.$descarti.'</td>';
      echo '<td align="center">'.$cant.'</td>';

mysql_free_result($result);

?>

</table>

</BODY>
</HTML>