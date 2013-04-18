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

######################DEF FUNCIONES XAJAX########################

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding("iso-8859-1");
// funciones para la libreria

function func_lista_planes ($id_plan)
{
       $consulta_planes = mysql_query("SELECT * FROM planes");
       $html_salida     ='<select name="list_planes"
                                  onchange="xajax_func_input_planes(document.formulario.list_planes.value);
                                  xajax_func_datos_padron(0,0,0);
                                  xajax_func_datos_domicilio(0,0,0);
                                  xajax_fun_alerta_zona(0);
                                  xajax_func_lista_planes(document.formulario.list_planes.value);
                                  ">';
       $textarea = '<textarea cols="60" rows="10"></textarea>';
       if ($id_plan == 0)
         $html_salida.='<option value="0" selected="selected">Lista de Planes</option>';

       while ($fila=mysql_fetch_array($consulta_planes))
             {
               if ($id_plan == $fila['idplan'])
               {
                $textarea = '<td><textarea cols="60" rows="10">'.elimina_caracteres(htmlentities($fila['datos'])).'</textarea></td>';
                $html_salida.='<option selected="selected" value="'.$fila['idplan'].'" />'.elimina_caracteres(htmlentities($fila['descplan'])).'</option>';
               }
               else
                {
                 $html_salida.='<option value="'.$fila['idplan'].'" />'.elimina_caracteres(htmlentities($fila['descplan'])).'</option>';
                }
             }

       $html_salida.='</select>';


   $salida = $html_salida;
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("s_lista_planes","innerHTML",$salida);
   $respuesta->addAssign("div_muestra_textarea","innerHTML",$textarea);
   return $respuesta;
}

function func_input_planes ($id_plan)
{
   $html_salida = '<input id="i_busca_plan" size="7" type="text" value="'.$id_plan.'"
                    onChange="xajax_func_datos_padron(0,0,0);xajax_func_datos_domicilio(0,0,0);xajax_fun_alerta_zona(0)"
                    onKeyUp="xajax_func_lista_planes(document.formulario.i_busca_plan.value);">';
   $salida = $html_salida;
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("i_lista_planes","innerHTML",$salida);
   return $respuesta;
}

