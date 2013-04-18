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
require_once("cookie.php");
require_once("config.php");
$cookie = new cookieClass;
$G_usuario = $cookie->get("usuario");
$G_legajo  = $cookie->get("legajo");
$G_perfil  = $cookie->get("perfil");
################### Conexion a la base de datos##########################

$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
?>


<HTML>
<HEAD>
<TITLE>ABM_Liqguardia2.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>" style="font-size:<?echo $fontef?>">
<BODY>


<?
echo titulo_encabezado ('Liquidación de Honorarios' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }
//Ejecutamos la sentencia SQL

echo '<FORM METHOD="POST"
ACTION="M_Liqguardia2.php">';


$idaten = $_POST["pasdatos"];
$fechad = $_POST["cla_fecha"];
$fechah = $_POST["cla_fecha1"];
$nombre = $_POST["cla_nombre"];
$vengo = $_POST["vengo"];
$idguardia1 = $_POST["cla_idguardia"];

list($idguardia,$idatencion)=explode("-",$idaten);

$result=mysql_query("select * from movildisponible a, legajos b where a.legmedico = b.legajo and a.idmovildisp  = ".$idguardia);
$row=mysql_fetch_array($result);

echo'
<table width="100%">
<tr style="background-color:'.$td_color.'"><td><table width="100%" border="1" align="left" style="font-size:<?echo $fontreg?>">
  <tr>
    <td width="100%" rowspan="3" valign="top">
      <table style="font-size:'.$fontreg.'" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:'.$th_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0;font-size:'.$font.'">
          <tr style="font-size:'.$fontt.'">
            <th>GUARDIA</th>
            <th>FECHA</th>
            <th>HORA</th>
            <th>MEDICO</th>
            <th>COSEGURO</th>
            <th>RETIENE</th>
    </tr></td>';

$fecalta = cambiarFormatoFecha($row['fecalta']);

echo '<td align="center">'.$row["idmovildisp"].'</td>';
echo '<td align="center">'.$fecalta.'&nbsp;</td>';
echo '<td align="center">'.$row["horaalta"].'&nbsp;</td>';
echo '<td align="left">'.$row["apeynomb"].'&nbsp;</td>';
echo '<td align="right">'.$row["coseguros"].'&nbsp;</td>';
echo '<td align="right">'.$row["retiene"].'&nbsp;</td>';

$idmovildisp = $row["idmovildisp"];

echo '</table></table></td></tr>' ;


$result=mysql_query("select * from guardiasliq a, legajos b, movildisponible c where a.idguardia = c.idmovildisp and
                    a.legmed = b.legajo and a.idatencion = ".$idatencion." and a.idguardia = ".$idguardia." ".$query." order by a.secuencia");

echo '
<tr style="background-color:'.$td_color.'"><td><table width="100%" border="1" align="left" style="font-size:'.$fontreg.'">
  <tr>
    </tr><tr>
    <td width="100%" rowspan="3" valign="top">
      <table style="font-size:'.$fontreg.'" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:'.$th_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0,font-size:'.$font.'">
          <tr style="font-size:'.$fontt.'">
            <th>SEC</th>
            <th>ID AT</th>
            <th>TIPO</th>
            <th>FECHA</th>
            <th>HORA</th>
            <th>IMP BASE</th>
            <th>NOR</th>
            <th>EXC</th>
            <th>SIM</th>
            <th>ANU</th>
            <th>N</th>
            <th>Z</th>
            <th>F</th>
            <th>TOTAL</th>
        </td>';

//Mostramos los registros
$row=mysql_fetch_array($result);


$fecalta = cambiarFormatoFecha($row['fecha']);

echo '<tr><td align="center">'.$row["secuencia"].'&nbsp;</td>';
echo '<td align="center">'.$row["idatencion"].'&nbsp;</td>';
echo '<td align="center">'.$row["tipoguardia"].'&nbsp;</td>';
echo '<td align="center">'.$fecalta.'&nbsp;</td>';
echo '<td align="center">'.$row["hora"].'&nbsp;</td>';
echo '<td align="right">'.$row["impbase"].'&nbsp;</td>';
echo '<td align="right">'.$row["normal"].'&nbsp;</td>';
echo '<td align="right">'.$row["excedente"].'&nbsp;</td>';
echo '<td align="right">'.$row["simultaneo"].'&nbsp;</td>';
echo '<td align="right">'.$row["anulado"].'&nbsp;</td>';
echo '<td align="right">'.$row["adnoct"].'&nbsp;</td>';
echo '<td align="right">'.$row["adzona"].'&nbsp;</td>';
echo '<td align="right">'.$row["adfinde"].'&nbsp;</td>';
echo '<td align="right"><input size= 10 type = "text" name = "cla_importe" value = "'.$row[importe].'" /></td>';
echo '<input type="hidden" name= "pasdatos" value="'.$idguardia.'" >';
echo '<input type="hidden" name= "cla_idatencion" value="'.$row["idatencion"].'" >';
echo '<input type="hidden" name= "cla_fecha" value="'.$fechad.'" >';
echo '<input type="hidden" name= "cla_fecha1" value="'.$fechah.'" >';
echo '<input type="hidden" name= "cla_nombre" value="'.$nombre.'" >';
echo '<input type="hidden" name= "vengo" value="'.$vengo.'" >';
echo '<input type="hidden" name= "cla_idguardia" value="'.$row["idguardia"].'" >';
echo '<input type="hidden" name= "cla_idguardia1" value="'.$idguardia1.'" >';

$datos = $row["idatencion"];



mysql_free_result($result);

echo '</TR></table></table></td></tr></table>' ;
?>

<INPUT name="SUBMIT" TYPE="submit" value="Actualizar"></FORM>
    <th width="769" scope="col">


</FORM>
</table>
</table>

</BODY>
</HTML>