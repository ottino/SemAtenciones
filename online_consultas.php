<?php
//funciones propias
include ('funciones.php');

//archivo de configuracion
include_once ('config.php');
//
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }
//
//*  CONEXION A LA BASEDE DATOS
$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);
//*


$id_atencion_temp = $_GET['id_atencion_temp'];

if (($id_atencion_temp <> null)) //and ($atencion_datos <> null))
{
$consulta_atencion = mysql_query("select * from atenciones_temp where id=".$id_atencion_temp);
$atencion_datos = mysql_fetch_array($consulta_atencion);
$consulta_zona = mysql_query ("select * from zonas where idzonas=".$atencion_datos['zona']);
$zona = mysql_fetch_array($consulta_zona);
$consulta_plan = mysql_query ("select * from planes where idplan=".$atencion_datos['plan']);
$plan = mysql_fetch_array($consulta_plan);
if ($atencion_datos['motivo1'] != null)
 {
  $consulta_motivo_desc = mysql_query("select * from motivos where idmotivo=".$atencion_datos['motivo1']." and idmotivo2 =".$atencion_datos['motivo2']);
  $fila_motivos = mysql_fetch_array($consulta_motivo_desc);
  $motivo_desc = $fila_motivos['desc'];
 }
else $motivo_desc="&nbsp;";
if ($atencion_datos['plan'] != null)
 {
  $consulta_plan_desc = mysql_query("select * from planes where idplan=".$atencion_datos['plan']);
  $plan_desc = mysql_fetch_array($consulta_plan_desc);
  $plan_desc_1 = $plan_desc['descplan'];
  $plan_desc = $plan_desc['datos'];
 }
else $plan_desc="&nbsp;";
}
// contadores de foquitos.
  $cons_cantidad_traslados_pendi = mysql_query ("
                                              SELECT count(*) AS CANTIDAD
                                              FROM atenciones_temp
                                              WHERE (color = '4')
                                              AND traslado_aux > now( )
                                              AND abierta <> '2'
                                              ORDER BY color ASC , id ASC ");
  $cantidad_traslados_pendi = mysql_fetch_array($cons_cantidad_traslados_pendi);

  $cons_cantidad_eventos_pendi = mysql_query ("
                                              SELECT count(*) AS CANTIDAD
                                              FROM atenciones_temp
                                              WHERE (color = '7')
                                              AND traslado_aux > now( )
                                              AND abierta <> '2'
                                              ORDER BY color ASC , id ASC");
  $cantidad_eventos_pendi = mysql_fetch_array($cons_cantidad_eventos_pendi);


  $consulta_foquitos = mysql_query ("SELECT color, count( * ) AS cantidad
                                     FROM atenciones_temp
                                     WHERE abierta <> '2'
                                     GROUP BY color
                                     ORDER BY 2 desc");

  while ($fila=mysql_fetch_array($consulta_foquitos))
   {
    if ($fila['color'] == 4)
     {
      //if ($cantidad_traslados_pendi['CANTIDAD'] < $fila['cantidad'])
      $foquitos.=$fila['cantidad']-$cantidad_traslados_pendi['CANTIDAD'].'&nbsp;<img src="imagenes/'.$fila['color'].'.ico" width="15" height="15" />&nbsp;';
     }else
     if ($fila['color'] == 7)
     {
      //if ($cantidad_traslados_pendi['CANTIDAD'] < $fila['cantidad'])
      $foquitos.=$fila['cantidad']-$cantidad_eventos_pendi['CANTIDAD'].'&nbsp;<img src="imagenes/'.$fila['color'].'.ico" width="15" height="15" />&nbsp;';
     }else
     {
       $foquitos.=$fila['cantidad'].'&nbsp;<img src="imagenes/'.$fila['color'].'.ico" width="15" height="15" />&nbsp;';
     }
   }
  $consulta_cantidad_total = mysql_query ("SELECT count( * ) AS cantidad
                                           FROM atenciones_temp
                                           WHERE abierta <> '2'");

  $cantidad_total = mysql_fetch_array($consulta_cantidad_total);

//$consulta = mysql_query ("SELECT * FROM atenciones_temp WHERE abierta <> 2 and color <> 4 ORDER BY color asc , id asc");
 $consulta = mysql_query ( '
                                SELECT *
                                FROM atenciones_temp, colores
                                WHERE
                                idcolor = color
                                AND color <> "4"
                                AND color <> "7"
                                and abierta <> "2"
                                UNION
                                SELECT *
                                FROM atenciones_temp , colores
                                WHERE
                                idcolor = color and
                                (color = "4" or color = "7")
                                AND traslado_aux <= now( )
                                AND abierta <> 2
                                ORDER BY orden ASC , id ASC
                           '
                         );

$imagen_home = "imagenes/home.jpg";
$imagen_atiempo = "imagenes/Logo_a_tiempo.jpg";

$html_salida = '
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
<link href="estilos.css" rel="stylesheet" type="text/css" />
<title>PANEL DE CONSULTAS</title>
</head>
<body style="background-color:'.$body_color.'">
<table width="100%"  border="0" style="font-size:'.$fontdef.'" style="background-color:'.$body_color.'">
  <tr>
    <td width="10%" rowspan="2" style=" background-color:'.$td_color.'" align="center"><img border="0" src="'.$imagen_atiempo.'" width="55" height="35"  align="center" /></td>
    <td width="6%" style=" background-color:'.$td_color.'" height="26">Socio</td>
    <td width="3%" style=" background-color:'.$td_color.'" align = "left"><input size = 30 type="text" disabled="disabled" value="'.$idemergencia_temp.'&nbsp;-&nbsp;'.elimina_caracteres(htmlentities($atencion_datos['nombre'])).'" /></td>
    <td width="2%" style=" background-color:'.$td_color.'" width="6">Edad</td>
    <td width="2%" style=" background-color:'.$td_color.'"><input size = 2 type="text" disabled="disabled" value="'.$atencion_datos['edad'].'" /></td>
    <td width="4%" style=" background-color:'.$td_color.'" >Sexo</td>
    <td width="1%" style=" background-color:'.$td_color.'"><input size = 1 type="text" disabled="disabled" value="'.$atencion_datos['sexo'].'" /></td>
    <td width="3%" style=" background-color:'.$td_color.'" >Tel</td>
    <td width="5%" style=" background-color:'.$td_color.'"><input size = 15 type="text" disabled="disabled" value="'.$atencion_datos['telefono'].'" /></td>
    <td width="4%" style=" background-color:'.$td_color.'" >Zona</td>
    <td width="3%" style=" background-color:'.$td_color.'"><input size = 7 type="text" disabled="disabled" value="'.$zona['idzonas'].'" /></td>
    <td width="1%" style=" background-color:'.$td_color.'"><input size = 1 type="text" disabled="disabled" value="'.$zona['fuerazona'].'" /></td>
    <td width="20%" style=" background-color:'.$td_color.'"><input size = 35 type="text" disabled="disabled" value="'.elimina_caracteres(htmlentities($zona['desczonas'])).'" /></td>
    <td rowspan="2" style=" background-color:'.$td_color.'" align="center"><a href="Principal.php?"/a> <img border="0" src="'.$imagen_home.'" width="55" height="35"  align="center" /></td>
  </tr>
  <tr>
    <td width="6%" style=" background-color:'.$td_color.'" height="30" align="">Plan</td>
    <td width="3%" style=" background-color:'.$td_color.'" colspan=3><input size = 55 type="text" disabled="disabled" value="'.$plan['idplan'].'&nbsp;&nbsp;-&nbsp;&nbsp;'.elimina_caracteres(htmlentities($plan['descplan'])).'" /></td>
    <td width="4%" style=" background-color:'.$td_color.'" colspan=2 style=" background-color:#999999" align="">IDENT</td>
    <td width="4%" style=" background-color:'.$td_color.'" colspan=3 ><input size = 20 type="text" disabled="disabled" value="'.elimina_caracteres(htmlentities($atencion_datos['identificacion'])).'" /></td>
    <td width="4%" style=" background-color:'.$td_color.'" colspan=1 style=" background-color:#999999" align="">Barrio</td>
    <td width="4%" style=" background-color:'.$td_color.'" colspan=2 ><input size = 40 type="text" disabled="disabled" value="'.elimina_caracteres(htmlentities($atencion_datos['barrio'])).'" /></td>
  </tr>
  <tr>
    <td><INPUT TYPE="BUTTON" value="Imprimir" ALIGN ="left" onclick ="window.print()"></td>
   <td colspan =13 align="center" style=" background-color:'.$td_color.' ; '.$font_family.' ; font-size:'.$fontdef.'">
    <img src="imagenes/241.ico" width="16" height="15" />&nbsp;EN LINEA:&nbsp;'.($cantidad_total['cantidad']  - $cantidad_traslados_pendi['CANTIDAD'] - $cantidad_eventos_pendi['CANTIDAD']).'&nbsp;&nbsp;&nbsp;'.$foquitos.'
    PENDIENTES ('.($cantidad_traslados_pendi['CANTIDAD'] + $cantidad_eventos_pendi['CANTIDAD']).'): Traslados '.$cantidad_traslados_pendi['CANTIDAD'].'  Eventos '.$cantidad_eventos_pendi['CANTIDAD'].'
    DETALLE  <img style="CURSOR: pointer" src="imagenes/Alert 01.ico" width="16" height="16" onClick="window.open(\'popup_tras_pendi_cons.php\',\'PENDIENTES\', \'width=1200,height=700,scrollbars=yes\');"/>
   </td>
  </tr>
</table>
<div id="llamadas" >
<table width="1215" border="0" style="border:inherit" style=" '.$font_family.' font-size:'.$fontdef.'" >
 <tr>
   <td align="center" width="17" valign="top" style=" background-color:'.$td_color.'">&nbsp;</td>
   <td align="center" width="60" valign="top" style=" background-color:'.$td_color.'"> ID </td>
   <td align="center" width="294" valign="top" style=" background-color:'.$td_color.'"> DOMICILIO </td>
   <td align="center" width="200" valign="top" style=" background-color:'.$td_color.'"> NOMBRE </td>
   <td align="center" width="60" valign="top" style=" background-color:'.$td_color.'"> ZONA </td>
   <td align="center" width="120" valign="top" style=" background-color:'.$td_color.'"> PLAN </td>
   <td align="center" width="40" valign="top" style=" background-color:'.$td_color.'"> COLOR </td>
   <td align="center" width="40" valign="top" style=" background-color:'.$td_color.'"> EDAD </td>
   <td align="center" width="40" valign="top" style=" background-color:'.$td_color.'"> MOVIL </td>
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
 if ($fila['movil'] == 0) $celda_movil="&nbsp"; else $celda_movil=$fila['movil'];

 if ($fila['abierta'] == 1)
   $fila['abierta'] = 'CERRAR';


 $consulta_desc_zona = mysql_query ("SELECT *
                                     FROM zonas
                                     WHERE idzonas ='".$fila['zona']."'"); //idplan - descplan

   if ($consulta_desc_zona<> null)
   {
    $zona_vector=mysql_fetch_array($consulta_desc_zona);
    $zona_desc = substr($zona_vector['desczonas'],0,15);
   }else $zona_desc="&nbsp;";

    $desc_plan =  mysql_fetch_array(mysql_query ("SELECT *
                               FROM planes
                               WHERE idplan ='".$fila['plan']."'")); //idplan - descplan

 if ($fila['id'] == $id_atencion_temp)
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


 $html_salida.='<form method="GET" action="online_consultas.php">
                <tr>
                  <td width="17" valign="top" '.$color_fila_ate.'>
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img alt=\'Asignar\' src="imagenes/'.$fila['color'].'" width="15" height="15"/>
                    </label>
                   <input type="hidden" name="id_atencion_temp" id="id_atencion_temp" value="'.$fila['id'].'">
                  </td>
                  <td width="60" valign="top" align="left" '.$color_fila_ate.' >
                  <label onclick="this.form.submit();" style="CURSOR: pointer">
                   &nbsp;'.ltrim($fila['id'] , '0').'&nbsp;
                  </label>
                  </td>
                  <td width="294" valign="top" '.$color_fila_ate.' >
                    <label onclick="this.form.submit();" style="CURSOR: pointer">
                   '.htmlentities($fila['calle']).'&nbsp;'.htmlentities($fila['numero']).$mpiso.htmlentities($fila['piso']).$mdepto.htmlentities($fila['depto']).' - '.htmlentities($fila['localidad']).'<br>'.$info_traslado.'
                   '.$info_evento.'
                   </label>
                  </td>
                  <td width="200" valign="top" '.$color_fila_ate.' >
                   <label onclick="this.form.submit();" style="CURSOR: pointer">
                   &nbsp;'.elimina_caracteres(htmlentities($fila['nombre'])).'&nbsp;
                  </label>
                  </td>
                  <td width="60" valign="top" '.$color_fila_ate.' >
                   <label onclick="this.form.submit();" style="CURSOR: pointer">
                   &nbsp;'.htmlentities($zona_desc).'&nbsp;
                  </label>
                  </td>
                  <td width="120" valign="top" '.$color_fila_ate.' >
                   <label onclick="this.form.submit();" style="CURSOR: pointer">
                   &nbsp;'.htmlentities($desc_plan['descabrev']).'&nbsp;
                  </label>
                  </td>
                  <td width="45" valign="" align="center" style="background-color:'.$ascii['codigo_ascii'].'" style="font-size:11px">
                   <label onclick="this.form.submit();" style="CURSOR: pointer">
                   '.$fila['abierta'].'&nbsp
                   </label>
                  </td>
                  <td width="30" valign="top" align="center" '.$color_fila_ate.' >
                   <label onclick="this.form.submit();" style="CURSOR: pointer">
                   &nbsp;'.htmlentities($fila['edad']).'&nbsp;
                   </label>
                  </td>
                  <td width="40" valign="top" align="center" '.$color_fila_ate.' >
                  <label onclick="this.form.submit();" style="CURSOR: pointer">
                   &nbsp;'.$celda_movil.'&nbsp;
                  </label>
                  </td>
                </tr>
                </form>

               ';
}
$html_salida.=
'
</table>
</div>
<table width="100%" border=0 cellspacing="0" style= "font-size:'.$fontdef.'">
 <tr>
  <td colspan=2 style=" background-color:'.$td_color.' ; font-size:'.$fontdef.'" alig="right">
   <table border=0><tr><td style=" background-color:'.$td_color.' ; font-size:'.$fontdef.'"><label>MOTIVOS DEL LLAMADO:&nbsp;&nbsp;&nbsp;'.$atencion_datos['motivo1'].'-'.$atencion_datos['motivo2'].'-'.elimina_caracteres(htmlentities($motivo_desc)).'</label></tr></td></table>
  </td>
</tr>
</table>
       <textarea type="text" name="notas" rows="20" cols="152" align="left">
       '.$plan_desc.'

       *********************************       Información personal del cliente.        *********************************

       * Apellido y nombre    : '.elimina_caracteres(htmlentities($atencion_datos['nombre'])).'
       * Edad                 : '.$atencion_datos['edad'].'
       * Sexo                 : '.$atencion_datos['sexo'].'
       * Calle                : '.elimina_caracteres(htmlentities($atencion_datos['calle'])).'
       * Numero               : '.$atencion_datos['numero'].'
       * Piso                 : '.$atencion_datos['piso'].'
       * Departamento         : '.$atencion_datos['depto'].'
       * Casa                 : '.$atencion_datos['casa'].'
       * Monoblok             : '.$atencion_datos['monoblok'].'
       * Barrio               : '.elimina_caracteres(htmlentities($atencion_datos['barrio'])).'
       * Entre                : '.elimina_caracteres(htmlentities($atencion_datos['entre1'])).' y '.elimina_caracteres(htmlentities($atencion_datos['entre2'])).'
       * Localidad            : '.elimina_caracteres(htmlentities($atencion_datos['localidad'])).'
       * Referencia           : '.elimina_caracteres(htmlentities($atencion_datos['referencia'])).'
       * Observaciones        : '.elimina_caracteres(htmlentities($atencion_datos['observa1'])).'   -   '.elimina_caracteres(htmlentities($atencion_datos['observa2'])).'
       * Telefono             : '.$atencion_datos['telefono'].'
       * Plan                 : '.$padron_datos_para_obs['plan'].'
       * Fecha nacimiento     : '.$padron_datos_para_obs['fnacimiento'].'
       * Documento            : '.$padron_datos_para_obs['documento'].'
       * Tipo de Socio        : '.$padron_datos_para_obs['tiposocio'].'

       ******************************************************************************************************************
       *********************************          Información sobre horarios.           *********************************

       * LLAMADOS
       * Hora llamado    : '.$atencion_datos['horallam'].'
       * Despacho        : '.$atencion_datos['horadesp'].'
       * Salida base     : '.$atencion_datos['horasalbase'].'
       * Llegada dom     : '.$atencion_datos['horallegdom'].'
       * Salida  dom     : '.$atencion_datos['horasaldom'].'
       * Llegada hosp    : '.$atencion_datos['horalleghosp'].'
       * Salida  hosp    : '.$atencion_datos['horasalhosp'].'


       * RECLAMOS
       * Primer  reclamo : '.$atencion_datos['reclamo_1'].'
       * Segundo reclamo : '.$atencion_datos['reclamo_2'].'
       * Tercer  reclamo : '.$atencion_datos['reclamo_3'].'


       ******************************************************************************************************************
       *********************************             Información sobre Plan.            *********************************
       * Codigo Plan          : '.$atencion_datos['plan'].'
       * Descripcion del plan : '.$plan_desc_1.'
       * Datos                : '.$plan_desc.'
       </textarea>

</body>
</html>
';
echo $html_salida;
?>
