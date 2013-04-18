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

<TITLE>Marcaje3.php</TITLE>
</head>

<body style="background-color:<?echo $body_color?>">


<?
echo titulo_encabezado_solo ('Marcaje de horario' , $path_imagen_logo);

$legajo = $G_legajo;

$sSQL= "select * from legajos where legajo = ".$legajo;
$result=mysql_query($sSQL);
$row=mysql_fetch_array($result);
$nombre = $row["apeynomb"];

$uSQL= "select max(idmarcaje) as Maxmarca from marcaje where legajo = ".$legajo;
$uresult=mysql_query($uSQL);
$rowu=mysql_fetch_array($uresult);

$Maxmarca = $rowu["Maxmarca"];
mysql_free_result($uresult);

$uSQL= "select * from marcaje where idmarcaje = '".$Maxmarca."' and legajo = ".$legajo;
$uresult=mysql_query($uSQL);
$rowu=mysql_fetch_array($uresult);

//echo $rowu["tipomarcaje"];
$marca = $rowu["tipomarcaje"];

$fecult = cambiarFormatoFecha($rowu['fecha']);
$horault = cambiarFormatoHora($rowu['hora']);

if ($marca == 'I')
    $litmarca = 'INGRESO';
   else
    $litmarca = 'EGRESO';

$foto = "imagenes/".$legajo.".jpg";

if (file_exists($foto)){
   $foto = "imagenes/".$legajo.".jpg";
}else{
   $foto = "imagenes/adicionales.ico";
}



?>

<table  align="center"  width="38%" height="437" border="0">
  <tr>
  </tr>
  <tr>
    <td height="322"  background="">
    <table width="100%" height="20" border="0">
        <tr>
        </tr>
        <tr>
<?
      echo '<td><table width="90%" border="0"><tr>';
      echo '<td width="50" align="center" style="CURSOR: hand" >
                     <img align="middle" alt=\'Ingreso\' src="'.$foto.'" width="220" height="180"/>
                  </td></tr>';
      echo '<tr><td>'.$nombre.'</td></tr>';
      echo '</table></td>';


      if ($marca == 'E')
      {
         echo '<td><table width="50%" border="1"><tr>';
         echo '<FORM METHOD="POST" NAME="formulario3" ACTION="A_Marcaje.php">';
         echo '<input type="hidden" name= "cla_legajo" value="'.$legajo.'" >';
         echo '<input type="hidden" name= "cla_tipomarca" value="I" >';
         echo '<td width="25" align="center" style="background-color:'.$td_color.'" style="CURSOR: hand" >';
         echo '<label onclick="this.form.submit();">';
         echo '<img align="middle" alt=\'Ingreso\' src="imagenes/58.ico" width="120" height="120"/></label></td></td>';
         echo '</FORM>';
         echo '<tr><td align="center">INGRESO</td>';
      }


      if ($marca == 'I')
      {
         echo '<td><table width="50%" border="1"><tr>';
         echo '<FORM METHOD="POST" NAME="formulario3" ACTION="A_Marcaje.php">';
         echo '<input type="hidden" name= "cla_legajo" value="'.$legajo.'" >';
         echo '<input type="hidden" name= "cla_tipomarca" value="E" >';
         echo '<input type="hidden" name= "cla_idmarcaje" value="'.$Maxmarca.'" >';
         echo '<td width="25" align="center" style="CURSOR: hand" >';
         echo '<label onclick="this.form.submit();">';
         echo '<img align="middle" alt=\'Egreso\' src="imagenes/28.ico" width="120" height="120"/></label></td>';
         echo '</FORM>';
         echo '<tr><td align="center">EGRESO</td>';
      }


      echo '</table></td>';
?>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="21">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
<?
           echo '<td>Ultimo marcaje: '.$litmarca.'-'.$fecult.'-'.$horault.'</td>';
?>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="21">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="21">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="21">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="21">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</FORM>

</body>
</html>
