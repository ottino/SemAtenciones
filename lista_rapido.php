<?php

function muestra_listado_temp ($idemergencia_temp_11 , $ordenar)
{

include_once ('config.php');
$td_color = '';
$body_color= '';

switch ($ordenar) {
    case 1:
    $consulta = mysql_query ( "SELECT * FROM atenciones_temp, colores WHERE color = idcolor AND abierta <> '2' AND traslado_aux <= now( )
                                ORDER BY orden ASC , id ASC ");
        break;
    case 2:
    $consulta = mysql_query ( "SELECT * FROM atenciones_temp, colores WHERE color = idcolor AND abierta <> '2' AND traslado_aux <= now( )
                                ORDER BY orden ASC, zona ASC, id ASC ");
        break;
    case 3:
    $consulta = mysql_query ( "SELECT * FROM atenciones_temp, colores WHERE color = idcolor AND abierta <> '2' AND traslado_aux <= now( )
                                ORDER BY movil DESC , orden ASC ");
        break;
    case 4:
    $consulta = mysql_query ( "SELECT * FROM atenciones_temp, colores WHERE color = idcolor AND abierta <> '2' AND traslado_aux <= now( )
                                ORDER BY orden ASC , plan ASC, id DESC ");
        break;
}

$ver = $idemergencia_temp_11;
$html_salida = '
<html>
<head>
       <link rel="stylesheet/less" type="text/css" href="css/estilos.less" />       
       <script type="text/javascript" src="js/less.js"></script>
       
        <script type="text/javascript">
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
        </script>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>
<body>
<table class="llamados">
  <tr>
   <th>*</th>
   <th>Id</th>
   <th>Online</th>
   <th>Zona</th>
   <th>Plan</th>
   <th>Color</th>
   <th>Edad</th>
   <th>Movil</th>
   <th>A</th>
   <th>E</th>
   <th>LL</th>
  </tr>
';

while ($fila=mysql_fetch_array($consulta)){
 $consulta_color= mysql_query ("select * from colores where idcolor = '".$fila['color']."'");
 $ascii=mysql_fetch_array($consulta_color);

 $fecha_tr_view= explode("-",$fila['fecha']);

  if ($fila['color'] == 4 )
     $info_traslado = '<img src="imagenes/AMBUL01G.ICO" width="15" height="15"/>'." Fecha: ".$fecha_tr_view[2]."-".$fecha_tr_view[1]."-".$fecha_tr_view[0]." Hora: ".$fila['horallam'];
  else $info_traslado="";

  if ($fila['color'] == 7 )
     $info_evento = " Fecha evento: ".$fecha_tr_view[2]."-".$fecha_tr_view[1]."-".$fecha_tr_view[0]." Hora: ".$fila['horallam'];
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
  if ($fila['movil'] == 0)
   {
    $celda_movil="&nbsp";
    $onclick_anula = 'window.open(\'online_anulaciones.php?id_atencion=\'+\''.ltrim($fila['id'] , '0').'\',
                                                 \'ANULACIONES\', \'width=480,height=285,scrollbars=yes\');';

   }
    else {
           $celda_movil=$fila['movil'];
           $onclick_anula = "alert ('No se puede anular (tiene asignado el movil ".$fila['movil'] ."), primero desasigne movil');";
         }

 if ($fila['abierta'] == 1)
   $fila['abierta'] = 'CERRAR';


 $consulta_desc_zona = mysql_query ("SELECT *
                                     FROM zonas
                                     WHERE idzonas ='".$fila['zona']."'"); //idplan - descplan

   if ($consulta_desc_zona<> null)
   {
    $zona_vector=mysql_fetch_array($consulta_desc_zona);
    $zona_desc = substr($zona_vector['desczonas'],0,15);
    $zona_color = $zona_vector['colorzona'];
    $color_fila_zona = 'style="background-color:'.$zona_color.'"';
   }else $zona_desc="&nbsp;";

    $desc_plan =  mysql_fetch_array(mysql_query ("SELECT *
                               FROM convenios
                               WHERE id ='".$fila['plan']."'")); //idplan - descplan

 if ($fila['id'] == $idemergencia_temp_11)
  {
   $color_fila_ate = 'style="background-color:'.$body_color.'"';
  } else $color_fila_ate = 'style="background-color:'.$td_color.'"';

 if ($fila['piso'] == '')
  {
   $mpiso = '';
  } else $mpiso = ' - Piso: ';

 if ($fila['depto'] == '')
  {
   $mdepto = '';
  } else $mdepto = ' - Dpto: ';




 $html_salida.='
                 <tr>
                  <td>
                  <form method="POST" action="atenciones.php" class="tabla">
                   <input type="hidden" name="id_atencion_temp" id="id_atencion_temp" value="'.$fila['id'].'">
                   <input type="hidden" name="id_ordenar" id="id_ordenar" value="'.$ordenar.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img alt=\'Asignar\' src="imagenes/'.$fila['color'].'" width="15" height="15"/>
                    </label>
                  </form></td>
                  <td>
                  <form method="POST" action="atenciones.php" class="tabla">
                   <input type="hidden" name="id_atencion_temp" id="id_atencion_temp" value="'.$fila['id'].'">
                   <input type="hidden" name="id_ordenar" id="id_ordenar" value="'.$ordenar.'">
                  <label onclick="this.form.submit();" style="CURSOR: pointer">
                   '.ltrim($fila['id'] , '0').'
                  </label>
                  </form></td>
                  <td>
                   '.htmlentities($fila['calle']).''.htmlentities($fila['numero']).$mpiso.htmlentities($fila['piso']).$mdepto.htmlentities($fila['depto']).' - '.htmlentities($fila['localidad']).'<br>'.$info_traslado.'
                   '.$info_evento.'
                  </td>
                  <td '.$color_fila_zona.' >
                   '.htmlentities($zona_desc).'
                  </td>
                  <td >
                   '.htmlentities($desc_plan['descripcion']).'
                  </td>
                  <td  valign="" align="center" style="background-color:'.$ascii['codigo_ascii'].'" style="font-size:11px">
                   '.$fila['abierta'].'&nbsp
                  </td>
                  <td  align="center"  >
                   '.htmlentities($fila['edad']).'
                  </td>
                  <td  align="center"  >
                   '.$celda_movil.'
                  </td>
                  <td >
                   <label onClick="'.$onclick_anula.'" style="CURSOR: pointer" >
                   <img src="imagenes/b_drop.png" width="15" height="15" />
                  </td>
                  <td  >
                   <label onClick="window.open(\'mod_alta_edit.php?id_atencion=\'+\''.ltrim($fila['id'] , '0').'\',
                                                \'EDITAR\', \'width=2000,height=1000,scrollbars=yes\');" style="CURSOR: pointer" >
                   <img src="imagenes/b_edit.png"  width="14" height="14" />
                  </td>
                  <td >
                   <label onClick="window.open(\'mod_alta_llam.php?id_atencion=\'+\''.ltrim($fila['id'] , '0').'\',
                                                \'AGREGAR LLAMADO\', \'width=2000,height=1000,scrollbars=yes\');" style="CURSOR: pointer" >
                   <img src="imagenes/241.ico" width="14" height="14"/>
                  </td>				  
                </tr>
               ';
  }
$html_salida.=
'
</table>
</form>
</body>
</html>
';
return $html_salida;
}
?>