function func_datos_padron ($id_plan , $dato , $filtro)
{
 global $td_color;


 switch ($filtro) {
    case 1:
        if (($dato <> ' ') && ($dato <> '') && ($dato <> null))
         {
          $consulta_padron=mysql_query ("SELECT * FROM padron WHERE idpadron ='".$dato."'
                                         AND ( plan = '".ltrim($id_plan ,'0')."' OR plan = '".$id_plan."')");
          $padron_fetch = mysql_fetch_array($consulta_padron);
          if (mysql_affected_rows()==0)
          {
           $edad = '&nbsp;';
          }
          else
          {
           $edad = edad($padron_fetch['fnacimiento']);
           $disabled='disabled="disabled"';
          }
         } else  $edad = ' ';
        break;
    case 2:
        if (($dato <> ' ') && ($dato <> '') && ($dato <> null))
         {
          $consulta_padron=mysql_query ("SELECT * FROM padron WHERE documento ='".$dato."'
                                         AND ( plan = '".ltrim($id_plan ,'0')."' OR plan = '".$id_plan."')");
          $padron_fetch = mysql_fetch_array($consulta_padron);
          if (mysql_affected_rows()==0)
          {
           $edad = '&nbsp;';
          }
          else
           {
            $edad = edad($padron_fetch['fnacimiento']);
            $disabled='disabled="disabled"';
           }
         } else  $edad = ' ';
        break;
    case 3:
        if (($dato <> ' ') && ($dato <> '') && ($dato <> null))
         {
          $consulta_padron=mysql_query ("SELECT * FROM padron WHERE nombre like '%".$dato."%'
                                         AND ( plan = '".ltrim($id_plan ,'0')."' OR plan = '".$id_plan."')");
          $padron_fetch = mysql_fetch_array($consulta_padron);
          if (mysql_affected_rows()==0)
           {
            $edad = '&nbsp;';
           }
          else
           {
           $edad = edad($padron_fetch['fnacimiento']);
           $disabled='disabled="disabled"';
           }
         } else  $edad = ' ';
        break;
 }


 $html_salida ='
  <tr>
    <td  colspan="" align="center" ><input id="td_padron_idpadron" value="'.$padron_fetch['idpadron'].'" style=" background-color:'.$td_color.'" size="12" type="text" '.$disabled.' /></td>
    <td  colspan="" align="center" ><input id="td_padron_tiposocio" value="'.$padron_fetch['tiposocio'].'" style=" background-color:'.$td_color.'" size="4" type="text" '.$disabled.' /></td>
    <td  colspan="" align="center" ><input id="td_padron_nombre" value="'.elimina_caracteres(htmlentities($padron_fetch['nombre'])).'" style=" background-color:'.$td_color.'" size="55" type="text" '.$disabled.' /></td>
    <td  width="" align="right"    ><input id="td_padron_edad" value="'.$edad.'" style=" background-color:'.$td_color.'" size="4" type="text"  '.$disabled.' /></td>
    <td  width="" align="right"    ><input id="td_padron_sexo" value="'.$padron_fetch['sexo'].'" style=" background-color:'.$td_color.'" size="3" type="text" '.$disabled.'  /></td>
    <td  width="" align="right"    ><input id="td_padron_identi" value="'.elimina_caracteres(htmlentities($padron_fetch['identificacion'])).'" style=" background-color:'.$td_color.'" size="28" type="text" '.$disabled.' /></td>
    <td  width="" align="right"    ><input id="td_padron_docum" value="'.$padron_fetch['documento'].'" style=" background-color:'.$td_color.'" size="25" type="text" '.$disabled.' /></td>
 </tr>
 ';

   $salida = $html_salida;
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("td_datos_padron","innerHTML",$salida);
   return $respuesta;
}

function func_datos_domicilio ($id_plan , $dato , $filtro)
{
 global $td_color , $path_imagenes_ruta;;

 switch ($filtro) {
    case 1:
        if (($dato <> ' ') && ($dato <> '') && ($dato <> null))
         {
          $consulta_padron=mysql_query ("SELECT * FROM padron WHERE idpadron ='".$dato."'
                                         AND ( plan = '".ltrim($id_plan ,'0')."' OR plan = '".$id_plan."')");
          $padron_fetch = mysql_fetch_array($consulta_padron);
          if (mysql_affected_rows()==0)
           $edad = '&nbsp;';
          else
           $edad = edad($padron_fetch['fnacimiento']);
         } else  $edad = ' ';
        break;
    case 2:
        if (($dato <> ' ') && ($dato <> '') && ($dato <> null))
         {
          $consulta_padron=mysql_query ("SELECT * FROM padron WHERE documento ='".$dato."'
                                         AND ( plan = '".ltrim($id_plan ,'0')."' OR plan = '".$id_plan."')");
          $padron_fetch = mysql_fetch_array($consulta_padron);
          if (mysql_affected_rows()==0)
           $edad = '&nbsp;';
          else
           $edad = edad($padron_fetch['fnacimiento']);
         } else  $edad = ' ';
        break;
    case 3:
        if (($dato <> ' ') && ($dato <> '') && ($dato <> null))
         {
          $consulta_padron=mysql_query ("SELECT * FROM padron WHERE nombre like '%".$dato."%'
                                         AND ( plan = '".ltrim($id_plan ,'0')."' OR plan = '".$id_plan."')");
          $padron_fetch = mysql_fetch_array($consulta_padron);
          if (mysql_affected_rows()==0)
           $edad = '&nbsp;';
          else
           $edad = edad($padron_fetch['fnacimiento']);
         } else  $edad = ' ';
        break;
 }

 $consulta_zona = mysql_query("SELECT * FROM zonas");
 $zona_vector = '<select name="s_lista_zonas" onChange ="xajax_fun_alerta_zona(document.formulario.s_lista_zonas.value)">
                  <option selected="selected" value="0" >ZONAS</option>';
 while ($fila=mysql_fetch_array($consulta_zona))
 {
  if ($padron_fetch['zona'] == $fila['idzonas'])
   {
    $zona_vector.= '<option selected="selected" value="'.$fila['idzonas'].'">'.$fila['desczonas'].'</option>';

    if ($fila['fuerazona'] == 'V')
     $img='<img src="'.$path_imagenes_ruta.'/alerta_fz_blanco.gif" />';
    else if ($fila['fuerazona'] == 'F')
         $img='<img src="'.$path_imagenes_ruta.'/alerta_dentro_zn.gif" />';
   }
  else
    $zona_vector.= '<option value="'.$fila['idzonas'].'">'.$fila['desczonas'].'</option>';
 }
 $zona_vector.= '</select>';


 $html_salida = '
                 <table border="0" align="center" width="1000">
                  <tr>
                    <td width="24%" align="center" style=" background-color:'.$td_color.'">Calle</td>
                    <td width="5%" align="center"  style=" background-color:'.$td_color.'">Nro</td>
                    <td width="5%" align="center"  style=" background-color:'.$td_color.'">Piso</td>
                    <td width="5%" align="center"  style=" background-color:'.$td_color.'">Dpto.</td>
                    <td width="6%" align="center"  style=" background-color:'.$td_color.'">Casa</td>
                    <td width="6%" align="center"  style=" background-color:'.$td_color.'">Mon</td>
                    <td width="45%" align="center"  style=" background-color:'.$td_color.'">Referencia</td>
                  </tr>
                  <tr>
                    <td style="background-color:#CCCCCC"><input value="'.elimina_caracteres(htmlentities($padron_fetch['calle'])).'" type="text"    id="td_padron_calle" size="40"/></td>
                    <td style="background-color:#CCCCCC"><input value="'.elimina_caracteres(htmlentities($padron_fetch['numero'])).'" type="text"   id="td_padron_nro" size="10%"/></td>
                    <td style="background-color:#CCCCCC"><input value="'.elimina_caracteres(htmlentities($padron_fetch['piso'])).'" type="text"     id="td_padron_piso" size="10%"/></td>
                    <td style="background-color:#CCCCCC"><input value="'.elimina_caracteres(htmlentities($padron_fetch['depto'])).'" type="text"    id="td_padron_depto" size="10%"/></td>
                    <td style="background-color:#CCCCCC"><input value="'.elimina_caracteres(htmlentities($padron_fetch['casa'])).'" type="text"     id="td_padron_casa" size="10%"/></td>
                    <td style="background-color:#CCCCCC"><input value="'.elimina_caracteres(htmlentities($padron_fetch['monoblok'])).'" type="text" id="td_padron_mon" size="10%"/></td>
                    <td style="background-color:#CCCCCC"><input  type="text" name="referencia" size="40"/></td>
                    <td>&nbsp;</td>
                  </tr>
                  </table>
                  <table border="0" align="center" width="1000">
                  <tr>
                   <td align="center" style=" background-color:'.$td_color.'">Barrio</td>
                   <td align="center" style=" background-color:'.$td_color.'" colspan="2">Entre</td>
                  </tr>
                  <tr>
                   <td><input id="td_padron_barrio" type="text" value="'.elimina_caracteres(htmlentities($padron_fetch['barrio'])).'" size="60"></td>
                   <td><input id="td_padron_entre1" type="text" value="'.elimina_caracteres(htmlentities($padron_fetch['entre1'])).'" size="45">y</td>
                   <td><input id="td_padron_entre2" type="text" value="'.elimina_caracteres(htmlentities($padron_fetch['entre2'])).'" size="45"></td>
                  </tr>
                 </table>
                 <table border="0" align="center" width="600">
                  <tr>
                    <td width="180" style=" background-color:'.$td_color.'" align="center" >Localidad</td>
                    <td width="780" colspan="" style=" background-color:'.$td_color.'" align="center" >Zona</td>
                  </tr>
                  <tr>
                    <td width=""><input id="td_padron_localidad" value="'.$padron_fetch['provincia'].'" type="text" size="50"/></td>
                    <td width="">'.$zona_vector.'</td>
                    <td width=""><div id="img_alerta_zona">'.$img.'</div></td>
                  </tr>
                 </table>
  ';

   $salida = $html_salida;
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("td_datos_domicilio","innerHTML",$salida);
   return $respuesta;
}

function fun_alerta_zona ($id_zona)
 {
  global $path_imagenes_ruta;

  $consulta_zona = mysql_query("SELECT * FROM zonas WHERE idzonas = ".$id_zona);
  $fuera_zona=mysql_fetch_array($consulta_zona);

  if ($fuera_zona['fuerazona'] == 'V')
   {
    $html_salida='<img src="'.$path_imagenes_ruta.'/alerta_fz_blanco.gif" />';
   }else if ($fuera_zona['fuerazona'] == 'F')
     {
      $html_salida='<img src="'.$path_imagenes_ruta.'/alerta_dentro_zn.gif" />';
     }

   $salida = $html_salida;
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("img_alerta_zona","innerHTML",$salida);
   return $respuesta;
 }

function func_lista_motivos ($idmotivo)
{
 $ids = explode ("-",$idmotivo);

 $consulta_motivos = mysql_query ("SELECT * FROM motivos");
 $html_salida = '<select name="s_list_motivos"
                    onchange="xajax_busca_motivos(document.formulario.s_list_motivos.value);
                    xajax_lista_color(document.formulario.s_list_motivos.value);" >
                  <option value="0"> MOTIVOS </option>';
 while ($fila=mysql_fetch_array($consulta_motivos))
 {
  if (($fila['idmotivo'] == $ids['0']) && ($fila['idmotivo2'] == $ids['1']))
    $html_salida.= '<option selected="selected" value="'.$fila['idmotivo'].'-'.$fila['idotivo2'].'" >'.$fila['desc'].'</option>';
  else
    $html_salida.= '<option value="'.$fila['idmotivo'].'-'.$fila['idmotivo2'].'" >'.$fila['desc'].'</option>';
 }
 $html_salida.= '</select>';

 $salida = $html_salida;
 $respuesta = new xajaxResponse();
 $respuesta->addAssign("div_lista_motivos","innerHTML",$salida);
 return $respuesta;
}

function busca_motivos($idmotivo){

 $html_salida = '<input type="text" id="i_busca_motivos" value="'.$idmotivo.'" size="5"
                  onKeyUp="xajax_func_lista_motivos(document.formulario.i_busca_motivos.value);
                           xajax_lista_color(document.formulario.i_busca_motivos.value); "/>';

 $salida = $html_salida;
 $respuesta = new xajaxResponse();
 $respuesta->addAssign("i_busca_motivos","innerHTML",$salida);
 return $respuesta;
}

function lista_color($idcolor)
{
 global $path_imagenes_ruta;
 $ids = explode ("-",$idcolor);

 $consulta_color = mysql_query ("SELECT * FROM colores");
 $html_salida='<select name="s_lista_colores" onchange="xajax_lista_color(document.formulario.s_lista_colores.value)">';
 while ($fila=mysql_fetch_array($consulta_color))
 {
   if ($ids[0] == $fila['idcolor'])
    {
     $foquito='<img src="'.$path_imagenes_ruta.'/'.$fila['idcolor'].'.ico" width="15" height="15"/>';
     $html_salida.= '<option selected ="selected" value="'.$fila['idcolor'].'">'.$fila['desc'].'</option>';
    }
   else
     $html_salida.= '<option value="'.$fila['idcolor'].'">'.$fila['desc'].'</option>';
 }
 $html_salida.='</select>';

 if ($ids[0]  == 4)
   $datos_traslado = '
                 &nbsp;&nbsp;&nbsp;
                 <label style="background-color:'.$td_color.'">Fecha </label> &nbsp;
                 <input id="dia_traslado" type="text" value="DD" size="2">/
                 <input id="mes_traslado" type="text" value="MM" size="2">/
                 <input id="anio_traslado" type="text" value="AAAA" size="4">&nbsp;&nbsp;
                 <label style="background-color:'.$td_color.'">Hora </label> &nbsp;
                 <input id="hora_traslado" type="text" value="HH" size="2">:
                 <input id="minuto_traslado" type="text" value="MM" size="2">
                 <input type="hidden" id="check_traslado" value="1">';
 else $datos_traslado = '
                 <input id="dia_traslado" type="hidden" value="DD" size="2">
                 <input id="mes_traslado" type="hidden" value="MM" size="2">
                 <input id="anio_traslado" type="hidden" value="AAAA" size="4">
                 <input id="hora_traslado" type="hidden" value="HH" size="2">
                 <input id="minuto_traslado" type="hidden" value="MM" size="2">
                 <input type="hidden" id="check_traslado" value="0">';

 $salida = $html_salida;
 $respuesta = new xajaxResponse();
 $respuesta->addAssign("div_lista_colores","innerHTML",$salida);
 $respuesta->addAssign("div_muestra_foquito","innerHTML",$foquito);
 $respuesta->addAssign("div_traslado","innerHTML",$datos_traslado);
 return $respuesta;
}

function agrega_emergencia (
                            $_fecha,$_telefono,
                            $_plan,$_horallam,
                            $_socio,$_nombre,
                            $_tiposocio,$_edad,$_sexo,
                            $_identificacion,$_documento,
                            $_calle,$_numero,
                            $_piso,$_depto,
                            $_casa,$_monoblok,
                            $_barrio,$_entre1,
                            $_entre2,$_localidad,
                            $_referencia,$_zona,
                            $_motivo1,
                            $_color,
                            $_observa1,$_observa2,
                            $_opedesp,
                            $_nosocio1 , $_noedad1 , $_nosexo1, $_noiden1 , $_nodocum1 ,
                            $_nosocio2 , $_noedad2 , $_nosexo2, $_noiden2 , $_nodocum2 ,
                            $_nosocio3 , $_noedad3 , $_nosexo3, $_noiden3 , $_nodocum3 ,
                            $_nosocio4 , $_noedad4 , $_nosexo4, $_noiden4 , $_nodocum4 ,
                            $_bandera_nosocio1  , $_bandera_nosocio2 , $_bandera_nosocio3 , $_bandera_nosocio4
                           )
{

         $_fecha = substr($_fecha, 6, 4).'.'.substr($_fecha, 3, 2).'.'.substr($_fecha, 0, 2);
         $moti_explode = explode ("-",$_motivo1);

         $insert_atencion = '
         insert into atenciones_temp
         (fecha,telefono,plan,
          horallam,socio,
          nombre,tiposocio,
          edad,sexo,
          identificacion,documento,
          calle,numero,
          piso,depto,casa,
          monoblok,barrio,
          entre1,entre2,
          localidad,referencia,
          zona,motivo1,
          motivo2,
          color,observa1,
          observa2,operec)

          values

          (
          "'.$_fecha.'" , "'.$_telefono.'" , "'.$_plan.'" ,
          "'.$_horallam.'","'.$_socio.'",
          "'.strtoupper($_nombre).'","'.$_tiposocio.'",
          "'.$_edad.'","'.strtoupper($_sexo).'",
          "'.$_identificacion.'","'.$_documento.'",
          "'.$_calle.'","'.$_numero.'",
          "'.$_piso.'","'.$_depto.'",
          "'.$_casa.'","'.$_monoblok.'",
          "'.$_barrio.'","'.$_entre1.'",
          "'.$_entre2.'","'.strtoupper($_localidad).'",
          "'.strtoupper($_referencia).'","'.$_zona.'",
          '.$moti_explode[0].',
          '.$moti_explode[1].','.$_color.',
          "'.$_observa1.'","'.$_observa2.'",
          "'.$_opedesp.'"
          )
         ';
  // insert de la emergencia en atenciones temp
  mysql_query($insert_atencion);

  // recupero id para hacer altas de clientes no  apadronados
  $consulta_id = mysql_query ('select id from atenciones_temp
                               where fecha     = "'.$_fecha.'"     and plan = "'.$_plan.'"
                                and  horallam  = "'.$_horallam.'"  and nombre = "'.$_nombre.'"
                                and  tiposocio = "'.$_tiposocio.'" and motivo1  = '.$moti_explode[0].'
                                and motivo2 = '.$moti_explode[1]);


  $fetch_idatencion=mysql_fetch_array($consulta_id);


  if ($_bandera_nosocio1== 1)
   {
     $insert_nosocio1 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni) values
                                                                    ("'.$fetch_idatencion['id'].'" , "'.strtoupper($_nosocio1).'" ,
                                                                     "'.$_noedad1.'" , "'.strtoupper($_nosexo1).'" ,
                                                                     "'.$_noiden1.'" , "'.$_nodocum1.'" )
                                    ');

   }

  if ($_bandera_nosocio2== 1)
   {
     $insert_nosocio2 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni) values
                                                                    ("'.$fetch_idatencion['id'].'" , "'.strtoupper($_nosocio2).'" ,
                                                                     "'.$_noedad2.'" , "'.strtoupper($_nosexo2).'" ,
                                                                     "'.$_noiden2.'" , "'.$_nodocum2.'" )
                                    ');

   }

  if ($_bandera_nosocio3== 1)
   {
     $insert_nosocio3 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni) values
                                                                    ("'.$fetch_idatencion['id'].'" , "'.strtoupper($_nosocio3).'" ,
                                                                     "'.$_noedad3.'" , "'.strtoupper($_nosexo3).'" ,
                                                                     "'.$_noiden3.'" , "'.$_nodocum3.'" )
                                    ');

   }

  if ($_bandera_nosocio4== 1)
   {
     $insert_nosocio4 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni) values
                                                                    ("'.$fetch_idatencion['id'].'" , "'.strtoupper($_nosocio4).'" ,
                                                                     "'.$_noedad4.'" , "'.strtoupper($_nosexo4).'" ,
                                                                     "'.$_noiden4.'" , "'.$_nodocum4.'" )
                                    ');

   }

/*
 $salida = $consulta_id.'<br><br><br><br>'.
  '<table>'.
  '<tr><td>fecha</td> <td>'.$_fecha.'</td></tr>'.
  '<tr><td>telefono</td> <td>'.$_telefono.'</td></tr>'.
  '<tr><td>plan</td> <td>'.$_plan.'</td></tr>'.
  '<tr><td>hora llamada</td> <td>'.$_horallam.'</td></tr>'.
  '<tr><td>codigo socio</td> <td>'.$_socio.'</td></tr>'.
  '<tr><td>nombre socio</td> <td>'.$_nombre.'</td></tr>'.
  '<tr><td>tipo socio</td> <td>'.$_tiposocio.'</td></tr>'.
  '<tr><td>edad</td> <td>'.$_edad.'</td></tr>'.
  '<tr><td>sexo</td> <td>'.$_sexo.'</td></tr>'.
  '<tr><td>os</td> <td>'.$_identificacion.'</td></tr>'.
  '<tr><td>dni</td> <td>'.$_documento.'</td></tr>'.
  '<tr><td>calle</td> <td>'.$_calle.'</td></tr>'.
  '<tr><td>numero</td> <td>'.$_numero.'</td></tr>'.
  '<tr><td>piso</td> <td>'.$_piso.'</td></tr>'.
  '<tr><td>dpto</td> <td>'.$_depto.'</td></tr>'.
  '<tr><td>casa</td> <td>'.$_casa.'</td></tr>'.
  '<tr><td>monoblok</td> <td>'.$_monoblok.'</td></tr>'.
  '<tr><td>barrio</td> <td>'.$_barrio.'</td></tr>'.
  '<tr><td>entre</td> <td>'.$_entre1.'</td></tr>'.
  '<tr><td>entre</td> <td>'.$_entre2.'</td></tr>'.
  '<tr><td>localidad</td> <td>'.$_localidad.'</td></tr>'.
  '<tr><td>referencia</td> <td>'.$_referencia.'</td></tr>'.
  '<tr><td>zona</td> <td>'.$_zona.'</td></tr>'.
  '<tr><td>motivo1</td> <td>'.$moti_explode[0].'</td></tr>'.
  '<tr><td>motivo2</td> <td>'.$moti_explode[1].'</td></tr>'.
  '<tr><td>color</td> <td>'.$_color.'</td></tr>'.
  '<tr><td>obs1</td> <td>'.$_observa1.'</td></tr>'.
  '<tr><td>obs2</td> <td>'.$_observa2.'</td></tr>'.
  '<tr><td>despachador</td> <td>'.$_opedesp.'</td></tr>'.
  '</table>'
 ;
*/

   //$insert_atencion='';
   $insert_atencion='';
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   //escribimos en la capa con id="respuesta" el texto que aparece en $salida
   $respuesta->addAssign("mensaje_agrega","innerHTML",$insert_atencion);

   //tenemos que devolver la instanciación del objeto xajaxResponse
   return $respuesta;
}

function agrega_emergencia_ctraslado (
                            $_fecha,$_telefono,
                            $_plan,$_horallam,
                            $_socio,$_nombre,
                            $_tiposocio,$_edad,$_sexo,
                            $_identificacion,$_documento,
                            $_calle,$_numero,
                            $_piso,$_depto,
                            $_casa,$_monoblok,
                            $_barrio,$_entre1,
                            $_entre2,$_localidad,
                            $_referencia,$_zona,
                            $_motivo1,
                            $_color,
                            $_observa1,$_observa2,
                            $_opedesp ,
                            $_nosocio1 , $_noedad1 , $_nosexo1, $_noiden1 , $_nodocum1 ,
                            $_nosocio2 , $_noedad2 , $_nosexo2, $_noiden2 , $_nodocum2 ,
                            $_nosocio3 , $_noedad3 , $_nosexo3, $_noiden3 , $_nodocum3 ,
                            $_nosocio4 , $_noedad4 , $_nosexo4, $_noiden4 , $_nodocum4 ,
                            $_bandera_nosocio1  , $_bandera_nosocio2 , $_bandera_nosocio3 , $_bandera_nosocio4
                           )
{

  $moti_explode = explode ("-",$_motivo1);

         $insert_atencion = '
         insert into atenciones_temp
         (fecha,telefono,plan,
          horallam,socio,
          nombre,tiposocio,
          edad,sexo,
          identificacion,documento,
          calle,numero,
          piso,depto,casa,
          monoblok,barrio,
          entre1,entre2,
          localidad,referencia,
          zona,motivo1,
          motivo2,
          color,observa1,
          observa2,operec)

          values

          (
          "'.$_fecha.'" , "'.$_telefono.'" , "'.$_plan.'" ,
          "'.$_horallam.'","'.$_socio.'",
          "'.strtoupper($_nombre).'","'.$_tiposocio.'",
          "'.$_edad.'","'.strtoupper($_sexo).'",
          "'.$_identificacion.'","'.$_documento.'",
          "'.$_calle.'","'.$_numero.'",
          "'.$_piso.'","'.$_depto.'",
          "'.$_casa.'","'.$_monoblok.'",
          "'.$_barrio.'","'.$_entre1.'",
          "'.$_entre2.'","'.strtoupper($_localidad).'",
          "'.$_referencia.'","'.$_zona.'",
          '.$moti_explode[0].',
          '.$moti_explode[1].','.$_color.',
          "'.$_observa1.'","'.$_observa2.'",
          "'.$_opedesp.'"
          )
         ';

  // insert de la emergencia en atenciones temp
  mysql_query($insert_atencion);


  // recupero id para hacer altas de clientes no  apadronados
  $consulta_id = mysql_query ('select id from atenciones_temp
                               where fecha     = "'.$_fecha.'"     and plan = "'.$_plan.'"
                                and  horallam  = "'.$_horallam.'"  and nombre = "'.$_nombre.'"
                                and  tiposocio = "'.$_tiposocio.'" and motivo1  = '.$moti_explode[0].'
                                and motivo2 = '.$moti_explode[1]);


  $fetch_idatencion=mysql_fetch_array($consulta_id);


  if ($_bandera_nosocio1== 1)
   {
     $insert_nosocio1 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni) values
                                                                    ("'.$fetch_idatencion['id'].'" , "'.strtoupper($_nosocio1).'" ,
                                                                     "'.$_noedad1.'" , "'.strtoupper($_nosexo1).'" ,
                                                                     "'.$_noiden1.'" , "'.$_nodocum1.'" )
                                    ');

   }

  if ($_bandera_nosocio2== 1)
   {
     $insert_nosocio2 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni) values
                                                                    ("'.$fetch_idatencion['id'].'" , "'.strtoupper($_nosocio2).'" ,
                                                                     "'.$_noedad2.'" , "'.strtoupper($_nosexo2).'" ,
                                                                     "'.$_noiden2.'" , "'.$_nodocum2.'" )
                                    ');

   }

  if ($_bandera_nosocio3== 1)
   {
     $insert_nosocio3 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni) values
                                                                    ("'.$fetch_idatencion['id'].'" , "'.strtoupper($_nosocio3).'" ,
                                                                     "'.$_noedad3.'" , "'.strtoupper($_nosexo3).'" ,
                                                                     "'.$_noiden3.'" , "'.$_nodocum3.'" )
                                    ');

   }

  if ($_bandera_nosocio4== 1)
   {
     $insert_nosocio4 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni) values
                                                                    ("'.$fetch_idatencion['id'].'" , "'.strtoupper($_nosocio4).'" ,
                                                                     "'.$_noedad4.'" , "'.strtoupper($_nosexo4).'" ,
                                                                     "'.$_noiden4.'" , "'.$_nodocum4.'" )
                                    ');

   }

  // mysql_query($insert_atencion);
   $insert_atencion='';
   //$insert_atencion='';
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   //escribimos en la capa con id="respuesta" el texto que aparece en $salida
   $respuesta->addAssign("mensaje_agrega","innerHTML",$insert_atencion);

   //tenemos que devolver la instanciación del objeto xajaxResponse
   return $respuesta;
}
//REGISTERRRRRRR
$xajax->registerFunction("func_lista_planes");
$xajax->registerFunction("func_input_planes");
$xajax->registerFunction("func_datos_padron");
$xajax->registerFunction("func_datos_domicilio");
$xajax->registerFunction("fun_alerta_zona");
$xajax->registerFunction("func_lista_motivos");
$xajax->registerFunction("busca_motivos");
$xajax->registerFunction("lista_color");
$xajax->registerFunction("agrega_emergencia");
$xajax->registerFunction("agrega_emergencia_ctraslado");

