<?php
//funciones propias
include ('funciones.php');

//archivo de configuracion
include_once ('config.php');

//*  CONEXION A LA BASEDE DATOS
$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);
//*


// contadores de foquitos.
$cons_cantidad_traslados_pendi = mysql_query ("
                                            SELECT count(*) AS CANTIDAD
                                            FROM atenciones_temp
                                            WHERE traslado_aux > now( )
                                            AND (color = 4)
                                            AND abierta <> 2
                                            ORDER BY color ASC , id ASC
                                         ");
$cantidad_traslados_pendi = mysql_fetch_array($cons_cantidad_traslados_pendi);

$cons_cantidad_eventos_pendi = mysql_query ("
                                            SELECT count(*) AS CANTIDAD
                                            FROM atenciones_temp
                                            WHERE traslado_aux > now( )
                                            AND (color = 7)
                                            AND abierta <> 2
                                            ORDER BY color ASC , id ASC
                                         ");
$cantidad_eventos_pendi = mysql_fetch_array($cons_cantidad_eventos_pendi);


$consulta_foquitos = mysql_query ("SELECT color, count( * ) AS cantidad
                                   FROM atenciones_temp
                                   WHERE abierta <> 2
                                   GROUP BY color
                                   ORDER BY 2 desc");

while ($fila=mysql_fetch_array($consulta_foquitos))
 {
  if ($fila['color'] == 4)
   {
    //if ($cantidad_traslados_pendi['CANTIDAD'] < $fila['cantidad'])
    $foquitos.=$fila['cantidad']-$cantidad_traslados_pendi['CANTIDAD'].'&nbsp;<img src="imagenes/'.$fila['color'].'.ico" width="15" height="15" />&nbsp';
   }else
   if ($fila['color'] == 7)
   {
    //if ($cantidad_traslados_pendi['CANTIDAD'] < $fila['cantidad'])
    $foquitos.=$fila['cantidad']-$cantidad_eventos_pendi['CANTIDAD'].'&nbsp;<img src="imagenes/'.$fila['color'].'.ico" width="15" height="15" />&nbsp';
   }else
   {
     $foquitos.=$fila['cantidad'].'&nbsp;<img src="imagenes/'.$fila['color'].'.ico" width="15" height="15" />&nbsp';
   }
 }
$consulta_cantidad_total = mysql_query ("SELECT count( * ) AS cantidad
                                         FROM atenciones_temp
                                         WHERE abierta <> 2");

$cantidad_total = mysql_fetch_array($consulta_cantidad_total);

//$consulta = mysql_query ("SELECT * FROM atenciones_temp WHERE abierta <> 2 and color <> 4 ORDER BY color asc , id asc");
 $consulta = mysql_query ( '
                                SELECT *
                                FROM atenciones_temp, colores
                                WHERE
                                idcolor = color and
                                abierta <> 2
                                AND color <> 4
                                AND color <> 7
                                UNION
                                SELECT *
                                FROM atenciones_temp , colores
                                WHERE
                                idcolor = color and
                                traslado_aux <= now( )
                                AND (color = 4 or color = 7)
                                AND abierta <> 2
                                ORDER BY orden ASC , id ASC
                           '
                         );
$html_salida = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<SCRIPT TYPE="text/javascript">
function popup(mylink)
{
if (! window.focus)return true;
var href;
if (typeof(mylink) == "string")
   href=mylink;
else
   href=mylink.href;
window.open(href, "asdasd", "width=400,height=200,scrollbars=yes");
return false;
}
</SCRIPT>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
</head>
<body>
<table border="0" style="border:inherit" style=" font-family:\'Courier New\', Courier, monospace; font-size:'.$fontdef.'">
  <tr>
   <td align="" colspan="9" style=" background-color:'.$td_color.' ; font-family:\'Courier New\', Courier, monospace; font-size:'.$fontdef.'">
    <img src="imagenes/241.ico" width="16" height="15" />&nbsp;EN LINEA:'.($cantidad_total['cantidad']  - $cantidad_traslados_pendi['CANTIDAD'] - $cantidad_eventos_pendi['CANTIDAD']).'&nbsp;'.$foquitos.'
    PENDIENTES ('.($cantidad_traslados_pendi['CANTIDAD'] + $cantidad_eventos_pendi['CANTIDAD']).'): Traslados '.$cantidad_traslados_pendi['CANTIDAD'].'  Eventos '.$cantidad_eventos_pendi['CANTIDAD'].'
    DETALLE  <img style="CURSOR: hand" src="imagenes/Alert 01.ico" width="16" height="16" onClick="window.open(\'popup_traslados_pendi.php\',\'ANULACIONES\', \'width=1200,height=700,scrollbars=yes\');"/>
   <td>
  </tr>
  <tr>
   <td align="center" width="17" valign="top" style=" background-color:'.$td_color.'">&nbsp;</td>
   <td align="center" width="85" valign="top" style=" background-color:'.$td_color.'"> ID </td>
   <td align="center" width="494" valign="top" style=" background-color:'.$td_color.'"> DOMICILIO </td>
   <td align="center" width="20" valign="top" style=" background-color:'.$td_color.'"> ZONA </td>
   <td align="center" width="58" valign="top" style=" background-color:'.$td_color.'"> COLOR </td>
   <td align="center" width="59" valign="top" style=" background-color:'.$td_color.'"> EDAD </td>
   <td align="center" width="55" valign="top" style=" background-color:'.$td_color.'"> MOVIL </td>
   <td width="17" valign="top" style=" background-color:'.$td_color.'">A</td>
   <td width="17" valign="top" style=" background-color:'.$td_color.'">E</td>
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
 // calculo para los traslados ,eventos y alertas
 if (($fila['color'] <> 4 )&&(restaHoras($fila['horallam'], date("H:i:s")) > $ascii['alerta']) && ($fila['horasalbase'] == '00:00:00'))
  {
     $fila['color'] = 'alerta_'.$fila['color'].'.gif';
  }
  else
  if ((($fila['color'] == 4 ) || ($fila['color'] == 7 ) )&& ($fila['horallam'] < date("H:i:s")) && ($fila['fecha'] == date("Y-m-d")) && ($fila['horasalbase'] == '00:00:00'))
      {
        $fila['color'] = 'alerta_'.$fila['color'].'.gif';
      }
  else
  if ((($fila['color'] == 4 ) || ($fila['color'] == 7 ) ) && ($fila['fecha'] < date("Y-m-d")))
      {
        $fila['color'] = 'alerta_'.$fila['color'].'.gif';
      }
  else $fila['color'] = $fila['color'].'.ico';

 // mostrar info del movil asignado
 if ($fila['movil'] == 0) $celda_movil="&nbsp"; else $celda_movil=$fila['movil'];

 if ($fila['abierta'] == 1)
   $fila['abierta'] = 'CERRAR';


 $consulta_desc_zona = mysql_query ("SELECT *
                                     FROM zonas
                                     WHERE idzonas =".$fila['zona']); //idplan - descplan

   if ($consulta_desc_zona<> null)
   {
    $zona_vector=mysql_fetch_array($consulta_desc_zona);
    $zona_desc = substr($zona_vector['desczonas'],0,15);
   }else $zona_desc="&nbsp;";


 $html_salida.='<form method="POST" action="atenciones.php">
                <tr>
                  <td width="17" valign="top" style="background-color:'.$td_color.'" style="CURSOR: hand" >
                    <label onclick="this.form.submit();">
                     <img alt=\'Asignar\' src="imagenes/'.$fila['color'].'" width="15" height="15"/>
                    </label>
                   <input type="hidden" name="id_atencion_temp" id="id_atencion_temp" value="'.$fila['id'].'">
                  </td>
                  <td width="85" valign="top" align="lefts" style="background-color:'.$td_color.'">
                   '.ltrim($fila['id'] , '0').'
                  </td>
                  <td width="494" valign="top" style="background-color:'.$td_color.'">
                   '.$fila['calle'].'&nbsp;'.$fila['numero'].' - Piso:'.$fila['piso'].' - Dpto: '.$fila['depto'].' - '.$fila['localidad'].'<br>'.$info_traslado.'
                   '.$info_evento.'
                  </td>
                  <td width="200" valign="top" style="background-color:'.$td_color.'">
                   '.$zona_desc.'
                  </td>
                  <td width="58" valign="" align="center" style="background-color:'.$ascii['codigo_ascii'].'" style="font-size:11px">
                   '.$fila['abierta'].'
                  </td>
                  <td width="59" valign="top" align="center" style="background-color:'.$td_color.'">
                   '.$fila['edad'].'
                  </td>
                  <td width="55" valign="top" align="center" style="background-color:'.$td_color.'">
                   '.$celda_movil.'
                  </td>
                  <td width="17" valign="top" style="background-color:'.$td_color.'" style="background-color:'.$td_color.'" style="CURSOR: hand" >
                   <label onClick="window.open(\'online_anulaciones.php?id_atencion=\'+\''.ltrim($fila['id'] , '0').'\',
                                                \'ANULACIONES\', \'width=480,height=285,scrollbars=yes\');" >
                   <img src="imagenes/b_drop.png" width="15" height="15"/>
                  </td>
                  <td width="17" valign="top" style="background-color:'.$td_color.'" style="background-color:'.$td_color.'" style="CURSOR: hand" >
                   <label onClick="window.open(\'mod_alta_edit.php?id_atencion=\'+\''.ltrim($fila['id'] , '0').'\',
                                                \'EDITAR\', \'width=2000,height=1000,scrollbars=yes\');" >
                   <img src="imagenes/b_edit.png" width="14" height="14"/>
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
