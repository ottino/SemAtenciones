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


$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }




################### Conexion a la base de datos##########################
$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);

######################DEF FUNCIONES XAJAX########################
# parametros de info a editar
$id_ate_edit = $_GET['id_atencion'];
//echo "aaa".$id_ate_edit;
$consulta_atencion_edit = mysql_query("select * from atenciones_temp where id=".$id_ate_edit);
$atencion_datos_edit = mysql_fetch_array($consulta_atencion_edit);
$hora_tras = $atencion_datos_edit ['horallam'];
$fechas_tras = $atencion_datos_edit ['fecha'];

//******************  PREPAR INFO PARA MOSTRAR VINCULADOS ******************************
$consulta_vinculados = mysql_query ("select * from clientes_nopadron where idatencion = ".$id_ate_edit);
$cantidad_vinculados = mysql_affected_rows();

$numero_vinc = 1;
$_FILAVINC.='';

while ($fila=mysql_fetch_array ($consulta_vinculados))
 {
    $_FILAVINC.='
              <tr>
                    <td ><input id="nosocioid'.$numero_vinc.'" value ="'.$fila['idnopadron'].'" type="hidden" size="2%"/></td>
                    <td ><input disabled="disabled" id="no_socio_'.$numero_vinc.'" type="text" value = "'.elimina_caracteres(htmlentities($fila['nombre'])).'" size="75"/></td>  <td>&nbsp;</td>
                    <td><input  disabled="disabled" id="no_edad_'.$numero_vinc.'" type="text" value = "'.elimina_caracteres(htmlentities($fila['edad'])).'" size="3" /></td>
                    <td><input  disabled="disabled" id="no_sexo_'.$numero_vinc.'" type="text" value = "'.elimina_caracteres(htmlentities($fila['sexo'])).'" size="3" /></td><td>&nbsp;</td>
                    <td><input  disabled="disabled" id="no_iden_'.$numero_vinc.'" type="text" value = "'.elimina_caracteres(htmlentities($fila['os'])).'"  size="28" /></td>
                    <td><input  disabled="disabled" id="no_docum_'.$numero_vinc.'" type="text" value = "'.elimina_caracteres(htmlentities($fila['dni'])).'" size="25" /></td>
              </tr>
               ';
    $numero_vinc++;
 }
$cantidad_vinculos = 5 - $numero_vinc;
for ($c=0 ; $c <= $cantidad_vinculos ; $c++)
          {
           $_FILAVINC.='
                      <tr>
                            <td><input disabled="disabled" id="nosocioid'.$numero_vinc.'" value="" type="hidden"  size="2%"/></td>
                            <td><input disabled="disabled" id="no_socio_'.$numero_vinc.'" type="text" size="78"/></td>  <td>&nbsp;</td>
                            <td><input disabled="disabled" id="no_edad_'.$numero_vinc.'"    type="text"  size="3"/></td>
                            <td><input disabled="disabled" id="no_sexo_'.$numero_vinc.'"    type="text"  size="3"/></td> <td>&nbsp;</td>
                            <td><input disabled="disabled" id="no_iden_'.$numero_vinc.'"    type="text" size="28"/></td>
                            <td><input  disabled="disabled" id="no_docum_'.$numero_vinc.'"  type="text" size="25"/></td>
                      </tr>
                       ';
            $numero_vinc++;
          }


//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding('ISO-8859-1');
$xajax->decodeUTF8InputOn() ;
// funciones para la libreria