//PETICIONNNNNN
$xajax->processRequests();

$html_salida = '
<html>
<head>
<?xml version="1.0" encoding="iso-8859-1"?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script defer type="text/javascript" src="jsfunciones.js"></script>
<script language="JavaScript">

function mueveReloj(){
    momentoActual = new Date()
    hora = momentoActual.getHours()
    minuto = momentoActual.getMinutes()
    segundo = momentoActual.getSeconds()

    horaImprimible = hora + " : " + minuto + " : " + segundo

    document.formulario.reloj.value = horaImprimible

    setTimeout("mueveReloj()",1000)
}

function on_Load()
{
 mueveReloj();
 xajax_func_lista_planes(0);
 xajax_func_input_planes(0);
 xajax_func_datos_padron(0,0,0);
 xajax_func_datos_domicilio (0,0,0);
 xajax_fun_alerta_zona (0);
 xajax_func_lista_motivos (0);
 xajax_busca_motivos(0);
 xajax_lista_color(1);
}
</script>
<title>Modulo para alta de Emergencias</title>
   '.$xajax->printJavascript("xajax/").'
</head>
<body style="background-color:'.$body_color.'" onLoad="on_Load();">
'.titulo_encabezado ('Alta de Emergencia' , $path_imagen_logo).'
<form id="formulario" name="formulario" >
<table width="97%" style="background-color:$body_color" align="center">
  <tr>
    <td width="25%"  colspan="2" align="center" style=" background-color:'.$td_color.'">Datos Receptor</td>
    <td width="15%"  align="center" style=" background-color:'.$td_color.'">Fecha</td>
    <td width="15%"  align="center" style=" background-color:'.$td_color.'">Hora</td>
    <td width="12%"  align="center" style=" background-color:'.$td_color.'">Hora Llamado </td>
  </tr>
  <tr>
    <td width="4%"  style="background-color:#CCCCCC">'.$G_legajo.'</td>
    <td width="21%" style="background-color:#CCCCCC" align="center">'.elimina_caracteres(htmlentities($G_usuario)).'</td>
    <td width="15%" style="background-color:#CCCCCC" align="center"><input style="background-color:#CCCCCC" type="text" id="muestra_fecha" value="'.muestra_fecha().'" /></td>
    <td width="15%" style="background-color:#CCCCCC" align="center"><input style="background-color:#CCCCCC" type="text" name="reloj" size="8"></td>
    <td width="7%" style="background-color:#CCCCCC" align="center"><input style="background-color:#CCCCCC" type="text" id="hora" value="'.muestra_hora().'" /></td>
  </tr>
