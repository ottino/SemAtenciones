<?php
######################INCLUDES################################
//archivo de configuracion
include_once ('config.php');

//funciones propias
include ('funciones.php');

//incluímos la clase ajax
require ('xajax/xajax.inc.php');

//login del usuario
require_once ('cookie.php');

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// VARIABLES GLOBALES - DATOS DE USUARIO LOGON
$cookie = new cookieClass;
$G_usuario = $cookie->get("usuario");
$G_legajo  = $cookie->get("legajo");
$G_perfil  = $cookie->get("perfil");
$G_funcion = $cookie->get("funcion");


################### Conexion a la base de datos##########################
$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);

$motivo_buscar = $_GET['id_motivo'];
$ids ['0'] = substr($motivo_buscar, 0, 1);
$ids ['1'] = substr($motivo_buscar, 1, 2);

//$ids = explode ("-",$motivo_buscar);
$consulta_motivos = mysql_query ("SELECT * FROM motivos WHERE idmotivo = ".$ids['0']." and idmotivo2 = ".$ids['1']."");
if (!$consulta_motivos) {
  $titulo = "NO SE ENCONTRO MOTIVO";
  $textarea = '<textarea cols="50" rows="33"></textarea>';
}else
{
    while ($fila=mysql_fetch_array($consulta_motivos))
     {
      $titulo = $fila['desc'];
      $textarea = '<textarea cols="50" rows="33">'.$fila['instrucciones'].'</textarea>';
     }
}
$html_salida = '
<html>
<head>
<?xml version="1.0" encoding="iso-8859-1"?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script defer type="text/javascript" src="jsfunciones.js"></script>
<title>INSTRUCCIONES</title>
</head>
<body style="background-color:'.$body_color.'" >
 <table border="0">
  <tr>
   <td align="center" colspan="">
   '.$titulo.'
   </td>
  </tr>
  <tr>
   <td colspan="">
    '.$textarea.'
   </td>
  </tr>
 </table>
</body>
</html>';
echo $html_salida;
?>