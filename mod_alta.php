<?php

include_once ('config.php');
include ('funciones.php');
require ('xajax/xajax.inc.php');
require_once ('cookie.php');

// Datos del usuario
$cookie = new cookieClass;
$G_usuario = $cookie->get("usuario");
$G_legajo  = $cookie->get("legajo");
$G_perfil  = $cookie->get("perfil");
$G_funcion = $cookie->get("funcion");
 
// Conexion con la base
conectar_db ($bd_host , $bd_database , $bd_user , $bd_pass);

$filas_nosocio = null;
$parametros_js = null;
$html_salida = null;
$disabled = null;
$html_salida = null; 


# No apoderados
for ($c=1 ; $c<2 ; $c++)
{
 $filas_nosocio.= 
 '
  <tr>
     <td><input id="nosocio'.$c.'" type="checkbox" value="" /></td>
     <td colspan="2" align="center" ><input id="no_socio_'.$c.'" size="75" type="text" /></td>
     <td align="center"   ><input  id="no_edad_'.$c.'" size="3" type="text" /></td>
     <td align="center"   ><input  id="no_sexo_'.$c.'" size="3" type="text" /></td>
     <td align="center"   ><input  id="no_iden_'.$c.'" size="28" type="text" /></td>
     <td align="center"   ><input  id="no_docum_'.$c.'" size="25" type="text" /></td>
  </tr>
 ';
  
 $parametros_js.= 
 'document.formulario.nosocio'.$c.'.checked ,   document.formulario.no_socio_'.$c.'.value ,
  document.formulario.no_edad_'.$c.'.value , document.formulario.no_sexo_'.$c.'.value ,
  document.formulario.no_iden_'.$c.'.value , document.formulario.no_docum_'.$c.'.value , 
 ';  
}

 $filas_nosocio.= 
 '
  <tr>
     <td><input id="nosocio5" type="checkbox" value="" /></td>
     <td colspan="2" align="center" ><input id="no_socio_5" size="75" type="text" /></td>
     <td align="center"   ><input  id="no_edad_5" size="3" type="text" /></td>
     <td align="center"   ><input  id="no_sexo_5" size="3" type="text" /></td>
     <td align="center"   ><input  id="no_iden_5" size="28" type="text" /></td>
     <td align="center"   ><input  id="no_docum_5" size="25" type="text" /></td>
  </tr>
 ';
 
 $parametros_js.= 
 'document.formulario.nosocio5.checked ,   document.formulario.no_socio_5.value ,
  document.formulario.no_edad_5.value , document.formulario.no_sexo_5.value ,
  document.formulario.no_iden_5.value , document.formulario.no_docum_5.value  
 ';  


//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding("iso-8859-1");

