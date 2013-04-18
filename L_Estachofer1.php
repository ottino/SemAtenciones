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

################### Conexion a la base de datos ##########################

$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
?>


<HTML>
<HEAD>
<TITLE>L_Estachofer1.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>" style="font-size:<?echo $fontef?>">
<BODY>

<?
echo titulo_encabezado ('Listado de Atenciones x Chofer' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$vengo = $_POST["cla_vengo"];
//echo $vengo;
if ($vengo == "CHOFER")
  {
    $fechad = $_POST["cla_fecha"];
    $fechah = $_POST["cla_fecha1"];
    $nombre = $_POST["cla_nombre"];
    $chofer = $_POST["cla_chofer"];
  }
 else
  {
    $fechad = $_GET["cla_fecha"];
    $fechah = $_GET["cla_fecha1"];
    $nombre = $_GET["cla_nombre"];
    $chofer = $_GET["cla_chofer"];
  };

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

if ($nombre == '')
    $sqlnombre = '';
   else
    $sqlnombre = " and apeynomb like '%".$nombre."%' ";

if ($chofer < '1')
    $sqlnombre = $sqlnombre;
   else
    $sqlnombre = $sqlnombre." and chofer ='".$chofer."' ";

//Ejecutamos la sentencia SQL



$elquery = "select apeynomb, fecalta, movil_2, movil, sum(cnadicionales) as adic, count(*) as cantidad from atenciones, legajos, movildisponible where
movil_2 = idmovildisp and legmedico > 0 and idmovil > 12 and chofer = legajo ".$sqlnombre." and motanulacion < '1' and fecha >= '".$fechad."' and fecha <= '".$fechah."'
group by apeynomb, fecalta, movil_2, movil order by 1, 3 desc";

$literal = "     ESTADISTICAS POR CHOFER POR GUARDIA    DESDE ".$fechad1." HASTA ".$fechah1;

//echo $elquery;

$result= mysql_query($elquery);

?>
</p>

<table width="100%">
 <tr> <td>
  <table width="100%" border="1" align="left">
  <tr>
    <td><INPUT TYPE="BUTTON" value="Imprimir" ALIGN ="left" onclick ="window.print()"></td><td><div align="center"><?echo $literal ?></div>
      </td>
           <FORM METHOD="POST" NAME="formulario2" ACTION="L_Estachofer.php">
            <td width="17" align="center" style="background-color:'.$td_color.'" style="CURSOR: hand" >
                                 <label onclick="this.form.submit();">
                                  <img align="middle" alt='Volver' src="imagenes/Volver.ico" width="30" height="30"/>
                                 </label>
                         </td></FORM></FORM>
      </tr></tr></table></tr> </td>
<?

echo '<table width="100%" border="0" align="left" style="background-color:'.$td_color.'">
    <td width="100%" rowspan="3" valign="top"><div align="center">
      <table style="font-size:'.$fontreg.'" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:'.$th_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
         <tr style="font-size:'.$fontt.'">
            <th>CHOFER</th>
            <th>FECHA</th>
            <th>GUARDIA</th>
            <th>MOVIL</th>
            <th>CANTIDAD</th>
            <th>CONS</th>
        </td></tr>';



while ($row=mysql_fetch_array($result))
{

$fecha  =  cambiarFormatoFecha($row["fecalta"]);
$movil  =  $row["movil"];

echo '<tr>';
echo '<td align="left">'.$row["apeynomb"].'</td>';
echo '<td align="center">'.$fecha.'</td>';
echo '<td align="center">'.$row["movil_2"].'</td>';
echo '<td align="center">'.$row["movil"].'</td>';

$total = $row["cantidad"] + $row["adic"];

echo '<td align="center">'.$total.'</td>';

$vengo = "ESTACHOFER";

echo '<FORM METHOD="POST" NAME="formulario2" ACTION="M_Cierredisp2.php">';
echo '<input type="hidden" name= "cla_fecha" value="'.$fechad.'" >';
echo '<input type="hidden" name= "cla_fecha1" value="'.$fechah.'" >';
echo '<input type="hidden" name= "cla_nombre" value="'.$nombre.'" >';
echo '<input type="hidden" name= "cla_chofer" value="'.$chofer.'" >';
echo '<input type="hidden" name= "pasmovildisp" value="'.$row["movil_2"].'" >';
echo '<input type="hidden" name= "vengo" value="'.$vengo.'" >';
echo '<input type="hidden" name= "demora" value="NO" >';

echo ' <td width="17" align="center" style="background-color:'.$td_color.'" style="CURSOR: hand" >
                    <label onclick="this.form.submit();">
                     <img align="middle" alt=\'Consultar\' src="imagenes/INSERTAR.ICO" width="30" height="30"/>
                    </label>
                  </td>';
echo '</FORM>';

}

mysql_free_result($result);

?>

</table>
</table>


</BODY>
</HTML>