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

//
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }
//

################### Conexion a la base de datos##########################
$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);

######################DEF FUNCIONES XAJAX########################
//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding("iso-8859-1");
// funciones para la libreria

 $consulta = mysql_query ( '
                            SELECT *
                            FROM atenciones_temp
                            WHERE traslado_aux > now( )
                            AND (color = 4 or color=7)
                            AND abierta <> 2
                            ORDER BY color ASC , id ASC
                           '
                         );
$html_salida = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PENDIENTES</title>
</head>
<body>
<table border="1" style="border:inherit" style=" font-family:\'Courier New\', Courier, monospace; font-size:12px">
  <tr>
   <td align="center" colspan="8" style=" background-color:'.$th_color.'">
    PENDIENTES
   <td>
  </tr>
  <tr>
   <td align="center" width="30" valign="top" style=" background-color:'.$th_color.'"> ID </td>
   <td align="center" width="494" valign="top" style=" background-color:'.$th_color.'"> DOMICILIO </td>
   <td align="center" width="50" valign="top" style=" background-color:'.$th_color.'"> TIPO </td>
   <td align="center" width="10" valign="top" style=" background-color:'.$th_color.'"> ZONA </td>
   <td align="center" width="58" valign="top" style=" background-color:'.$th_color.'"> COLOR </td>
   <td align="center" width="59" valign="top" style=" background-color:'.$th_color.'"> EDAD </td>
   <td align="center" width="59" valign="top" style=" background-color:'.$th_color.'"> NOMBRE </td>
   <td align="center" width="59" valign="top" style=" background-color:'.$th_color.'"> OBSERVACIONES </td>
  </tr>
';

while ($fila=mysql_fetch_array($consulta)){
 $consulta_color= mysql_query ("select * from colores where idcolor = '".$fila['color']."'");
 $ascii=mysql_fetch_array($consulta_color);

 $fecha_tr_view= explode("-",$fila['fecha']);

   if ($fila['color'] == 4 )
     $info_traslado = '<img src="imagenes/AMBUL01G.ICO" width="15" height="15"/>'." Fecha traslado: ".$fecha_tr_view[2]."-".$fecha_tr_view[1]."-".$fecha_tr_view[0]."-  Hora: ".$fila['horallam'];
     else $info_traslado="";

  if ($fila['color'] == 7 )
     $info_evento = " Fecha evento: ".$fecha_tr_view[2]."-".$fecha_tr_view[1]."-".$fecha_tr_view[0]."-  Hora: ".$fila['horallam'];
   else $info_evento="";

 $consulta_desc_zona = mysql_query ("SELECT *
                                     FROM zonas
                                     WHERE idzonas =".$fila['zona']); //idplan - descplan

   if ($consulta_desc_zona<> null)
   {
    $zona_vector=mysql_fetch_array($consulta_desc_zona);
    $zona_desc = substr($zona_vector['desczonas'],0,15);
   }else $zona_desc="&nbsp;";

 $dmotivo = buscomotivo($fila['motivo1'],$fila['motivo2']);

 $html_salida.='<form method="POST" action="atenciones.php">
                <tr>
                  <td width="30" valign="top" align="lefts" style="background-color:'.$td_color.'">
                   '.ltrim($fila['id'] , '0').'
                  </td>
                  <td width="494" valign="top" style="background-color:'.$td_color.'">
                   '.$fila['calle'].'&nbsp;'.$fila['numero'].' - Piso:'.$fila['piso'].' - Dpto: '.$fila['depto'].' - '.$fila['localidad'].'<br>'.$info_traslado.''.$info_evento.'
                  </td>
                  <td width="200" valign="top" style="background-color:'.$td_color.'">
                   '.$dmotivo.'
                  </td>
                  <td width="40" valign="top" style="background-color:'.$td_color.'">
                   '.$zona_desc.'
                  </td>
                  <td width="58" valign="" align="center" style="background-color:'.$ascii['codigo_ascii'].'" style="font-size:11px">
                  &nbsp;
                  </td>
                  <td width="59" valign="top" align="center" style="background-color:'.$td_color.'">
                   '.$fila['edad'].'
                  </td>
                  </td>
                  <td  valign="top" style="background-color:'.$td_color.'">
                   '.$fila['nombre'].'
                  </td>
                  <td valign="top" style="background-color:'.$td_color.'">
                   '.$fila['observa1'].'&nbsp;&nbsp;&nbsp;'.$fila['observa2'].'
                  </td>
                </tr>
                </form>

               ';
}
$html_salida.=
'
</table>
</form>
</body>
</html>
';
echo $html_salida;
?>