function func_lista_planes ($id_plan) {
       
       $band = null;
       $html_salida = null;
       
       $consulta_planes = mysql_query("SELECT * FROM convenios;");

       // Cuando se carga la pagina se carga el combo de planes
       $html_salida     ='<select name="list_planes" style="width:600px"
                                  onChange="xajax_func_lista_planes(document.formulario.list_planes.value);"                               
                          >';

       $html_salida.='<option value="0" selected="selected">Lista de Planes</option>';

       $textarea = '<td aign="center"><textarea cols="70" rows="7" class="estilotextarea" ></textarea></td>';

       
       while ($fila=mysql_fetch_array($consulta_planes))
        {
          if (is_numeric($id_plan) == false)
          {
                  $encontro = strripos($fila['descripcion'], $id_plan);
                  $band=0;

                  if ($encontro === false)
                  {
                       $html_salida.='<option value="'.$fila['id'].'" />'.$fila['descripcion'].'</option>';
                       $textarea  = '<td aign="center">
                       <textarea cols="70" rows="7" class="estilotextarea" >  '.$fila['id'].'-'.$fila['descripcion']."\n"
                       .'  Enfermeria Domicilio : '.$fila['enfermeria_dom'].'      Base Consulta         :'.$fila['base_consulta']."\n"
                       .'  Enfermeria Base      : '.$fila['enfermeria_base'].'      Domicilio E/U         :'.$fila['domicilio_eu']."\n"
                       .'  Traslados            : '.$fila['traslados'].'   Domicilio Consulta    :'.$fila['domicilio_consulta']."\n"
                       .'  Base E/U             : '.$fila['base_eu'].'     Medicacion con Cargo  :'.$fila['medicacion_c_cargo']."\n"
                       .'  Medicacion sin Cargo : '.$fila['medicacion_s_cargo'].'      Descartables con Cargo:'.$fila['descartables_c_cargo']."\n"
                       .'  Descartab. sin Cargo : '.$fila['descartables_s_cargo'].'      Area Protegida        :'.$fila['area_protegida']."\n"
                       .'</textarea>
                       </td>';
                    }
                  else
                  {                                  
                             $html_salida.='<option selected="selected" value="'.$fila['id'].'" />'.$fila['descripcion'].'</option>';
                         }

             }
          else
          { 	
                      if ($id_plan == $fila['id'])
                      {
                        $band=0;

                        $textarea  = '<td aign="center">
                                      <textarea cols="70" rows="7" class="estilotextarea" >  '.$fila['id'].'-'.$fila['descripcion']."\n"
                                      .'  Enfermeria Domicilio : '.$fila['enfermeria_dom'].'      Base Consulta         :'.$fila['base_consulta']."\n"
                                      .'  Enfermeria Base      : '.$fila['enfermeria_base'].'      Domicilio E/U         :'.$fila['domicilio_eu']."\n"
                                      .'  Traslados            : '.$fila['traslados'].'   Domicilio Consulta    :'.$fila['domicilio_consulta']."\n"
                                      .'  Base E/U             : '.$fila['base_eu'].'     Medicacion con Cargo  :'.$fila['medicacion_c_cargo']."\n"
                                      .'  Medicacion sin Cargo : '.$fila['medicacion_s_cargo'].'      Descartables con Cargo:'.$fila['descartables_c_cargo']."\n"
                                      .'  Descartab. sin Cargo : '.$fila['descartables_s_cargo'].'      Area Protegida        :'.$fila['area_protegida']."\n"
                                      .'</textarea>
                                     </td>';

                        $html_salida.='<option selected="selected" value="'.$fila['id'].'" />'.$fila['descripcion'].'</option>';

                      }
                      else
                      {
                        $html_salida.='<option value="'.$fila['id'].'" />'.$fila['descripcion'].'</option>';
                      }
                  }
        }
             
   if ($band <> 0) 
   {    
     $html_salida.='<option value="0" selected="selected">Lista de Planes</option>';
   }       
   else 
   {    
     $html_salida.='<option value="0">Lista de Planes</option>';
   }
   
   $html_salida.='</select>';


   $salida = $html_salida;
   $respuesta = new xajaxResponse();
   
   $respuesta->addAssign("s_lista_planes","innerHTML",$salida);
   $respuesta->addAssign("div_muestra_textarea","innerHTML",$textarea);
   $respuesta->addAssign("i_busca_plan","value", $id_plan );
   
   return $respuesta;
}

function func_input_planes ($id_plan) {
  
   $html_salida = '<input id="i_busca_plan" size="7" type="text" value="'.$id_plan.'"
                    onChange="xajax_func_lista_planes(document.formulario.i_busca_plan.value);">';
   
   $salida = $html_salida;
   
   $respuesta = new xajaxResponse();
   
   $respuesta->addAssign("i_lista_planes","innerHTML",$salida);
   
   return $respuesta;
}