function func_lista_planes ($id_plan)
{
       $consulta_planes = mysql_query("SELECT * FROM planes WHERE estado not in ('B','D') order by 2");
       $html_salida     ='<select name="list_planes"
                                  onchange="xajax_func_input_planes(document.formulario.list_planes.value);
                                  xajax_fun_alerta_zona(0);
                                  xajax_func_lista_planes(document.formulario.list_planes.value);"
                                  onBlur  ="document.formulario.i_busca_plan.value= document.formulario.list_planes.value" ;
                                  ">';
       $textarea = '<textarea cols="80" rows="7"></textarea>';


       $band=1;
       while ($fila=mysql_fetch_array($consulta_planes))
             {
               if (is_numeric($id_plan) == false)
                  {
                       $encontro = strripos($fila['descplan'], $id_plan);
                       $band=0;
                       if ($encontro === false)
                         {
                          $html_salida.='<option value="'.$fila['idplan'].'" />'.elimina_caracteres(htmlentities($fila['descplan'])).'</option>';
                         }else
                              {
                                $textarea = '<td><textarea cols="80" rows="7">'.elimina_caracteres(htmlentities($fila['datos'])).'</textarea></td>';
                                $html_salida.='<option selected="selected" value="'.$fila['idplan'].'" />'.elimina_caracteres(htmlentities($fila['descplan'])).'</option>';
                              }
                  }else
                       {
                           if ($id_plan == $fila['idplan'])
                           {
                            $band=0;
                            $textarea = '<td><textarea cols="80" rows="7">'.elimina_caracteres(htmlentities($fila['datos'])).'</textarea></td>';
                            $html_salida.='<option selected="selected" value="'.$fila['idplan'].'" />'.elimina_caracteres(htmlentities($fila['descplan'])).'</option>';
                           }
                           else
                            {
                             $html_salida.='<option value="'.$fila['idplan'].'" />'.elimina_caracteres(htmlentities($fila['descplan'])).'</option>';
                            }
                       }
             }
       if ($band==1)
       $html_salida.='<option value="0" selected="selected">Lista de Planes</option>';

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
                    onChange="xajax_fun_alerta_zona(0)"
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
          $consulta_padron=mysql_query ("SELECT * FROM padron WHERE (nombre like '%".$dato."%' OR idpadron = '".$dato."')
                                         AND ( plan = '".ltrim($id_plan ,'0')."' OR plan = '".$id_plan."')");

          if (mysql_num_rows($consulta_padron)>1)
          {
          $vector_nombres='<select name="s_filtro_nam_busq"  style="width:515px"
                            onblur  ="   xajax_func_datos_padron(document.formulario.i_busca_plan.value,
                                                                 document.formulario.s_filtro_nam_busq.value,
                                                                 1);
                                      xajax_func_datos_domicilio(document.formulario.i_busca_plan.value ,
                                                                 document.formulario.s_filtro_nam_busq.value,
                                                                 1);"

                           >';
          while ($padron_fetch = mysql_fetch_array($consulta_padron))
          {

           $vector_nombres.='<option selected="" value="'.$padron_fetch['idpadron'].'">'.elimina_caracteres(htmlentities($padron_fetch['nombre'])).'</option>';
           $edad = edad($padron_fetch['fnacimiento']);
           $disabled='disabled="disabled"';
           $_idpadron_f3 = $padron_fetch['idpadron'] ;
           $_tipo_f3     = $padron_fetch['tiposocio'];
           $_sexo_f3     = $padron_fetch['sexo'];
           $_ident_f3    = elimina_caracteres(htmlentities($padron_fetch['identificacion']));
           $_docu_f3     = $padron_fetch['documento'];
           $_nombre_hidden = $padron_fetch['nombre'];

          }
          $vector_nombres.='</select>';
          }
          else if (mysql_num_rows($consulta_padron)==1)
                {
                    $padron_fetch = mysql_fetch_array($consulta_padron);
                    $edad = edad($padron_fetch['fnacimiento']);
                    $disabled='disabled="disabled"';
                    $vector_nombres='<input id="td_padron_nombre" value="'.elimina_caracteres(htmlentities($padron_fetch['nombre'])).'" style=" background-color:'.$td_color.'" size="80" type="text" '.$disabled.' />';
                    $_idpadron_f3 = $padron_fetch['idpadron'] ;
                    $_tipo_f3     = $padron_fetch['tiposocio'];
                    $_sexo_f3     = $padron_fetch['sexo'];
                    $_ident_f3    = elimina_caracteres(htmlentities($padron_fetch['identificacion']));
                    $_docu_f3     = $padron_fetch['documento'];
                    $_nombre_hidden = $padron_fetch['nombre'];
                }
          else
           {
            $vector_nombres='<input id="td_padron_nombre" value="'.elimina_caracteres(htmlentities($padron_fetch['nombre'])).'" style=" background-color:'.$td_color.'" size="80" type="text" '.$disabled.' />';
            $edad = '&nbsp;';
           }
         } else
               {
                $edad = ' ';
                $vector_nombres='<input id="td_padron_nombre" value="'.elimina_caracteres(htmlentities($padron_fetch['nombre'])).'" style=" background-color:'.$td_color.'" size="80" type="text" '.$disabled.' />';
               }
        break;
 }

 if (($filtro == 1) || ($filtro == 2))
  {
     $html_salida ='
      <tr>
        <td  colspan="" align="center" ><input id="td_padron_idpadron" value="'.$padron_fetch['idpadron'].'" style=" background-color:'.$td_color.'" size="12" type="hidden" '.$disabled.' /></td>
        <td  colspan="" align="center" ><input id="td_padron_tiposocio" value="'.$padron_fetch['tiposocio'].'" style=" background-color:'.$td_color.'" size="4" type="hidden" '.$disabled.' /></td>
        <td  colspan="" align="center" ><input id="td_padron_nombre" value="'.elimina_caracteres(htmlentities($padron_fetch['nombre'])).'" style=" background-color:'.$td_color.'" size="80" type="text" '.$disabled.' /></td>
        <td  width="" align="right"    ><input id="td_padron_edad" value="'.$edad.'" style=" background-color:'.$td_color.'" size="4" type="text"  '.$disabled.' /></td>
        <td  width="" align="right"    ><input id="td_padron_sexo" value="'.$padron_fetch['sexo'].'" style=" background-color:'.$td_color.'" size="3" type="text" '.$disabled.'  /></td>
        <td  width="" align="right"    ><input id="td_padron_identi" value="'.elimina_caracteres(htmlentities($padron_fetch['identificacion'])).'" style=" background-color:'.$td_color.'" size="29" type="text" '.$disabled.' /></td>
        <td  width="" align="right"    ><input id="td_padron_docum" value="'.$padron_fetch['documento'].'" style=" background-color:'.$td_color.'" size="23" type="text" '.$disabled.' /></td>
     </tr>
     ';
  }

  else if ($filtro == 3)
            {
             $html_salida ='
              <tr>
                <td  colspan="" align="center" ><input id="td_padron_idpadron" value="'.$_idpadron_f3.'" style=" background-color:'.$td_color.'" size="12" type="hidden" '.$disabled.' /></td>
                <td  colspan="" align="center" ><input id="td_padron_tiposocio" value="'.$_tipo_f3.'" style=" background-color:'.$td_color.'" size="4" type="hidden" '.$disabled.' /></td>
                <td  colspan="" align="center" ><td  colspan="" align="center" size="80" >'.$vector_nombres.'</td></td>
                <td  width="" align="right"    ><input id="td_padron_edad" value="'.$edad.'" style=" background-color:'.$td_color.'" size="4" type="text"  '.$disabled.' /></td>
                <td  width="" align="right"    ><input id="td_padron_sexo" value="'.$_sexo_f3.'" style=" background-color:'.$td_color.'" size="3" type="text" '.$disabled.'  /></td>
                <td  width="" align="right"    ><input id="td_padron_identi" value="'.$_ident_f3.'" style=" background-color:'.$td_color.'" size="29" type="text" '.$disabled.' /></td>
                <td  width="" align="right"    ><input id="td_padron_docum" value="'.$_docu_f3.'" style=" background-color:'.$td_color.'" size="23" type="text" '.$disabled.' />
                <input id="td_padron_nombre2" value="'.$_nombre_hidden.'" style=" background-color:'.$td_color.'" size="0" type="hidden" '.$disabled.' />
                </td>

             </tr>
             ';
          }else
            {
             $consulta_atencion_edit = mysql_query("select * from atenciones_temp where id=".$dato);
             $atencion_datos_edit = mysql_fetch_array($consulta_atencion_edit);
             $html_salida ='
              <tr>
                <td  colspan="" align="center" ><input id="td_padron_idpadron" value="" style=" background-color:'.$td_color.'" size="12" type="hidden" '.$disabled.' /></td>
                <td  colspan="" align="center" ><input id="td_padron_tiposocio" value="" style=" background-color:'.$td_color.'" size="4" type="hidden" '.$disabled.' /></td>
                <td  colspan="" align="center" ><input id="td_padron_nombre"  value="'.htmlentities($atencion_datos_edit['nombre']).'" style=" background-color:'.$td_color.'" size="80" type="text" '.$disabled.' /></td>
                <td  width="" align="right"    ><input id="td_padron_edad"  value="'.$atencion_datos_edit['edad'].'" style=" background-color:'.$td_color.'" size="4" type="text"  '.$disabled.' /></td>
                <td  width="" align="right"    ><input id="td_padron_sexo"  value="'.htmlentities($atencion_datos_edit['sexo']).'" style=" background-color:'.$td_color.'" size="3" type="text" '.$disabled.'  /></td>
                <td  width="" align="right"    ><input id="td_padron_identi"  value="'.htmlentities($atencion_datos_edit['identificacion']).'" style=" background-color:'.$td_color.'" size="29" type="text" '.$disabled.' /></td>
                <td  width="" align="right"    ><input id="td_padron_docum"  value="'.htmlentities($atencion_datos_edit['documento']).'" style=" background-color:'.$td_color.'" size="23" type="text" '.$disabled.' />
                </td>

             </tr>
             ';
             }
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
          $consulta_padron=mysql_query ("SELECT * FROM padron WHERE (nombre like '%".$dato."%' OR idpadron = '".$dato."')
                                         AND ( plan = '".ltrim($id_plan ,'0')."' OR plan = '".$id_plan."')");
          $padron_fetch = mysql_fetch_array($consulta_padron);
          if (mysql_affected_rows()==0)
           $edad = '&nbsp;';
          else
           $edad = edad($padron_fetch['fnacimiento']);
         } else  $edad = ' ';
        break;
    case 4:
        if (($dato <> ' ') && ($dato <> '') && ($dato <> null))
         {
           $consulta_atencion_edit = mysql_query("select * from atenciones_temp where id=".$dato);
           $padron_fetch = mysql_fetch_array($consulta_atencion_edit);
           $edad = edad($padron_fetch['fnacimiento']);
         }
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
                   <td align="center" style=" background-color:'.$td_color.'" colspan="4">Entre</td>
                  </tr>
                  <tr>
                   <td><input id="td_padron_barrio" type="text" value="'.elimina_caracteres(htmlentities($padron_fetch['barrio'])).'" size="60"></td>
                   <td><input id="td_padron_entre1" type="text" value="'.elimina_caracteres(htmlentities($padron_fetch['entre1'])).'" size="40"></td><td>y </td><td></td>
                   <td><input id="td_padron_entre2" type="text" value="'.elimina_caracteres(htmlentities($padron_fetch['entre2'])).'" size="40"></td>
                  </tr>
                 </table>
                 <table border="0" align="center" width="600">
                  <tr>
                    <td width="180" style=" background-color:'.$td_color.'" align="center" >Localidad</td>
                    <td width="780" colspan="" style=" background-color:'.$td_color.'" align="center" >Zona</td>
                  </tr>
                  <tr>
                    <td width=""><input id="td_padron_localidad" value="'.elimina_caracteres(htmlentities($padron_fetch['localidad'])).'" type="text" size="50"/></td>
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

  $consulta_zona = mysql_query("SELECT * FROM zonas WHERE idzonas = '".$id_zona."'");
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
 //$ids = explode ("-",$idmotivo);
 $ids ['0'] = substr($idmotivo, 0, 1);
 $ids ['1'] = substr($idmotivo, 1, 2);
 $consulta_motivos = mysql_query ("SELECT * FROM motivos ORDER BY 3");
 $html_salida = '<select name="s_list_motivos"
                    onchange="xajax_busca_motivos(document.formulario.s_list_motivos.value);
                    xajax_lista_color(document.formulario.s_list_motivos.value);" >
                  <option value="0"> MOTIVOS </option>';
 while ($fila=mysql_fetch_array($consulta_motivos))
 {
  if (($fila['idmotivo'] == $ids['0']) && ($fila['idmotivo2'] == $ids['1']))
    $html_salida.= '<option selected="selected" value="'.$fila['idmotivo'].''.$fila['idotivo2'].'" >'.$fila['desc'].'</option>';
  else
    $html_salida.= '<option value="'.$fila['idmotivo'].''.$fila['idmotivo2'].'" >'.$fila['desc'].'</option>';
 }
 $html_salida.= '</select>';
 #--
 $html_pre_arribo = '
  <td colspan="">
  <input type="button" value="PRE-ARRIBO"
  onClick="window.open(\'pre_arribo.php?id_motivo=\'+\''.$idmotivo.'\',
                                                \'INSTRUCCIONES\', \'width=480,height=600,scrollbars=yes\');"
  />
  </td> ';


 $salida = $html_salida;
 $respuesta = new xajaxResponse();
 $respuesta->addAssign("div_lista_motivos","innerHTML",$salida);
 $respuesta->addAssign("div_pre_arribo","innerHTML",$html_pre_arribo);
 return $respuesta;
}