</table>
<table align="center" width="800">
 <tr>
    <td width="10%" align="center" style=" background-color:'.$td_color.'">Telefono</td>
    <td width="10%" align="center" style=" background-color:'.$td_color.'">Empresa</td>
    <td width="15%"  colspan="2" align="center" style=" background-color:'.$td_color.'">Planes</td>
    <td width="30%"  colspan="2" align="center" style=" background-color:'.$td_color.'">Filtros de busqueda</td>
 </tr>
 <tr>
   <td width=""  colspan="" align="center" style=""><input type="text" id="telefono" /></td>
   <td width=""  colspan="" align="center" style=""><input type="text" id="empresa"  /></td>
   <td width=""  colspan="" align="center" style=""><div id="i_lista_planes"></div></td>
   <td width=""  colspan="" align="center" style=""><div id="s_lista_planes"></div></td>
   <td width=""  colspan="" align="center" style="">
    <input type="text" size="15" id="i_busca_padron"
     onKeyUp="xajax_func_datos_padron(document.formulario.i_busca_plan.value,
                                      document.formulario.i_busca_padron.value,
                                      document.formulario.s_filtro_busqueda.value);
              xajax_func_datos_domicilio(document.formulario.i_busca_plan.value,
                                      document.formulario.i_busca_padron.value,
                                      document.formulario.s_filtro_busqueda.value);
                                      "/>
   </td>
   <td width=""  colspan="" align="center" style="">
    <select name="s_filtro_busqueda"
        onchange="xajax_func_datos_padron(document.formulario.i_busca_plan.value,
                                          document.formulario.i_busca_padron.value,
                                          document.formulario.s_filtro_busqueda.value);
                  xajax_func_datos_domicilio(document.formulario.i_busca_plan.value,
                                      document.formulario.i_busca_padron.value,
                                      document.formulario.s_filtro_busqueda.value);
                                          ">
     <option value="1">Numero de socio</option>
     <option value="2">DNI</option>
     <option value="3">Nombre y apellido</option>
    </select>
  </td>
 </tr>
