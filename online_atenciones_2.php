<?php
//funciones propias
include ('funciones.php');

//archivo de configuracion
include_once ('config.php');

//*  CONEXION A LA BASEDE DATOS
$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);
//*

//$idemergencia_temp_11 = $_GET['id_AA'];
//$ordenar = $_GET['orden'];

$idemergencia_temp_11 = 1;
$ordenar = 1;

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

$html_salida = '
<htm>
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
<title>Untitled Document</title>
</head>
<body>
<table border="0" style="border:inherit" style=" '.$font_family.' font-size:'.$fontdef.'" >
  <tr>
   <td align="center" width="17" valign="top" style=" background-color:'.$td_color.'">&nbsp;</td>
   <td align="center" width="60" valign="top" style=" background-color:'.$td_color.'"> ID </td>
   <td align="center" width="494" valign="top" style=" background-color:'.$td_color.'"> DOMICILIOsss </td>
   <td align="center" width="60" valign="top" style=" background-color:'.$td_color.'" > ZONA </td>
   <td align="center" width="120" valign="top" style=" background-color:'.$td_color.'"> PLAN </td>
   <td align="center" width="40" valign="top" style=" background-color:'.$td_color.'"> COLOR </td>
   <td align="center" width="40" valign="top" style=" background-color:'.$td_color.'"> EDAD </td>
   <td align="center" width="40" valign="top" style=" background-color:'.$td_color.'"> MOVIL </td>
   <td width="17" valign="top" style=" background-color:'.$td_color.'">A</td>
   <td width="17" valign="top" style=" background-color:'.$td_color.'">E</td>
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
                               FROM planes
                               WHERE idplan ='".$fila['plan']."'")); //idplan - descplan

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

/*
$html_salida.='<form method="POST" action="atenciones.php">
                <tr>
                  <td width="17" valign="top">
                   '.$fila['movil'].';   
				  </td>
				</tr>
                </form>  ';

*/



 $html_salida.='
                <tr>
                  <td width="17" valign="top" style="CURSOR: hand" '.$color_fila_ate.'>
                    <label onclick="this.form.submit();">
                     <img alt=\'Asignar\' src="imagenes/'.$fila['color'].'" width="15" height="15"/>
                    </label>
                   <input type="hidden" name="id_atencion_temp" id="id_atencion_temp" value="'.$fila['id'].'">
                   <input type="hidden" name="id_ordenar" id="id_ordenar" value="'.$ordenar.'">
                  </td>
                  <td width="60" valign="top" align="lefts" '.$color_fila_ate.' >
                  <label onclick="this.form.submit();" style="CURSOR: hand">
                   &nbsp;'.ltrim($fila['id'] , '0').'&nbsp;
                  </label>
                  </td>
                  <td width="494"  style="CURSOR: hand" valign="top" '.$color_fila_ate.' >
                    <label onclick="this.form.submit();" style="CURSOR: hand">
                   '.htmlentities($fila['calle']).'&nbsp;'.htmlentities($fila['numero']).$mpiso.htmlentities($fila['piso']).$mdepto.htmlentities($fila['depto']).' - '.htmlentities($fila['localidad']).'<br>'.$info_traslado.'
                   '.$info_evento.'
                   </label>
                  </td>
                  <td width="60" valign="top" '.$color_fila_zona.' >
                   <label onclick="this.form.submit();" style="CURSOR: hand">
                   &nbsp;'.htmlentities($zona_desc).'&nbsp;
                  </label>
                  </td>
                  <td width="120" valign="top" '.$color_fila_ate.' >
                   <label onclick="this.form.submit();" style="CURSOR: hand">
                   &nbsp;'.htmlentities($desc_plan['descabrev']).'&nbsp;
                  </label>
                  </td>
                  <td width="45" valign="" align="center" style="background-color:'.$ascii['codigo_ascii'].'" style="font-size:11px">
                   <label onclick="this.form.submit();" style="CURSOR: hand">
                   '.$fila['abierta'].'&nbsp
                   </label>
                  </td>
                  <td width="30" valign="top" align="center" '.$color_fila_ate.' >
                   <label onclick="this.form.submit();" style="CURSOR: hand">
                   &nbsp;'.htmlentities($fila['edad']).'&nbsp;
                   </label>
                  </td>
                  <td width="40" valign="top" align="center" '.$color_fila_ate.' >
                  <label onclick="this.form.submit();" style="CURSOR: hand">
                   &nbsp;'.$celda_movil.'&nbsp;
                  </label>
                  </td>
                  <td width="17" valign="top" '.$color_fila_ate.' style="CURSOR: hand" >
                   <label onClick="'.$onclick_anula.'" >
                   <img src="imagenes/b_drop.png" width="15" height="15"/>
                  </td>
                  <td width="17" valign="top" '.$color_fila_ate.' style="CURSOR: hand" >
                   <label onClick="window.open(\'mod_alta_edit.php?id_atencion=\'+\''.ltrim($fila['id'] , '0').'\',
                                                \'EDITAR\', \'width=2000,height=1000,scrollbars=yes\');" >
                   <img src="imagenes/b_edit.png" width="14" height="14"/>
                  </td>
                </tr>


               ';

			   
	   /*
			 $html_salida.='<form method="POST" action="atenciones.php"><tr>
            <td>
			 <input size="45" readonly="true"  type="hidden" name="documento" value="'.$fila['iddestino'].'">
			  '.$fila['edad'].'
			</td>
            <td>
			 <input size="45" readonly="true"  type="hidden" name="documento" value="'.$fila['destino'].'">
			 '.$fila['destino'].'</td>
            <td>
			 <input size="45" readonly="true"  type="hidden" name="documento" value="'.$fila['domicilio'].'">
			 '.$fila['domicilio'].'</td>
		   </tr></form>
          ';
		*/  

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
