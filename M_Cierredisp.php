<?
session_start();
######################INCLUDES################################
//archivo de configuracion
include_once ('config.php');

//funciones propias
include ('funciones.php');

//incluímos la clase ajax
require ('xajax/xajax.inc.php');

require_once("cookie.php");
require_once("config.php");
$cookie = new cookieClass;
$G_usuario = $cookie->get("usuario");
$G_legajo  = $cookie->get("legajo");
$G_perfil  = $cookie->get("perfil");


//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

################### Conexion a la base de datos##########################

$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
?>


<HTML>
<HEAD>
<TITLE>M_Cierredisp.php</TITLE>

</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>

<FORM METHOD="POST" NAME="formulario3"
ACTION="M_Cierredisp2.php">

<?
echo titulo_encabezado ('Cierre de Guardia' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$movdisp = $_POST["pasmovildisp"];

$vengo   = $_POST["vengo"];

////////////////////////////////

//Creamos la sentencia SQL y la ejecutamos
$sSQL="select * from movildisponible a, legajos b, bases c, moviles d where
       a.legchofer = b.legajo and a.idbase = c.idbases and a.idmovil = d.idmovil and idmovildisp = ".$movdisp;

$result=mysql_query($sSQL);
$row=mysql_fetch_array($result);

$chofer = $row['apeynomb'];
$medico = buscopersonal($row['legmedico']);
$base = $row['descbases'];
$movil = $row['descmovil'];
$hoy = date("Y-m-d");
$hora = date("H:i:s");

$fecalta = cambiarFormatoFecha($row['fecalta']);
$horaalta = cambiarFormatoHora($row['horaalta']);
$fecbaja = cambiarFormatoFecha($hoy);
$horabaja = cambiarFormatoHora($hora);

//Ejecutamos la sentencia SQL
$ySQL="select * from cajas a, legajos b WHERE a.legajo = b.legajo and a.estado < 1 and a.legajo = ".$G_legajo;
$yresult=mysql_query($ySQL);
$yrow=mysql_fetch_array($yresult);
//echo $row['id'];

$gSQL="select * from atenciones_temp WHERE movil_2 = ".$movdisp;
$gresult=mysql_query($gSQL);
$grow=mysql_fetch_array($gresult);
$aten = $grow['id'];
//echo $aten;

echo '
<table>
<tr style="background-color:'.$td_color.'"><td><table width="100%" border="1" align="left" style="font-size:'.$fontreg.'">
  <tr style="background-color:'.$td_color.'">';


 if ($vengo == "M")
 {
  if (!$yrow)
   echo '
    <TD>NO TIENE CAJA ASIGNADA PARA CERRAR UNA GUARDIA</TD>
    <td><a href="ABM_Movdisp.php?" /a> <img border="0" src="imagenes/Volver.ico" width="30" height="30"  align="top" /></td>
    </tr><tr>';
  else
  if ($aten > '0')
   echo '
    <TD>ESTA GUARDIA TIENE ATENCIONES SIN CERRAR</TD>
    <td><a href="ABM_Movdisp.php?" /a> <img border="0" src="imagenes/Volver.ico" width="30" height="30"  align="top" /></td>
    </tr><tr>';
  else
    echo '
    <TD><INPUT TYPE="SUBMIT" value="Cerrar Guardia"></TD></FORM>
    <td><div align="center"><a href="ABM_Movdisp.php?" /a> <img border="0" src="imagenes/Volver.ico" width="30" height="30"  align="top" /></div></td>
    </tr><tr>';
 }
 else
    echo '
     <td><INPUT TYPE="BUTTON" value="Imprimir" ALIGN ="left" onclick ="window.print()"></td><td><div align="center"></div></td>
     <td><th> <a href="javascript:history.back(1)" /a> <img border="0" src="imagenes/Volver.ico" width="30" height="30"  align="top" /></th></td>
       </tr><tr>';

?>
    <td width="100%" rowspan="3" valign="top">
      <table style="font-size:<?echo $fontreg?>" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:<?echo $th_color?>;border-left-width: 0; border-top-width: 0; border-bottom-width: 0" style="font-size:<?echo $font?>">
          <tr style="font-size:<?echo $fontt?>">
            <th>CHOFER</th>
            <th>MEDICO</th>
            <th>MOVIL</th>
            <th>BASE</th>
            <th>INGRESO</th>
            <th>EGRESO</th>
            <th>KM EGRESO</th>
            <th>ATENC.</th>
            <th>COSEG</th>
            <th>RETIENE</th>
        </td></tr>

<?
 echo '<input type="hidden" name= "movdisp" value="'.$row["idmovildisp"].'" >';
 echo '<td align="left">'.$chofer.'</td>';
 echo '<td align="left">'.$medico.'</td>';
 echo '<td align="left">'.$movil.'</td>';
 echo '<td align="left">'.$base.'</td>';
 echo '<td align="left">'.$fecalta.' - '.$horaalta.'</td>';
 echo '<td align="left">'.$fecbaja.' - '.$horabaja.'</td>';

 if ($vengo == "M")
   echo '<TD align="left"><input size= 12 type = "text" name = "cla_kmbaja" value = "'.$row[kmbaja].'" /></TD>';
  else
   echo '<td align="center">'.$row[kmbaja].'</td>';

 echo '<input type="hidden" name= "fecalta" value="'.$row["fecalta"].'" >';
 echo '<input type="hidden" name= "horaalta" value="'.$row["horaalta"].'" >';
 echo '<input type="hidden" name= "update" value="1" >';


$sSQL="select * from atenciones where motanulacion < 1 and movil_2 = ".$movdisp;

$result=mysql_query($sSQL);

$c = 0;
$coseguros = 0;

while ($row=mysql_fetch_array($result))
{
$c++;
$coseguros = $coseguros + $row['impcoseguro'];
}
 echo '<td align="center">'.$c.'</td>';
 echo '<td align="center">'.number_format($coseguros,2).'</td>';
 $cero = 0;
 echo '<input type="hidden" name= "cla_coseguros" value="'.$coseguros.'" >';


 if ($vengo == "M")
   echo '<TD align="center"><input size= 12 type = "text" name = "cla_retiene" value = 0 /></TD>';
  else
   echo '<td align="center">'.$cero.'</td>';

//echo '<TD align="center"><input size= 12 type = "text" name = "cla_retiene" value = 0 /></TD>';
echo '</table></table></td></tr>' ;


$sSQL="select * from atenciones a, motivos b, destino c, zonas d where
       a.motivo1 = b.idmotivo and a.motivo2 = b.idmotivo2 and
       a.destino = c.iddestino and a.zona = d.idzonas and movil_2 = ".$movdisp;

$result=mysql_query($sSQL);

$c = 0;
$coseguros = 0;

echo '
<tr style="background-color:'.$td_color.'"><td><table width="100%" border="1" align="left" style="font-size:'.$fontreg.'">
  <tr style="background-color:'.$td_color.'">
    </tr><tr>
    <td width="100%" rowspan="3" valign="top">
      <table style="font-size:'.$fontreg.'" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:'.$body_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0" style="font-size:'.$font.'">
          <tr style="font-size:'.$fontt.'">
            <th>ID</th>
            <th>NOMBRE</th>
            <th>EDAD</th>
            <th>SEXO</th>
            <th>SIMULT</th>
            <th>LOCALIDAD</th>
            <th>HORA</th>
            <th>MOTIVO</th>
            <th>DESTINO</th>
            <th>ANULACION</th>
            <th>COSEGURO</th>
        </td>';

//Mostramos los registros
$c = 0;
$anulados = 0;

while ($row=mysql_fetch_array($result))
{

$motanulacion = $row["motanulacion"];
if ($motanulacion < 1)
{
   $coseguros = $coseguros + $row['impcoseguro'];
   $c = $c + $row["cnadicionales"];
   $c++;
} else
{
   $anulados++;
}

$fecha = cambiarFormatoFecha($row['fecha']);

$id = $row["id"] + 0;

echo '<tr><td align="center">'.$id.'</td>';
echo '<td align="left">'.$row["nombre"].'</td>';
echo '<td align="center">'.$row["edad"].'</td>';
echo '<td align="center">'.$row["sexo"].'</td>';
echo '<td align="center">'.$row["cnadicionales"].'</td>';
echo '<td align="center">'.$row["desczonas"].'</td>';
echo '<td align="center">'.$row["horallegdom"].'</td>';
echo '<td align="center">'.$row["desc"].'</td>';
echo '<td align="center">'.$row["destino"].'</td>';
echo '<td align="center">'.$row["motanulacion"].'</td>';
echo '<td align="center">'.$row["impcoseguro"].'</td>';
echo '<input size= 12 type = "hidden" name = "cla_botiquin'.-$c.'" value="'.$row["idbotiquines"].'"/>';
echo '<input size= 12 type = "hidden" name = "cla_articulo'.-$c.'" value="'.$row["idarticulo"].' - '.$row["idrubro"].'"/>';

}
echo '</TR></table></table></td></tr></table>' ;
mysql_free_result($result);
?>

</BODY>
</HTML>