</table>
<table border="0" align="center" width="1000">
 <tr>
    <td colspan="3" align="center" style="background-color:'.$td_color.'">Socio</td>
    <td width="5%" align="center" style="background-color:'.$td_color.'">Edad</td>
    <td width="5%" align="center" style="background-color:'.$td_color.'">Sexo</td>
    <td width="20%" align="center" style="background-color:'.$td_color.'">Identificacion</td>
    <td width="18%" align="center" style="background-color:'.$td_color.'">Documento</td>
 </tr>
 <tr>
  <td colspan="8"><div id="td_datos_padron"></div>
 </tr>
 <tr>
    <td><input id="nosocio1" type="checkbox" value="" /></td>
    <td colspan="2" align="center" ><input id="no_socio_1" size="75" type="text" /></td>
    <td width="" align="center"   ><input  id="no_edad_1" size="3" type="text" /></td>
    <td width="" align="center"   ><input  id="no_sexo_1" size="3" type="text" /></td>
    <td width="" align="center"   ><input  id="no_iden_1" size="28" type="text" /></td>
    <td width="" align="center"   ><input  id="no_docum_1" size="25" type="text" /></td>
 </tr>
 <tr>
    <td><input id="nosocio2"  type="checkbox" value="" /></td>
    <td colspan="2" align="center" ><input id="no_socio_2" size="75" type="text" /></td>
    <td width="" align="center"   ><input  id="no_edad_2" size="3" type="text" /></td>
    <td width="" align="center"   ><input  id="no_sexo_2" size="3" type="text" /></td>
    <td width="" align="center"   ><input  id="no_iden_2" size="28" type="text" /></td>
    <td width="" align="center"   ><input  id="no_docum_2" size="25" type="text" /></td>
 </tr>
 <tr>
    <td><input id="nosocio3"  type="checkbox" value="" /></td>
    <td colspan="2" align="center" ><input id="no_socio_3" size="75" type="text" /></td>
    <td width="" align="center"   ><input  id="no_edad_3" size="3" type="text" /></td>
    <td width="" align="center"   ><input  id="no_sexo_3" size="3" type="text" /></td>
    <td width="" align="center"   ><input  id="no_iden_3" size="28" type="text" /></td>
    <td width="" align="center"   ><input  id="no_docum_3" size="25" type="text" /></td>
 </tr>
 <tr>
    <td><input id="nosocio4"  type="checkbox" value="" /></td>
    <td colspan="2" align="center" ><input id="no_socio_4" size="75" type="text" /></td>
    <td width="" align="center"   ><input  id="no_edad_4" size="3" type="text" /></td>
    <td width="" align="center"   ><input  id="no_sexo_4" size="3" type="text" /></td>
    <td width="" align="center"   ><input  id="no_iden_4" size="28" type="text" /></td>
    <td width="" align="center"   ><input  id="no_docum_4" size="25" type="text" /></td>
 </tr>