function busca_motivos($idmotivo){

 $html_salida = '<input type="text" id="i_busca_motivos" value="'.$idmotivo.'" size="5"
                  onKeyUp="xajax_func_lista_motivos(document.formulario.i_busca_motivos.value);
                           xajax_lista_color(document.formulario.i_busca_motivos.value); "/>';

 $salida = $html_salida;

  #--
 $html_pre_arribo = '
  <td colspan="">
  <input type="button" value="PRE-ARRIBO"
  onClick="window.open(\'pre_arribo.php?id_motivo=\'+\''.$idmotivo.'\',
                                                \'INSTRUCCIONES\', \'width=480,height=600,scrollbars=yes\');"
  />
  </td> ';

 $respuesta = new xajaxResponse();
 $respuesta->addAssign("i_busca_motivos","innerHTML",$salida);
 $respuesta->addAssign("div_pre_arribo","innerHTML",$html_pre_arribo);
 return $respuesta;
}

function lista_color($idcolor)
{
 global $path_imagenes_ruta;
 global $hora_tras;
 global $fechas_tras;

   // CALCULO DE FECHA Y DIA EN QUE SE MUESTRA EL TRASLADO EN PANTALLA

  $fecha_aux = explode ("-" ,$fechas_tras );
  $hora_aux  = explode (":" ,$hora_tras);

  $_dia_tr_   =$fecha_aux[2];
  $_mes_tr_   =$fecha_aux[1];
  $_anio_tr_  =$fecha_aux[0];
  $_hora_tr_  =$hora_aux[0];
  $_min_tr_   =$hora_aux[1];
  ##

 //$ids = explode ("-",$idcolor);
 $ids ['0'] = substr($idcolor, 0, 1);
 //$ids ['1'] = substr($idmotivo, 1, 2);

 $consulta_color = mysql_query ("SELECT * FROM colores order by 1");
 $html_salida='<select name="s_lista_colores" onchange="xajax_lista_color(document.formulario.s_lista_colores.value)">';
 $html_salida.= '<option selected ="selected" value="0">COLORES</option>';


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

 if (($ids[0]  == 4) || ($ids[0]  == 7) )
   $datos_traslado = '
                 &nbsp;&nbsp;&nbsp;
                 <label style="background-color:'.$td_color.'">Fecha </label> &nbsp;
                 <input id="dia_traslado" type="text" value="'.$_dia_tr_.'" size="2">/
                 <input id="mes_traslado" type="text"  value="'.$_mes_tr_ .'" size="2">/
                 <input id="anio_traslado" type="text" value="'.$_anio_tr_.'" size="4">&nbsp;&nbsp;
                 <label style="background-color:'.$td_color.'">Hora </label> &nbsp;
                 <input id="hora_traslado" type="text"  value="'.$_hora_tr_.'" size="2">:
                 <input id="minuto_traslado" type="text"  value="'.$_min_tr_.'" size="2">
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

function agrega_emergencia_edit (
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
                            $_opedesp,$_id_ate_edit
                           )
{

         $_fecha = substr($_fecha, 6, 4).'.'.substr($_fecha, 3, 2).'.'.substr($_fecha, 0, 2);
         //$moti_explode = explode ("-",$_motivo1);

        $moti_explode ['0'] = substr($_motivo1, 0, 1);
        $moti_explode ['1'] = substr($_motivo1, 1, 2);
         $_plan = $_plan + 0;
         $update_emergencia = '
                  UPDATE atenciones_temp
                     SET
                         telefono       = "'.$_telefono.'",
                         plan           = "'.$_plan.'",
                         horallam       ="'.$_horallam.'",
                         socio = "'.$_socio.'",
                         nombre = "'.$_nombre.'",
                         tiposocio = "'.$_tiposocio.'",
                         edad = "'.($_edad).'",
                         sexo = "'.($_sexo).'",
                         identificacion = "'.($_identificacion).'",
                         documento = "'.$_documento.'",
                         calle = "'.($_calle).'",
                         numero = "'.$_numero.'",
                         piso = "'.$_piso.'",
                         depto = "'.$_depto.'",
                         casa = "'.($_casa).'",
                         monoblok = "'.($_monoblok).'",
                         barrio = "'.($_barrio).'",
                         entre1 = "'.($_entre1).'",
                         entre2 ="'.($_entre2).'",
                         localidad = "'.($_localidad).'",
                         referencia = "'.($_referencia).'",
                         zona = "'.($_zona).'",
                         motivo1 ='.$moti_explode[0].',
                         motivo2 = '.$moti_explode[1].',
                         color = '.$_color.',
                         observa1 ="'.($_observa1).'",
                         observa2 ="'.($_observa2).'",
                         operec ="'.($_opedesp).'"
                   WHERE id = '.$_id_ate_edit.'
         ';

   // insert de la emergencia en atenciones temp
   mysql_query($update_emergencia);

   $update_emergencia='';
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   //escribimos en la capa con id="respuesta" el texto que aparece en $salida
   $respuesta->addAssign("mensaje_agrega","innerHTML",$update_emergencia);

   //tenemos que devolver la instanciación del objeto xajaxResponse
   return $respuesta;
}

function agrega_emergencia_ctraslado_edit (
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
                            $_opedesp ,$_id_ate_edit
                           )
{

  //$moti_explode = explode ("-",$_motivo1);
  $moti_explode ['0'] = substr($_motivo1, 0, 1);
  $moti_explode ['1'] = substr($_motivo1, 1, 2);

  // CALCULO DE FECHA Y DIA EN QUE SE MUESTRA EL TRASLADO EN PANTALLA
  $fecha_aux = explode ("." ,$_fecha );
  $hora_aux  = explode (":" ,$_horallam);

  $_dia_tr   =$fecha_aux[2];
  $_mes_tr   =$fecha_aux[1];
  $_anio_tr  =$fecha_aux[0];
  $_hora_tr  =$hora_aux[0];
  $_min_tr   =$hora_aux[1];
  $_param_tr =12; // parametro para mostrar en pantalla

  $traslado_aux = restaTimestamp ($_dia_tr , $_mes_tr, $_anio_tr , $_hora_tr , $_min_tr , $_param_tr);
  //***********************************************************
   $_plan = $_plan + 0;
     $update_emergencia = '
              UPDATE atenciones_temp
                 SET
                     fecha          = "'.$_fecha.'" ,
                     telefono       = "'.$_telefono.'",
                     plan           = "'.$_plan.'",
                     horallam       ="'.$_horallam.'",
                     socio = "'.($_socio).'",
                     nombre = "'.($_nombre).'",
                     tiposocio = "'.($_tiposocio).'",
                     edad = "'.($_edad).'",
                     sexo = "'.($_sexo).'",
                     identificacion = "'.($_identificacion).'",
                     documento = "'.($_documento).'",
                     calle = "'.($_calle).'",
                     numero = "'.($_numero).'",
                     piso = "'.($_piso9).'",
                     depto = "'.($_depto).'",
                     casa = "'.($_casa).'",
                     monoblok = "'.($_monoblok).'",
                     barrio = "'.($_barrio).'",
                     entre1 = "'.($_entre1).'",
                     entre2 ="'.($_entre2).'",
                     localidad = "'.($_localidad).'",
                     referencia = "'.($_referencia).'",
                     zona = "'.($_zona).'",
                     motivo1 ='.$moti_explode[0].',
                     motivo2 = '.$moti_explode[1].',
                     color = '.$_color.',
                     observa1 ="'.($_observa1).'",
                     observa2 ="'.($_observa2).'",
                     operec ="'.($_opedesp).'" ,
                     traslado_aux = "'.$traslado_aux.'"
               WHERE id = '.$_id_ate_edit.'
     ';

   // insert de la emergencia en atenciones temp
   mysql_query($update_emergencia);

   // mysql_query($insert_atencion);
   $update_emergencia='';
   //$insert_atencion='';
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   //escribimos en la capa con id="respuesta" el texto que aparece en $salida
   $respuesta->addAssign("mensaje_agrega","innerHTML",$update_emergencia);

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
$xajax->registerFunction("agrega_emergencia_edit");
$xajax->registerFunction("agrega_emergencia_ctraslado_edit");

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
 xajax_func_lista_planes('.$atencion_datos_edit['plan'].');
 xajax_func_input_planes('.$atencion_datos_edit['plan'].');
 xajax_func_datos_padron(0,'.$id_ate_edit.',4);
 xajax_func_datos_domicilio (0,'.$id_ate_edit.',4);
 xajax_fun_alerta_zona ('.$atencion_datos_edit['zona'].');
 xajax_func_lista_motivos ('.$atencion_datos_edit['motivo1'].$atencion_datos_edit['motivo2'].');
 xajax_busca_motivos('.$atencion_datos_edit['motivo1'].$atencion_datos_edit['motivo2'].');
 xajax_lista_color('.$atencion_datos_edit['color'].');
}
</script>
<link href="estilos.css" rel="stylesheet" type="text/css" />
<title>Modulo para alta de Emergencias</title>
   '.$xajax->printJavascript("xajax/").'
</head>
<body style="background-color:'.$body_color.'" onLoad="on_Load();">
'.titulo_encabezado_2 ('Editar Emergencia' , $path_imagen_logo).'
<form id="formulario" name="formulario" >
<table width="97%" style="background-color:$body_color" align="center">
  <tr>
    <td width="25%"  colspan="2" align="center" style=" background-color:'.$td_color.'">Datos Receptor</td>
    <td width="15%"  align="center" style=" background-color:'.$td_color.'">Fecha</td>
    <td width="15%"  align="center" style=" background-color:'.$td_color.'">Hora</td>
    <td width="12%"  align="center" style=" background-color:'.$td_color.'">Hora Llamado </td>
  </tr>
  <tr>
    <td width="4%"  align="center" style="background-color:'.$td_color.'">'.$id_ate_edit.'</td>
    <td width="21%" style="background-color:'.$td_color.'" align="center">'.elimina_caracteres(htmlentities($G_usuario)).'</td>
    <td width="15%" style="background-color:'.$td_color.'" align="center"><input style="background-color:'.$td_color.'" type="text" id="muestra_fecha" value="'.$atencion_datos_edit['fecha'].'" /></td>
    <td width="15%" style="background-color:'.$td_color.'" align="center"><input style="background-color:'.$td_color.'" type="text" name="reloj" size="8"></td>
    <td width="7%"  style="background-color:'.$td_color.'" align="center"><input style="background-color:'.$td_color.'" type="text" id="hora" value="'.$atencion_datos_edit['horallam'].'" /></td>
  </tr>
</table>
<table align="center" width="800">
 <tr>
    <td width="10%" align="center" style=" background-color:'.$td_color.'">Telefono</td>

    <td width="15%"  colspan="2" align="center" style=" background-color:'.$td_color.'">Planes</td>
    <td width="30%"  colspan="2" align="center" style=" background-color:'.$td_color.'">Filtros de busqueda</td>
 </tr>
 <tr>
   <td width=""  colspan="" align="center" style=""><input type="text" id="telefono" value="'.$atencion_datos_edit['telefono'].'"/></td>

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

<table border="0" width="850" align="center" style="font-size:'.$fontdef.'">
 <tr>
  <td colspan="" align="center" style="background-color:'.$td_color.'">Motivo del llamado</td>
  <td colspan=""><div id="i_busca_motivos"></div></td>
  <td colspan=""><div id="div_lista_motivos"></div></td>
  <td colspan=""><div id="div_pre_arribo"></div></td>
  <td colspan=""><div id="div_lista_colores"></div></td>
  <td colspan=""><div id="div_muestra_foquito"></div></td>
  <td colspan=""><div id="div_traslado"></div></td>
 </tr>
</table>


DOMICILIO

<table border="0" bordercolor="#FFFFFF" align="center" width="996" valign="top" style="font-size:'.$fontdef.'">
  <tr><div id="td_datos_domicilio"></div></tr>
</table>

PACIENTE

<table border="0" bordercolor="#FFFFFF" align="center" width="996" valign="top" style="font-size:'.$fontdef.'">
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
 </table>

 ADICIONALES

 <table  border="1" bordercolor="#FFFFFF" align="center" width="996" height="100">
 <tr>
 <td ALIGN="CENTER" colspan="8" valign="top">
  <div class="barra_3">
 <table BORDER="0" align="center" valign="top">
 '.$_FILAVINC.'
 </table>
 </div>
 </td>
 </tr>
</table>

<br>
<table align="left" width="100%" border="0">
  <tr>
    <td valign="top" width="15%">Observaciones :</td>
    <td valign="top" width="85%">
    <textarea rows="3" cols="50" name="obs1">'.elimina_caracteres(htmlentities($atencion_datos_edit['observa1'])).'</textarea>
    <input type="hidden" name="obs2" size="60%"/><br>

    <input  type="button" value="Editar Emergencia"
    onclick=" check_emergencia_edit(
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
           document.formulario.hora_traslado.value  , document.formulario.minuto_traslado.value ,'.$id_ate_edit.'
               );"
     />

     </td>
    <td valign="top" align="right" ><div id="div_muestra_textarea"></td>
  </tr>
</table>
<div id="mensaje_agrega"></div>
</form>
</html>';

echo $html_salida;