function func_datos_padron ($id_plan , $dato , $filtro) {
    
 global $td_color;
 
 $disabled          = null;
 $padron_fetch      = null;
 $envia_convenio    = 0;
 $_idpadron_f3      = null;
 $_tipo_f3          = null;
 $vector_nombres    = null;
 $edad              = null;
 $_idpadron_f3      = null ;
 $_tipo_f3          = null;
 $_sexo_f3          = null;
 $_docu_f3          = null;
 $_nombre_hidden    = null;
 $envia_convenio    = null;
 
 
 switch ($filtro) {
     
    case 1: // Busqueda x nro afiliado
        if (($dato <> ' ') && ($dato <> '') && ($dato <> null))
         {
            
          $consulta_padron=mysql_query ("
                                         select *
                                         from clientes left join convenios
                                         on (clientes.convenio_id = convenios.id)
                                         where clientes.nroafiliado = '".$dato."'                                              
                                        ");

          $padron_fetch = mysql_fetch_array($consulta_padron);

          if (mysql_affected_rows()<>0)
          {
           $edad = edad($padron_fetch['fnacimiento']);
           $disabled='disabled="disabled"';
           $envia_convenio = $padron_fetch['convenio_id'];
          }
          
         } 
        break;
    case 2: // Busqueda x nro de documento
        if (($dato <> ' ') && ($dato <> '') && ($dato <> null))
         {
            
          $consulta_padron=mysql_query ("
                                         select *
                                         from clientes left join convenios
                                         on (clientes.convenio_id = convenios.id)
                                         where clientes.documento = '".$dato."'
                                        ");
          
          $padron_fetch = mysql_fetch_array($consulta_padron);
          
          if (mysql_affected_rows()<>0)
           {
            $edad = edad($padron_fetch['fnacimiento']);
            $disabled='disabled="disabled"';
            $envia_convenio = $padron_fetch['convenio_id'];
           }
           
         } 
        break;
    case 3: // Busqueda libre
        if (($dato <> ' ') && ($dato <> '') && ($dato <> null))
         {
            
          $consulta_padron=mysql_query ("
                                         select *
                                         from clientes left join convenios
                                         on (clientes.convenio_id = convenios.id)
                                         where (clientes.nombre      like '%".$dato."%')    or
                                               (clientes.documento   like '%".$dato."%') or
                                               (clientes.nroafiliado like '%".$dato."%')
                                        ");

          if (mysql_num_rows($consulta_padron)>1)
          {
              
            $vector_nombres='<select name="s_filtro_nam_busq"  style="width:515px"
                            onChange  ="   xajax_func_datos_padron(document.formulario.i_busca_plan.value,
                                                                 document.formulario.s_filtro_nam_busq.value,
                                                                 2);
                                           xajax_func_datos_domicilio(document.formulario.i_busca_plan.value ,
                                                                 document.formulario.s_filtro_nam_busq.value,
                                                                 2);"

                           >
                          <option selected="selected" value="0">Seleccionar de la lista</option>
                          ';
           
            while ($padron_fetch = mysql_fetch_array($consulta_padron))
            {

                $vector_nombres.='<option value="'.$padron_fetch['documento'].'">'.$padron_fetch['nombre'].'</option>';
                $edad = edad($padron_fetch['fnacimiento']);                     

                $disabled='disabled="disabled"';
                $_idpadron_f3 = $padron_fetch['nroafiliado'] ;
                $_tipo_f3     = '0';
                $_sexo_f3     = $padron_fetch['sexo'];
                $_docu_f3     = $padron_fetch['documento'];
                $_nombre_hidden = $padron_fetch['nombre'];
                $envia_convenio = $padron_fetch['convenio_id'];

             }

            $vector_nombres.='</select>';
          
          }
          else if (mysql_num_rows($consulta_padron)==1)
          {
                    $padron_fetch   = mysql_fetch_array($consulta_padron);
                    $edad           = edad($padron_fetch['fnacimiento']);
                    $disabled       ='disabled="disabled"';
                    $vector_nombres ='<input id="td_padron_nombre" value="'.$padron_fetch['nombre'].'" size="80" type="text" '.$disabled.' />';
                    $_idpadron_f3   = $padron_fetch['nroafiliado'] ;
                    $_tipo_f3       = '0';
                    $_sexo_f3       = $padron_fetch['sexo'];
                    $_docu_f3       = $padron_fetch['documento'];
                    $_nombre_hidden = $padron_fetch['nombre'];
                    $envia_convenio = $padron_fetch['convenio_id'];
                }
          else
          {
                    $vector_nombres='<input id="td_padron_nombre" value="'.$padron_fetch['nombre'].'" size="80" type="text" '.$disabled.' />';
                }
                
         } else
                {
                $edad = ' ';
                $vector_nombres='<input id="td_padron_nombre" value="'.$padron_fetch['nombre'].'" size="80" type="text" '.$disabled.' />';
               }
        break;
         
 }

 if (($filtro == 1) || ($filtro == 2))
 {
     $html_salida ='
	<table align="center" class="datos_socio" valign="top" class="datos_socio">
	<tr>
            <td align="center">Socio</td>
            <td align="center">Edad</td>
            <td align="center">Sexo</td>
            <td align="center">Documento</td>
	</tr>
      <tr>
        <input id="td_padron_idpadron" value="'.$padron_fetch['nroafiliado'].'" type="hidden" '.$disabled.' /></td>
        <input id="td_padron_tiposocio" value="'.$padron_fetch['tipo_socio_id'].'" type="hidden" '.$disabled.' /></td>
        <td align="center"><input id="td_padron_nombre" value="'.$padron_fetch['nombre'].'" size="80" type="text" '.$disabled.' /></td>
        <td align="center"><input id="td_padron_edad" value="'.$edad.'" size="4" type="text"  '.$disabled.' /></td>
        <td align="center"><input id="td_padron_sexo" value="'.$padron_fetch['sexo'].'" size="3" type="text" '.$disabled.'  /></td>
        <td align="center"><input id="td_padron_docum" value="'.$padron_fetch['documento'].'" size="23" type="text" '.$disabled.' /></td>
     </tr>
	</table> 
     ';
  }
 else if ($filtro == 3)
 {
             $html_salida ='
			 <table align="center" valign="top" class="datos_socio">
                             <tr>
                                <td align="center">Socio</td>
                                <td align="center">Edad</td>
                                <td align="center">Sexo</td>
                                <td align="center">Documento</td>
                             </tr>
                             <tr>
                               <input id="td_padron_idpadron" value="'.$_idpadron_f3.'" size="12" type="hidden" '.$disabled.' />
                               <input id="td_padron_tiposocio" value="'.$_tipo_f3.'" size="4" type="hidden" '.$disabled.' />
                               <td  colspan="" align="center" >'.$vector_nombres.'</td></td>
                               <td  align="center"    ><input id="td_padron_edad" value="'.$edad.'" size="4" type="text"  '.$disabled.' /></td>
                               <td  align="center"    ><input id="td_padron_sexo" value="'.$_sexo_f3.'" size="3" type="text" '.$disabled.'  /></td>
                               <td  align="center"    ><input id="td_padron_docum" value="'.$_docu_f3.'" size="23" type="text" '.$disabled.' />
                                <input id="td_padron_nombre2" value="'.$_nombre_hidden.'" size="0" type="hidden" '.$disabled.' />
                              </td>
                            </tr>
                        </table>
             ';
          }
 else
 {   
            $html_salida ='
			<table align="center" valign="top" class="datos_socio">
			 <tr>
			    <td align="center">Socio</td>
			    <td align="center">Edad</td>
			    <td align="center">Sexo</td>
			    <td align="center">Documento</td>
			 </tr>
                         <tr>
                            <input id="td_padron_idpadron" value=""  type="hidden" '.$disabled.' />
                            <input id="td_padron_tiposocio" value="" type="hidden" '.$disabled.' />
                            <td  align="center"><input id="td_padron_nombre" value="" size="80" type="text" '.$disabled.' /></td>
                            <td  align="center"><input id="td_padron_edad" value="" size="4" type="text"  '.$disabled.' /></td>
                            <td  align="center"><input id="td_padron_sexo" value="" size="3" type="text" '.$disabled.'  /></td>
                            <td  align="center"><input id="td_padron_docum" value="" size="23" type="text" '.$disabled.' /></td>
                         </tr>
                       </table>
             ';
          }  
   
   $salida = $html_salida;
   
   $respuesta = new xajaxResponse();
   
   if ( ($envia_convenio == '') || ($envia_convenio == ' ') || ($envia_convenio == null) )
   {
      $id_convenio = 0;
   } else 
   {
      $id_convenio = $envia_convenio;
   }
   
   $respuesta->addAssign("td_datos_padron","innerHTML",$salida); // Datos del cliente
   //$respuesta->addAssign("i_busca_plan","value", $id_convenio ); // Codigo del plan
   $respuesta->addScriptCall("xajax_func_lista_planes",$id_convenio);
   return $respuesta;
}

function func_datos_domicilio ($id_plan , $dato , $filtro) {
 global $td_color , $path_imagenes_ruta, $fontdef;
 $padron_fetch =null;
 $img =null;
 $casa = null;
 
 switch ($filtro) {
    case 1:
        if (($dato <> ' ') && ($dato <> '') && ($dato <> null))
         {
          $consulta_padron=mysql_query ("
                                         select *
                                         from clientes left join convenios
                                         on (clientes.convenio_id = convenios.id)
                                         where clientes.nroafiliado = '".$dato."'
                                        ");
                                        
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
          $consulta_padron=mysql_query ("
                                         select *
                                         from clientes left join convenios
                                         on (clientes.convenio_id = convenios.id)
                                         where clientes.documento = '".$dato."'
                                        ");
                                     
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
          $consulta_padron=mysql_query ("
                                         select *
                                         from clientes left join convenios
                                         on (clientes.convenio_id = convenios.id)
                                         where (clientes.nombre like '%".$dato."%')
                                        ");
                                     
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
  if ($padron_fetch['idzona'] == $fila['idzonas'])
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
                 <table border="0" align="center" width="100%"  >
                  <tr>
                    <td width="24%" align="center">Calle</td>
                    <td width="5%" align="center">Nro</td>
                    <td width="5%" align="center">Piso</td>
                    <td width="5%" align="center">Dpto.</td>
                    <td width="45%" align="center">Referencia</td>
                  </tr>
                  <tr>
                    <td><input value="'.$padron_fetch['calle'].'" type="text"       id="td_padron_calle" size="40"/></td>
                    <td><input value="'.$padron_fetch['nrocalle'].'" type="text"    id="td_padron_nro"   size="10%"/></td>
                    <td><input value="'.$padron_fetch['piso'].'" type="text"        id="td_padron_piso"  size="10%"/></td>
                    <td><input value="'.$padron_fetch['depto'].'" type="text"       id="td_padron_depto" size="10%"/></td>
                    <td align="center"><input  type="text" name="referencia" size="72"/></td>

                  </tr>
                  </table>
                  <table border="0" align="center" width="100%">
                  <tr>
                   <td align="center" >Barrio</td>
                   <td align="center" colspan="2">Entre</td>
                  </tr>
                  <tr>
                   <td><input id="td_padron_barrio" value="'.$padron_fetch['barrio'].'" size="100"></td>
                   <td><input id="td_padron_entre1" value="'.$padron_fetch['entre1'].'" size="45"></td>
                   <td><input id="td_padron_entre2" value="'.$padron_fetch['entre2'].'" size="45"></td>
                  </tr>
                 </table>
                 <table border="0" align="left" width="60%">
                  <tr>
                    <td width="180" align="center" >Localidad</td>
                    <td width="200" colspan="2"  align="center" >Zona</td>
                  </tr>
                  <tr>
                    <td width=""><input id="td_padron_localidad" value="'.$padron_fetch['localidad'].'" type="text" size="50"/></td>
                    <td width="">'.$zona_vector.'</td>
                    <td width="200" align="center"><div id="img_alerta_zona">'.$img.'</div></td>
                  </tr>
                 </table>
  ';

   $salida = $html_salida;
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("td_datos_domicilio","innerHTML",$salida);

   return $respuesta;
}

function fun_alerta_zona ($id_zona) {
  global $path_imagenes_ruta;
  $html_salida = null; 
  
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

function func_lista_motivos ($idmotivo) {
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
    $html_salida.= '<option selected="selected" value="'.$fila['idmotivo'].''.$fila['idmotivo2'].'" >'.$fila['desc'].'</option>';
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

function busca_motivos($idmotivo) {

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

function lista_color($idcolor) {
 global $path_imagenes_ruta;
 $foquito = null;
 $td_color = null;

 $ids ['0'] = substr($idcolor, 0, 1);
 
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
                            $_nosocio5 , $_noedad5 , $_nosexo5, $_noiden5 , $_nodocum5 ,
                            $_bandera_nosocio1 ,$_bandera_nosocio2 ,$_bandera_nosocio3 ,$_bandera_nosocio4 ,
                            $_bandera_nosocio5
                           )
{

         $_fecha = substr($_fecha, 6, 4).'.'.substr($_fecha, 3, 2).'.'.substr($_fecha, 0, 2);
         //$moti_explode = explode ("-",$_motivo1);

		
		$moti_explode ['0'] = substr($_motivo1, 0, 1);
        $moti_explode ['1'] = substr($_motivo1, 1, 2);
		$_plan = $_plan + 0;
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
          observa2,operec,fechallam)

          values

          (
          "'.$_fecha.'" , "'.$_telefono.'" , "'.$_plan.'" ,
          "'.$_horallam.'","'.$_socio.'",
          "'.utf8_decode($_nombre).'","'.$_tiposocio.'",
          "'.utf8_decode($_edad).'","'.utf8_decode($_sexo).'",
          "'.utf8_decode($_identificacion).'","'.utf8_decode($_documento).'",
          "'.utf8_decode($_calle).'","'.utf8_decode($_numero).'",
          "'.utf8_decode($_piso).'","'.utf8_decode($_depto).'",
          "'.utf8_decode($_casa).'","'.utf8_decode($_monoblok).'",
          "'.utf8_decode($_barrio).'","'.utf8_decode($_entre1).'",
          "'.utf8_decode($_entre2).'","'.utf8_decode($_localidad).'",
          "'.utf8_decode($_referencia).'","'.$_zona.'",
          '.$moti_explode[0].',
          '.$moti_explode[1].','.$_color.',
          "'.utf8_decode($_observa1).'","'.utf8_decode($_observa2).'",
          "'.utf8_decode($_opedesp).'" , "'.$_fecha.'"
          )
         ';
  // insert de la emergencia en atenciones temp
   global $G_legajo , $parametros_js;
   $result = mysql_query($insert_atencion);
   if (!$result) {
    $boton = '<input  type="button" value="Error! modificar y presionar nuevamente"
			           onclick=" check_emergencia(
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
					   '.$parametros_js.' 
           	   );"/> ';
     
   }else 
   {
    $boton = '<input  type="button" value="CERRAR CON EXITO"  onclick="window.close();" />';

    // recupero id para hacer altas de clientes no  apadronados
    $consulta_id = mysql_query ('select id from atenciones_temp
                               where fecha     = "'.$_fecha.'"     and plan = "'.$_plan.'"
                                and  horallam  = "'.$_horallam.'"  and nombre = "'.$_nombre.'"
                                and  tiposocio = "'.$_tiposocio.'" and motivo1  = '.$moti_explode[0].'
                                and motivo2 = '.$moti_explode[1]);


      $fetch_idatencion=mysql_fetch_array($consulta_id);

			if ($_bandera_nosocio1 == 1) { $insert_nosocio1 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni) values ("'.$fetch_idatencion['id'].'" , "'.$_nosocio1.'" , "'.$_noedad1.'" , "'.$_nosexo1.'" , "'.$_noiden1.'" , "'.$_nodocum1.'" ) '); }
			if ($_bandera_nosocio2 == 1) { $insert_nosocio2 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni) values ("'.$fetch_idatencion['id'].'" , "'.$_nosocio2.'" , "'.$_noedad2.'" , "'.$_nosexo2.'" , "'.$_noiden2.'" , "'.$_nodocum2.'" ) '); }
			if ($_bandera_nosocio3 == 1) { $insert_nosocio3 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni) values ("'.$fetch_idatencion['id'].'" , "'.$_nosocio3.'" , "'.$_noedad3.'" , "'.$_nosexo3.'" , "'.$_noiden3.'" , "'.$_nodocum3.'" ) '); }
			if ($_bandera_nosocio4 == 1) { $insert_nosocio4 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni) values ("'.$fetch_idatencion['id'].'" , "'.$_nosocio4.'" , "'.$_noedad4.'" , "'.$_nosexo4.'" , "'.$_noiden4.'" , "'.$_nodocum4.'" ) '); }
			if ($_bandera_nosocio5 == 1) { $insert_nosocio5 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni) values ("'.$fetch_idatencion['id'].'" , "'.$_nosocio5.'" , "'.$_noedad5.'" , "'.$_nosexo5.'" , "'.$_noiden5.'" , "'.$_nodocum5.'" ) '); }

   }
   //$insert_atencion='';
   $insert_atencion='';
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   //escribimos en la capa con id="respuesta" el texto que aparece en $salida
   $respuesta->addAssign("mensaje_agrega","innerHTML",$boton);

   //tenemos que devolver la instanciaci�n del objeto xajaxResponse
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
							$_nosocio5 , $_noedad5 , $_nosexo5, $_noiden5 , $_nodocum5 ,
                            $_bandera_nosocio1 ,$_bandera_nosocio2 ,$_bandera_nosocio3 ,$_bandera_nosocio4 ,
							$_bandera_nosocio5  
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
          observa2,operec,traslado_aux ,fechallam)

          values

          (
          "'.$_fecha.'" , "'.$_telefono.'" , "'.$_plan.'" ,
          "'.$_horallam.'","'.$_socio.'",
          "'.utf8_decode($_nombre).'","'.$_tiposocio.'",
          "'.$_edad.'","'.$_sexo.'",
          "'.utf8_decode($_identificacion).'","'.$_documento.'",
          "'.utf8_decode($_calle).'","'.utf8_decode($_numero).'",
          "'.utf8_decode($_piso).'","'.utf8_decode($_depto).'",
          "'.utf8_decode($_casa).'","'.utf8_decode($_monoblok).'",
          "'.utf8_decode($_barrio).'","'.utf8_decode($_entre1).'",
          "'.utf8_decode($_entre2).'","'.utf8_decode($_localidad).'",
          "'.utf8_decode($_referencia).'","'.$_zona.'",
          '.$moti_explode[0].',
          '.$moti_explode[1].','.$_color.',
          "'.utf8_decode($_observa1).'","'.utf8_decode($_observa2).'",
          "'.utf8_decode($_opedesp).'", "'.$traslado_aux.'" , "'.$_fecha.'"
          )
         ';

  // insert de la emergencia en atenciones temp
   global $G_legajo , $parametros_js;
   $result = mysql_query($insert_atencion);
   if (!$result) {
    $boton = '<input  type="button" value="Error! modificar y presionar nuevamente"
			           onclick=" check_emergencia(
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
					   '.$parametros_js.' 
           	   );"/> ';
     
   }else 
    {
      $boton = '<input  type="button" value="CERRAR CON EXITO" onclick="window.close();"/>';
  


	  // recupero id para hacer altas de clientes no  apadronados
	  $consulta_id = mysql_query ('select id from atenciones_temp
	                               where fecha     = "'.$_fecha.'"     and plan = "'.$_plan.'"
	                                and  horallam  = "'.$_horallam.'"  and nombre = "'.$_nombre.'"
	                                and  tiposocio = "'.$_tiposocio.'" and motivo1  = '.$moti_explode[0].'
	                                and motivo2 = '.$moti_explode[1]);


	  $fetch_idatencion=mysql_fetch_array($consulta_id);


		if ($_bandera_nosocio1 == 1)  { $insert_nosocio1 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni) values ("'.$fetch_idatencion['id'].'" , "'.$_nosocio1.'" , "'.$_noedad1.'" , "'.$_nosexo1.'" , "'.$_noiden1.'" , "'.$_nodocum1.'" ) '); }
		if ($_bandera_nosocio2 == 1)  { $insert_nosocio2 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni) values ("'.$fetch_idatencion['id'].'" , "'.$_nosocio2.'" , "'.$_noedad2.'" , "'.$_nosexo2.'" , "'.$_noiden2.'" , "'.$_nodocum2.'" ) '); }
		if ($_bandera_nosocio3 == 1)  { $insert_nosocio3 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni) values ("'.$fetch_idatencion['id'].'" , "'.$_nosocio3.'" , "'.$_noedad3.'" , "'.$_nosexo3.'" , "'.$_noiden3.'" , "'.$_nodocum3.'" ) '); }
		if ($_bandera_nosocio4 == 1)  { $insert_nosocio4 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni) values ("'.$fetch_idatencion['id'].'" , "'.$_nosocio4.'" , "'.$_noedad4.'" , "'.$_nosexo4.'" , "'.$_noiden4.'" , "'.$_nodocum4.'" ) '); }
		if ($_bandera_nosocio5 == 1)  { $insert_nosocio5 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni) values ("'.$fetch_idatencion['id'].'" , "'.$_nosocio5.'" , "'.$_noedad5.'" , "'.$_nosexo5.'" , "'.$_noiden5.'" , "'.$_nodocum5.'" ) '); }
    }
  // mysql_query($insert_atencion);
   $insert_atencion='';
   //$insert_atencion='';
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   //escribimos en la capa con id="respuesta" el texto que aparece en $salida
   $respuesta->addAssign("mensaje_agrega","innerHTML",$boton);

   //tenemos que devolver la instanciaci�n del objeto xajaxResponse
   return $respuesta;
}


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

$xajax->processRequests();

$html_salida = '
<html>
<head>

<script defer type="text/javascript" src="js/jsfunciones.js"></script>
<script defer type="text/javascript" src="js/jquery-1.9.1.min.js"></script>

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
 
 xajax_func_datos_padron(0,0,0);
 xajax_func_lista_planes(0);
 xajax_func_input_planes(0);

 xajax_func_datos_domicilio (0,0,0);
 xajax_fun_alerta_zona (0);
 xajax_func_lista_motivos (0);
 xajax_busca_motivos(0);
 xajax_lista_color(0);
}
</script>

<link href="css/mod_alta.css" type="text/css" rel="stylesheet">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>Modulo para alta de Emergencias</title>
   '.$xajax->printJavascript("xajax/").'
</head>
<body onLoad="on_Load();">

 <form id="formulario" name="formulario" >

    <table align="center" width="100%" class="datos_receptor">
      <tr>
        <td width="25%"  align="center">Receptor</td>
        <td width="15%"  align="center">Hora</td>
        <td width="12%"  align="center">Hora Llamado</td>
      </tr>
      <tr>
        <td width="21%" align="center">'.$G_usuario.'</td>
        <td width="15%" align="center"><input type="text" name="reloj" size="6"></td>
        <td width="7%"  align="center"><input type="text" id="hora" value="'.muestra_hora().'" size="4"/></td>
      </tr>
    </table>

    <table align="center" class="filtros">
     <tr>
        <td colspan="2" align="center" >Filtros de busqueda</td>

        <td width="" align="center" >Telefono</td>

        <td width=""  colspan="2" align="center" >Planes</td>
     </tr>
     <tr>
        <td width="10%"  colspan="" align="center" style="">
        <input type="text" size="20" id="i_busca_padron"
         onBlur="xajax_func_datos_padron(document.formulario.i_busca_plan.value,
                                          document.formulario.i_busca_padron.value,
                                          document.formulario.s_filtro_busqueda.value);
                 xajax_func_datos_domicilio(document.formulario.i_busca_plan.value,
                                          document.formulario.i_busca_padron.value,
                                          document.formulario.s_filtro_busqueda.value);
                  "
                                          />
       </td>
       <td width="10%"  colspan="" align="center" style="">
        <select name="s_filtro_busqueda"
         onKeyUp="xajax_func_datos_padron(document.formulario.i_busca_plan.value,
                                          document.formulario.i_busca_padron.value,
                                          document.formulario.s_filtro_busqueda.value);
                  xajax_func_datos_domicilio(document.formulario.i_busca_plan.value,
                                          document.formulario.i_busca_padron.value,
                                          document.formulario.s_filtro_busqueda.value);
                  "
        />
         <option value="1">Numero de socio</option>
         <option value="2">DNI</option>
         <option value="3" selected="selected" >Filtro Libre</option>
        </select>
      </td>
       <td width="15%"  colspan="" align="center" style=""><input type="text" id="telefono" /></td>
       <td width="10%"  colspan="" align="center" style="">
        <div id="i_lista_planes">
         <input id="i_busca_plan" size="7" type="text" 
         onChange="xajax_func_lista_planes(document.formulario.i_busca_plan.value);" 
         />
        </div>
       </td>
       <td width=""  colspan="" align="center" style=""><div id="s_lista_planes"></div></td>
     </tr>
    </table>


 <div  id="td_datos_padron">
 </div>

 <table  border="0" align="center" width="100%" height="100">
  <tr>
   <td align="center" colspan="8" valign="top">
    <table border="0" align="center" valign="top"  class="datos_socio">
    <tr>
     <td>Marcar</td>
     <td colspan="2" align="center" >No Socio - Razon Social</td>
     <td align="center">Edad</td>
     <td align="center">Sexo</td>
     <td align="center">Identificacion</td>
     <td align="center">Documento</td>
    </tr>
     '.$filas_nosocio.'
    </table>
   </td>
  </tr>
 </table>


 <div id="td_datos_domicilio"></div>


 <table border="0" width="100%" align="left">
  <tr>
   <td align="center" width="5%">Motivo</td>
   <td width="1%" align="center"><div id="i_busca_motivos"></div></td>
   <td width="3%" align="center"><div id="div_lista_motivos"></div></td>
   <td width="3%"><div id="div_pre_arribo"></div></td>
   <td width="5%"><div id="div_lista_colores"></div></td>
   <td width="3%" align="center"><div id="div_muestra_foquito"></div></td>
   <td width="50%"><div id="div_traslado"></div></td>
  </tr>
 </table>

<br>
<br>
<table align="left" width="" border="0">
  <tr><td colspan="1" align="center">Ingrese observaciones</td><td colspan="1" align="center">Detalles del Plan</td></tr>
  <tr>
    <td valign="top" width="20%"><input type="text" name="obs1" size="90%"/><br>
                                 <input  type="text" name="obs2" size="90%"/><br>
                                 <input  type="text" name="obs3" size="90%"/><br>
                                 <input  type="text" name="obs4" size="90%"/><br>
                                 <input  type="text" name="obs5" size="90%"/><br>
                                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </td>
    <td valign="middle" aign="center" height="100%" style="background: #B1B1B1;"><div id="div_muestra_textarea" aign="center"></div></td>
  </tr>
  <tr>
  <td colspan="2">
     <div id="mensaje_agrega">
        <input  type="button" value="Agregar Emergencia"
               onclick=" check_emergencia(
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
                       '.$parametros_js.'
                       );"
         />
      </div>
  </td>

  </tr>
</table>

</form>
</html>';

echo $html_salida;