</table>
  <div id="td_datos_domicilio"></div>
<table border="0" width="" align="left">
 <tr>
  <td colspan="" align="center" style="background-color:'.$td_color.'">Motivo del llamado</td>
  <td colspan=""><div id="i_busca_motivos"></div></td>
  <td colspan=""><div id="div_lista_motivos"></div></td>
  <td colspan=""><div id="div_lista_colores"></div></td>
  <td colspan=""><div id="div_muestra_foquito"></div></td>
  <td colspan=""><div id="div_traslado"></div></td>
 </tr>
</table>
<br>
<br>
<table align="left" width="100%" border="0">
  <tr>
    <td valign="top" width="15%">Observaciones :</td>
    <td valign="top" width="95%"><input  type="text" name="obs1" size="60%"/><br>
    <input  type="text" name="obs2" size="60%"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input  type="button" value="Agregar Emergencia"
           onclick="check_emergencia(
           document.formulario.muestra_fecha.value,document.formulario.telefono.value,
           document.formulario.i_busca_plan.value,document.formulario.hora.value,
           document.formulario.td_padron_idpadron.value,document.formulario.td_padron_nombre.value,
           document.formulario.td_padron_tiposocio.value,document.formulario.td_padron_edad.value,
           document.formulario.td_padron_sexo.value,document.formulario.td_padron_identi.value,
           document.formulario.td_padron_docum.value,document.formulario.td_padron_calle.value,
           document.formulario.td_padron_nro.value,document.formulario.td_padron_piso.value,
           document.formulario.td_padron_depto.value,document.formulario.td_padron_casa.value,
           document.formulario.td_padron_mon.value,document.formulario.td_padron_barrio.value,
           document.formulario.td_padron_entre1.value,document.formulario.td_padron_entre2.value,
           document.formulario.td_padron_localidad.value,document.formulario.referencia.value,
           document.formulario.s_lista_zonas.value,document.formulario.i_busca_motivos.value,
           document.formulario.s_lista_colores.value,document.formulario.obs1.value,
           document.formulario.obs2.value,'.$G_legajo.' ,
           document.formulario.check_traslado.value , document.formulario.dia_traslado.value ,
           document.formulario.mes_traslado.value   , document.formulario.anio_traslado.value ,
           document.formulario.hora_traslado.value  , document.formulario.minuto_traslado.value ,
           document.formulario.nosocio1.checked ,   document.formulario.no_socio_1.value ,
           document.formulario.no_edad_1.value , document.formulario.no_sexo_1.value ,
           document.formulario.no_iden_1.value  , document.formulario.no_docum_1.value  ,
           document.formulario.nosocio2.checked ,   document.formulario.no_socio_2.value ,
           document.formulario.no_edad_2.value , document.formulario.no_sexo_2.value ,
           document.formulario.no_iden_2.value  , document.formulario.no_docum_2.value  ,
           document.formulario.nosocio3.checked ,   document.formulario.no_socio_3.value ,
           document.formulario.no_edad_3.value , document.formulario.no_sexo_3.value ,
           document.formulario.no_iden_3.value  , document.formulario.no_docum_3.value  ,
           document.formulario.nosocio4.checked ,   document.formulario.no_socio_4.value ,
           document.formulario.no_edad_4.value , document.formulario.no_sexo_4.value ,
           document.formulario.no_iden_4.value  , document.formulario.no_docum_4.value
           );" /></td>
    <td valign="top" align="right" ><div id="div_muestra_textarea"></td>
  </tr>
</table>
<div id="mensaje_agrega"></div>
</form>
</html>';

echo $html_salida;
