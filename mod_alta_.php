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
//conexion();
//$base = $bd_database;
//sel_db ($base);

$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
################### Preparamos todos los vectores ########################

// vector de planes
   $consulta_planes = mysql_query ("SELECT idplan , descplan , datos
                                    FROM planes");  
   $vector_planes_js='lista = new Array("PLANES",';
   while ($fila=mysql_fetch_array($consulta_planes))
   {
    $vector_planes_js.='"'.$fila['idplan'].'-'.$fila['descplan'].'",'; 
   }
   $vector_planes_js= substr($vector_planes_js, 0, -2);   
   $vector_planes_js.= '");'; 
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

// vector de motivos
   $consulta_motivos = mysql_query ("SELECT *
                                    FROM motivos");  
   $vector_motivos_js='lista_motivos = new Array("MOTIVOS",';
   while ($fila=mysql_fetch_array($consulta_motivos))
   {
    $vector_motivos_js.='"'.$fila['idmotivo'].'-'.$fila['idmotivo2'].'-'.$fila['desc'].'",'; 
   }
   $vector_motivos_js= substr($vector_motivos_js, 0, -2);   
   $vector_motivos_js.= '");'; 
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

// vector de colores
   $consulta_colores = mysql_query ("SELECT *
                                    FROM colores");
   if ($consulta_colores <> null)
   {
	
     while ($fila=mysql_fetch_array($consulta_colores))
      {
	   $vector_colores.='<option value="'.$fila['idcolor'].'">'.$fila['desc'].'</option> ';
      }
   }else $vector_colores.='<option value="0">Agregar colores</option> '; 
   
    $vector_colores.= '<option value="0" selected="selected">Modificar</option> ';
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

// vector de motivos del llamado
   $consulta_motivos = mysql_query ("SELECT *
                                    FROM motivos");
   //$vector_motivos='<option value="0">MOTIVO DEL LLAMADO</option> '; 								
   if ($consulta_motivos <> null)
   {
    while ($fila=mysql_fetch_array($consulta_motivos))
    {
     $vector_motivos.='<option value="'.$fila['idmotivo'].'|'.$fila['idmotivo2'].' ">'.$fila['desc'].'</option> '; 
    }
   }else $vector_motivos.='<option value="0">Agregar motivos</option> '; 

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

// vector zonas
   $consulta_zonas = mysql_query ("SELECT *
                                    FROM zonas");
   if ($consulta_zonas <> null)
   {
    while ($fila=mysql_fetch_array($consulta_zonas))
    {
      $vector_zonas.='<option value="'.$fila['idzonas'].' ">'.$fila['desczonas'].'</option> '; 
    }
   }else $vector_zonas.='<option value="0" selected="selected">ZONAS</option> '; 

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
######################DEF FUNCIONES XAJAX########################

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
// funciones para la libreria
function refresca_textarea($entrada){
   $entrada = explode ("-",$entrada);
   // consulta planes 
   $consulta = mysql_query("SELECT datos
                             FROM planes 
							 WHERE idplan =".$entrada[0]); //idplan - descplan
   //*
   $textarea = '<textarea style=" background-color:'.$td_color.'" type="text" name="notas" size="40" rows="10" cols="30" >';
  
  if ($consulta <> null)
   {
    while ($fila=mysql_fetch_array($consulta))
    {
     $textarea.= htmlentities($fila['datos']); 
    }
    $textarea.='</textarea>';
   }else $textarea.="S/D".'</textarea>';
   
   //$salida = $consulta;
   $salida =$textarea;
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   //escribimos en la capa con id="respuesta" el texto que aparece en $salida
   $respuesta->addAssign("respuesta","innerHTML",$salida);

   //tenemos que devolver la instanciación del objeto xajaxResponse
   return $respuesta;
}

function refresca_color($id_color){

   $ids = explode ("|" , $id_color);
   // consulta planes 
   $consulta = mysql_query ("SELECT *
                             FROM colores 
							 WHERE idcolor =".$ids[0]); //idplan - descplan
   //*
   if ($consulta <> null)
   {
    while ($fila=mysql_fetch_array($consulta))
    {
     $ver='<input  type="hidden" name="colores" size="4%" value="'.$fila['idcolor'].'" />'; 
	 $desc_color = '<input type="text" name="nombre_color" value="'.$fila['desc'].'">';   
    } 
   }else 
         {
      		 $ver= '<input type="text" name="colores" size="4%"  value="s/d" />'; 
	         $desc_color = '<input type="text" name="nombre_color" value="ASIGNAR COLOR">';   
         } 
		 
   $salida = $ver;
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   //escribimos en la capa con id="respuesta" el texto que aparece en $salida
   $respuesta->addAssign("respuesta2","innerHTML",$salida);
   $respuesta->addAssign("respuesta7","innerHTML",$desc_color);
   //$respuesta->addAssign("respuesta3","innerHTML",$salida);
   //tenemos que devolver la instanciación del objeto xajaxResponse
   return $respuesta;
}

function refresca_motivos($ids_motivos){
   
   if ($ids_motivos <> "nada") 
   {
   // consulta planes
   $ids = explode ("-" , $ids_motivos);
   							 
   $salida =  '<input  type="hidden" name="cod_motivo" size="4%" value="'.$ids[0].'" />'; 
   $salida2 = '<input type="hidden" name="cod_motivo" size="4%" value="'.$ids[0].'" />'; 
   $salida3 = '<input  type="hidden" name="cod_motivo2" size="4%" value="'.$ids[1].'" />';
   
         
   $consulta = mysql_query ("SELECT *
                             FROM colores 
							 WHERE idcolor =".$ids[0]); //idplan - descplan
   
   if ($consulta<> null)
   {									
    while ($fila=mysql_fetch_array($consulta))
      $desc_color = '<input type="text" name="nombre_color" value="'.$fila['desc'].'">';    
   }else $desc_color = $ids[0]; 	
   }else
   {
     $salida =  '<input  type="hidden" name="cod_motivo" size="4%" value="0" />'; 
     $salida2 = '<input type="hidden" name="cod_motivo" size="4%" value="0" />'; 
     $salida3 = '<input  type="hidden" name="cod_motivo2" size="4%" value="0" />';
	 $desc_color = '<input type="text" name="nombre_color" value="Ninguno" />';
   }
   
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   //escribimos en la capa con id="respuesta" el texto que aparece en $salida
   $respuesta->addAssign("respuesta4","innerHTML",$salida);
   $respuesta->addAssign("respuesta2","innerHTML",$salida2);
   $respuesta->addAssign("respuesta3","innerHTML",$salida3);
   $respuesta->addAssign("respuesta7","innerHTML",$desc_color);
   
   
   //tenemos que devolver la instanciación del objeto xajaxResponse
   return $respuesta;
}

function refresca_planes($ids_plan){
   
   $ids_vector=explode ("-", $ids_plan);
   // consulta planes   							 
   $salida =  '<input style="background-color:#CCCCCC" type="hidden" id="var_cod_plan" name="var_cod_plan" value="'.$ids_vector[0].'" />'; 
      
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   //escribimos en la capa con id="respuesta" el texto que aparece en $salida
   $respuesta->addAssign("var_cod_plan_muestra","innerHTML",$salida);
   
   
   //tenemos que devolver la instanciación del objeto xajaxResponse
   return $respuesta;
}

function refresca_cod_zona ($cod_zona){
   
   $consulta = mysql_query ("SELECT *
                             FROM zonas 
							 WHERE idzonas =".$cod_zona); //idplan - descplan
   
   if ($consulta<> null)
   {									
    while ($fila=mysql_fetch_array($consulta))
      $salida = '&nbsp; Fuera de zona: <input size="2" type="text" name="ver_fuera_zona" id="ver_fuera_zona" value="'.$fila['fuerazona'].'">';    
   }else $salida = '&nbsp; Fuera de zona: <input size="2" type="text" name="ver_fuera_zona" id="ver_fuera_zona" value="s/z">';  	
   
   
   //$salida = "asdasd";
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   //escribimos en la capa con id="respuesta" el texto que aparece en $salida
   $respuesta->addAssign("muestra_zona","innerHTML",$salida);
   
   
   //tenemos que devolver la instanciación del objeto xajaxResponse
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
							$_opedesp							
						   )
{                           
 
  //$plan_explode = explode ("-",$_plan);
  $moti_explode = explode ("-",$_motivo1); 

 $consulta_colores = mysql_query ('SELECT *
                                    FROM colores WHERE  `desc` like "'.$_color.'"');
	
		
     while ($fila=mysql_fetch_array($consulta_colores))
      {
	   $id_color=$fila['idcolor'];
      }

 if ($_color == 'Ninguno')
    $id_color=0;
	
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
		  "'.$_nombre.'","'.$_tiposocio.'",
		  "'.$_edad.'","'.$_sexo.'",
		  "'.$_identificacion.'","'.$_documento.'",
		  "'.$_calle.'","'.$_numero.'",
		  "'.$_piso.'","'.$_depto.'",
		  "'.$_casa.'","'.$_monoblok.'",
		  "'.$_barrio.'","'.$_entre1.'",
		  "'.$_entre2.'","'.$_localidad.'",
		  "'.$_referencia.'","'.$_zona.'",
		  '.$moti_explode[0].',
		  '.$moti_explode[1].','.$id_color.',
		  "'.$_observa1.'","'.$_observa2.'",
		  "'.$_opedesp.'"
		  )
		 ';
/*
 $salida =
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
   mysql_query($insert_atencion); 
   $insert_atencion='';
   //$insert_atencion='';
   //instanciamos el objeto para generar la respuesta con ajax
   $respuesta = new xajaxResponse();
   //escribimos en la capa con id="respuesta" el texto que aparece en $salida
   $respuesta->addAssign("mensaje_agrega","innerHTML",$salida);
 
   //tenemos que devolver la instanciación del objeto xajaxResponse
   return $respuesta;
}

function lista_planes ($idplan,$onchange)
{
	
    $consulta_planes = mysql_query ("SELECT idplan , descplan , datos
                                    FROM planes");  
 
	 $list='<select name="list_planes" 
	                onchange="xajax_refresca_textarea(document.formulario.list_planes.value);
					          xajax_lista_padron(0,0);
							  xajax_datos_domicilio(0,0);
							  xajax_input_padron()">';
	//$list='<select name="list_planess" onchange="">';
     if (!$consulta_ids)
     $list.='<option selected="selected" value="0">PLANES</option>';

    
     while ($fila=mysql_fetch_array($consulta_planes))
	 {
      if ($idplan == $fila['idplan'])
	  $list.= '<option selected="selected" value="'.$fila['idplan'].'">'.$fila['descplan'].'</option>';    
	  else 	  
	   $list.= '<option value="'.$fila['idplan'].'">'.$fila['descplan'].'</option>';    
     }
   $consulta_ids = mysql_query("SELECT * FROM planes WHERE idplan =".$idplan);
  // $existe_plan=mysql_fetch_array($consulta_ids); 
   
	 
   $list.='</select>';	 
   
   $salida = $list;
   //$salida="asdasd";
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("lista_planes","innerHTML",$salida);
   return $respuesta;
}

function lista_padron($idsocio,$check_plan)
{
   $consulta_padron = mysql_query("select * from padron where id=".$idsocio." and plan=".$check_plan);

   if (!$consulta_padron)
    {
	 $tds='
	   <tr>
	   <td width="2%"><input  type="text" name="tipo_socia" size="3%"/></td>
       <td width="35%"><input  type="text" name="nombre_socio" size="70%"/></td>
       <td>&nbsp;</td>
       <td><input  type="text" name="edad_socia" size="10%"/></td>
       <td><input  type="text" name="sexo_socia" size="10%"/></td>
       <td>&nbsp;</td>
       <td><input  type="text" name="os_socia" size="40%"/></td>
       <td><input  type="text" name="doc_socia" size="35%"/></td>
	   </tr>
	 '; 
	}
   else
    {
     $fila=mysql_fetch_array($consulta_padron);    
     $tds='
       <td width="2%"><input  type="text" name="tipo_socia" size="3%" value="'.$fila['tiposocio'].'" /></td>
       <td width="35%"><input  type="text" name="nombre_socia" value = "'.$fila['nombre'].'" size="70%"/></td>
       <td>&nbsp;</td>
       <td><input  type="text" name="edad_socia" size="10%" value="'.$fila['edad'].'" /></td>
       <td><input  type="text" name="sexo_socia" size="10%" value="'.$fila['sexo'].'" /></td>
       <td>&nbsp;</td>
       <td><input  type="text" name="os_socia" size="40%" value="'.$fila['identificacion'].'" /></td>
       <td><input  type="text" name="doc_socia" size="35%" value="'.$fila['documento'].'" /></td>
	   '; 
    }

   

   $salida = $tds;
   //$salida=$idsocio;
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("lista_padron","innerHTML",$salida);
   return $respuesta;

} 
function limpia_padron()
{
   $salida = '';
   //$salida=$idsocio;
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("lista_padron","innerHTML",$salida);
   return $respuesta;
}

function input_padron ()
{
   $valor = '';
   $salida = '
              <input onKeyUp ="xajax_lista_padron(document.formulario.cod_socia.value,document.formulario.list_planes.value);
			                    xajax_datos_domicilio(document.formulario.cod_socia.value,document.formulario.list_planes.value);" 
	          type="text" id="cod_socia" name="cod_socia" size="7%" value="'.$valor.'" />
   ';
   //$salida=$idsocio;
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("input_padron","innerHTML",$salida);
   return $respuesta;
 
} 

function datos_domicilio ($idsocio,$check_plan)
{
   global $body_color , $td_color;
   $consulta_padron = mysql_query("select * from padron where id=".$idsocio." and plan=".$check_plan);
  
   if (!$consulta_padron)
   {
       //********************************************************
       $consulta_zonas = mysql_query ("SELECT *
                                    FROM zonas");
									
       if ($consulta_zonas <> null)
       {
        while ($fila=mysql_fetch_array($consulta_zonas))
        {
	     $vector_zonas.='<option value="'.$fila['idzonas'].' ">'.$fila['desczonas'].'</option> '; 
        }
       }else $vector_zonas.='<option value="0" selected="selected">ZONAS</option> '; 
       //**********************************************************
	   
     $tds = '
				 <table width="97%" border="0">
				  <tr>
				    <td width="23%" align="center" style=" background-color:'.$td_color.'">Calle</td>
				    <td width="5%" align="center"  style=" background-color:'.$td_color.'">Nro</td>
				    <td width="5%" align="center"  style=" background-color:'.$td_color.'">Piso</td>
				    <td width="5%" align="center"  style=" background-color:'.$td_color.'">Dpto.</td>
				    <td width="6%" align="center"  style=" background-color:'.$td_color.'">Casa</td>
				    <td width="5%" align="center"  style=" background-color:'.$td_color.'">Mon</td>
				    <td width="51%" align="center">&nbsp;</td>
				  </tr>
				  <tr>
				    <td style="background-color:#CCCCCC"><input  type="text" name="calle" size="45%"/></td>
				    <td style="background-color:#CCCCCC"><input  type="text" name="nro" size="10%"/></td>
				    <td style="background-color:#CCCCCC"><input  type="text" name="piso" size="10%"/></td>
				    <td style="background-color:#CCCCCC"><input  type="text" name="depto" size="10%"/></td>
				    <td style="background-color:#CCCCCC"><input  type="text" name="casa" size="10%"/></td>
				    <td style="background-color:#CCCCCC"><input  type="text" name="mon" size="10%"/></td>
				    <td>&nbsp;</td>
				  </tr>
				 </table>
				 <table width="82%" border="0" style="background-color:$body_color">
				  <tr>
				    <td width="48%" style=" background-color:'.$td_color.'" align="center">Barrio</td>
				    <td width="9%">&nbsp;</td>
				    <td colspan="3" align="center"style=" background-color:'.$td_color.'" >Entre</td>
				  </tr>
				  <tr>
				    <td><input  type="text" name="barrio" size="72%"/></td>
				    <td>&nbsp;</td>
				    <td width="22%"><input  type="text" name="entre1" size="40%"/></td>
				    <td width="22%" align="center">y</td>
				    <td width="21%"><input  type="text" name="entre2" size="40%"/></td>
				  </tr>
				 </table>
				  <table width="56%" border="0">
				  <tr>
				    <td width="20%" style=" background-color:'.$td_color.'" align="center" >Localidad</td>
				    <td width="20%" style=" background-color:'.$td_color.'" align="center" colspan="3">Zona</td>
				  </tr>
				  <tr>
				    <td width="20%"><input type="text" name="localidad" size="60%"/></td>
				    <td width="16%">
					 <select name="zonas_cod" onchange=""> 
					 '.$vector_zonas.'
					 </select>
					</td>
				  </tr>
				 </table>
				 <table width="36%" border="0">
				  <tr>
				    <td style=" background-color:'.$td_color.'" align="center">Referencia</td>
				  </tr>
				  <tr>
				    <td><input  type="text" name="referencia" size="75%"/></td>
				  </tr>
				 </table>
				 ';
   }else
   {
    $fila=mysql_fetch_array($consulta_padron); 
	
	   //********************************************************
       $consulta_zonas = mysql_query ("SELECT *
                                    FROM zonas");
									
       if ($consulta_zonas <> null)
       {
        while ($fila_zona=mysql_fetch_array($consulta_zonas))
        {
		 if ($fila_zona['idzonas'] == $fila['zona'])
		  {
		   if ($fila_zona['fuerazona']=='V')
            {		   
              $vector_zonas.='<option selected="selected" value="'.$fila_zona['idzonas'].' ">'.$fila_zona['desczonas'].' - FUERA DE ZONA</option> '; 
			  //$zona_zona = "FUERA"; 
            }
		   else
		     {
 		      $vector_zonas.='<option selected="selected" value="'.$fila_zona['idzonas'].' ">'.$fila_zona['desczonas'].'</option> '; 
			  //$zona_zona = "DENTRO"; 
			 } 
		  }
		 else
		  {
            if ($fila_zona['fuerazona']=='V') 
			{
     		 $vector_zonas.='<option value="'.$fila_zona['idzonas'].' ">'.$fila_zona['desczonas'].' - FUERA DE ZONA </option> '; 
			 //$zona_zona = "FUERA"; 
			}
			else
			 {
			  $vector_zonas.='<option value="'.$fila_zona['idzonas'].' ">'.$fila_zona['desczonas'].'</option> ';
			  //$zona_zona = "DENTRO";
             }			  
	      }		
        }
       }else $vector_zonas.='<option value="0" selected="selected">ZONAS</option> '; 
       //**********************************************************
	   
	$tds = '
				 <table width="97%" border="0" style="background-color:'.$body_color.'">
				  <tr>
				    <td width="23%" align="center"  style=" background-color:'.$td_color.'">Calle</td>
				    <td width="5%" align="center"   style=" background-color:'.$td_color.'">Nro</td>
				    <td width="5%" align="center"  style=" background-color:'.$td_color.'">Piso</td>
				    <td width="5%" align="center"  style=" background-color:'.$td_color.'">Dpto.</td>
				    <td width="6%" align="center"  style=" background-color:'.$td_color.'">Casa</td>
				    <td width="5%" align="center"  style=" background-color:'.$td_color.'">Mon</td>
				    <td width="51%" align="center">&nbsp;</td>
				  </tr>
				  <tr>
				    <td style="background-color:#CCCCCC"><input  type="text" value="'.$fila['calle'].'" name="calle" size="45%"/></td>
				    <td style="background-color:#CCCCCC"><input  type="text" value="'.$fila['numero'].'" name="nro" size="10%"/></td>
				    <td style="background-color:#CCCCCC"><input  type="text" value="'.$fila['piso'].'" name="piso" size="10%"/></td>
				    <td style="background-color:#CCCCCC"><input  type="text" value="'.$fila['depto'].'" name="depto" size="10%"/></td>
				    <td style="background-color:#CCCCCC"><input  type="text" value="'.$fila['casa'].'" name="casa" size="10%"/></td>
				    <td style="background-color:#CCCCCC"><input  type="text" value="'.$fila['monoblok'].'" name="mon" size="10%"/></td>
				    <td>&nbsp;</td>
				  </tr>
				 </table>
				 <table width="82%" border="0" style="background-color:$body_color">
				  <tr>
				    <td width="48%" style=" background-color:'.$td_color.'" align="center">Barrio</td>
				    <td width="9%">&nbsp;</td>
				    <td colspan="3" align="center"style=" background-color:'.$td_color.'" >Entre</td>
				  </tr>
				  <tr>
				    <td><input  value="'.$fila['barrio'].'" type="text" name="barrio" size="72%"/></td>
				    <td>&nbsp;</td>
				    <td width="22%"><input  value="'.$fila['entre1'].'"  type="text" name="entre1" size="40%"/></td>
				    <td width="22%" align="center">y</td>
				    <td width="21%"><input  value="'.$fila['entre2'].'"  type="text" name="entre2" size="40%"/></td>
				  </tr>
				 </table>
				 <table width="56%" border="0">
				  <tr>
				    <td width="20%" style=" background-color:'.$td_color.'" align="center" >Localidad</td>
				    <td width="20%" style=" background-color:'.$td_color.'" align="center" colspan="3">Zona</td>
				  </tr>
				  <tr>
				    <td width="20%"><input  value="'.$fila['localidad'].'" type="text" name="localidad" size="60%"/></td>
				    <td width="16%">
					 <select name="zonas_cod" onchange=""> 
					 '.$vector_zonas.'
					 </select>
					</td>
					<TD>'.$zona_zona.'</TD>
				  </tr>
				 </table>
				 <table width="36%" border="0">
				  <tr>
				    <td style=" background-color:'.$td_color.'" align="center">Referencia</td>
				  </tr>
				  <tr>
				    <td><input  value="'.$fila['referencia'].'"  type="text" name="referencia" size="75%"/></td>
				  </tr>
				 </table>
				 ';
  
   }
   

 
   $salida=$tds;
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("td_domicilio","innerHTML",$salida);
   return $respuesta;
}

function lista_motios_new($codigos)
{
   $codigos=explode ("-" , $codigos);
// vector de motivos
   $consulta_motivos = mysql_query ("SELECT *
                                    FROM motivos");  
   
   $vector_motivos='<select name="vector_motivos_new" onchange="xajax_refresca_motivos(document.formulario.vector_motivos_new.value);">
                    <option selected="selected" value="0">LISTADO DE MOTIVOS</option>';									 
   while ($fila=mysql_fetch_array($consulta_motivos))
   {
    if (($codigos[0] == $fila['idmotivo']) and ($codigos[1] == $fila['idmotivo2'])) 
	 {
	  $vector_motivos.='<option selected="selected" value="'.$fila['idmotivo'].'-'.$fila['idmotivo2'].'">'.$fila['desc'].'</option>';
 	 }else
      $vector_motivos.='<option value="'.$fila['idmotivo'].'-'.$fila['idmotivo2'].'">'.$fila['desc'].'</option>';
   }
   
   
   $vector_motivos.='</select>';

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

   $salida=$vector_motivos;
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("select_motivos","innerHTML",$salida);
   return $respuesta;
}
################### FUNCIONES XAJAX #############################

//asociamos la función creada anteriormente al objeto xajax
$xajax->registerFunction("refresca_textarea");
$xajax->registerFunction("refresca_color");
$xajax->registerFunction("refresca_motivos");
$xajax->registerFunction("refresca_planes");
$xajax->registerFunction("refresca_cod_zona");
$xajax->registerFunction("agrega_emergencia");
$xajax->registerFunction("lista_planes");
$xajax->registerFunction("lista_padron");
$xajax->registerFunction("limpia_padron");
$xajax->registerFunction("input_padron");
$xajax->registerFunction("datos_domicilio");
$xajax->registerFunction("lista_motios_new");
//El objeto xajax tiene que procesar cualquier petición
$xajax->processRequests();
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

//'.titulo_encabezado('Modulo para alta de emergencias',$path_imagen_logo).'
$html_salida = '
<html>
<head>
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
</script>
<script>
 // Defino el array con los datos
 //lista = new Array("PLANES","41 - CAJA FORENSE","51 - OSPE - CIMESA");
 '.$vector_planes_js.$vector_motivos_js.'
 
 function cargarLista() {
  // Cargamos el combo
  for (x=0;x<lista.length;x++)	
    document.formulario.planes[x] = new Option(lista[x]);

  for (x=0;x<lista_motivos.length;x++)	
    document.formulario.motivos_form[x] = new Option(lista_motivos[x]);
	
  mueveReloj();	
  
  xajax_lista_planes(0,1);
  xajax_lista_padron(0,0);
  xajax_input_padron ();
  xajax_datos_domicilio (0,0);
  xajax_lista_motios_new(0);
  xajax_refresca_color(0);
  document.formulario.planes.style.visibility = \'hidden\';
  document.formulario.motivos_form.style.visibility = \'hidden\';
  //document.formulario.ver_fuera_zona.style.visibility = \'hidden\';
  //document.formulario.nombre_color.value = 0;
 }
  
 function buscar() {
   limpiarLista();
   // Obtengo el valor del texto
   texto = document.formulario.buscaplan.value;
   // Creo la expresión regular
   expr = new RegExp("^" + texto,"i");
   // Recorro la lista. Si la expresión regular es OK
   y = 0;
   for (x=0;x<lista.length;x++) {
     if (expr.test(lista[x])) {
      document.formulario.planes[y] = new Option(lista[x]);
       y++;
     }
   }
 }
 
 function buscar_motivo() {
   limpiarMotivo();
   // Obtengo el valor del texto
   texto = document.formulario.buscar_motivos.value;
   // Creo la expresión regular
   expr = new RegExp("^" + texto,"i");
   // Recorro la lista. Si la expresión regular es OK
   y = 0;
   for (x=0;x<lista_motivos.length;x++) {
     if (expr.test(lista_motivos[x])) {
      document.formulario.motivos_form[y] = new Option(lista_motivos[x]);
       y++;
     }
   }
 }
 
 function limpiarLista() {
   for (x=document.formulario.planes.length;x>=0;x--)
     document.formulario.planes[x] = null; 
 }
 
  function limpiarMotivo() {
   for (x=document.formulario.motivos_form.length;x>=0;x--)
     document.formulario.motivos_form[x] = null; 
 }
 
  xajax_refresca_textarea(document.formulario.buscaplan.value); 
  xajax_refresca_motivos("nada");
  xajax_refresca_planes(0);
  xajax_refresca_cod_zona("V/F");
</script>
<title>Modulo para alta de Emergencias</title>
   '.$xajax->printJavascript("xajax/").'
</head>
<body style="background-color:'.$body_color.'" onLoad="cargarLista();">
'.titulo_encabezado ('Alta de Emergencia' , $path_imagen_logo).'
<form id="formulario" name="formulario" >

<BR>
<table width="97%" style="background-color:$body_color">
  <tr>
    <td width="25%"  colspan="2" align="center" style=" background-color:'.$td_color.'">Datos Receptor</td>
    <td width="3%"   align="center">&nbsp;</td>
    <td width="10%"  align="center" style=" background-color:'.$td_color.'">Llamado Nro. </td>
    <td width="7%"   align="center">&nbsp;</td>
    <td width="15%"  align="center" style=" background-color:'.$td_color.'">Fecha</td>
    <td width="15%"  align="center" style=" background-color:'.$td_color.'">Hora</td>
    <td width="3%"   align="center">&nbsp;</td>
    <td width="12%"  align="center" style=" background-color:'.$td_color.'">Hora Llamado </td>
    <td width="20%"  align="center">&nbsp;</td>
  </tr>
  <tr>
    <td width="4%" style="background-color:#CCCCCC">'.$G_legajo.'</td>
    <td width="21%" style="background-color:#CCCCCC" align="center">'.$G_usuario.'</td>
    <td>&nbsp;</td>
    <td width="10%" style="background-color:#CCCCCC">&nbsp;</td>
    <td>&nbsp;</td>
    <td width="15%" style="background-color:#CCCCCC" align="center"><input style="background-color:#CCCCCC" type="text" name="muestra_fecha" value="'.muestra_fecha().'" /></td>
    <td width="15%" style="background-color:#CCCCCC" align="center"><input style="background-color:#CCCCCC" type="text" name="reloj" size="8"></td>
    <td>&nbsp;</td>
    <td width="7%" style="background-color:#CCCCCC" align="center"><input style="background-color:#CCCCCC" type="text" name="hora" value="'.muestra_hora().'" /></td>
  </tr>
</table>
<table width="97%" style="background-color:$body_color">
  <tr>
    <td width="9%" align="center" style=" background-color:'.$td_color.'">Telefono</td>
    <td width="5%">&nbsp;</td>
    <td width="14%" align="center" style=" background-color:'.$td_color.'">Empresa</td>
    <td width="5%">&nbsp;</td>
    <td align="center" colspan="3" style=" background-color:'.$td_color.'">Plan</td>
    <td width="47%">&nbsp;</td>
  </tr>
  <tr>
    <td style="background-color:#CCCCCC"><input  type="text" name="num_telefono" size="15"/></td>
    <td>&nbsp;</td>
    <td style="background-color:#CCCCCC"><input  type="text" name="empresa" size="40%"/></td>
	<td>&nbsp;</td>
    <td width="3%" style="background-color:#CCCCCC"><input  type="text" name="buscaplan" id="buscaplan" 
	                                                        size="5" onKeyUp="buscar();
															xajax_refresca_textarea(document.formulario.buscaplan.value);
															xajax_refresca_planes(document.formulario.buscaplan.value);
															xajax_lista_planes(document.formulario.buscaplan.value,1);
															xajax_input_padron ();
															xajax_lista_padron(0,0);
                                                            xajax_datos_domicilio(0,0);															
															"/>
	</td>
    <td width="16%" align="center" style="background-color:#CCCCCC">
      <div id="lista_planes"></div>	  
	</td>
    <td><div id="var_cod_plan_muestra"></div></td>
	<td>
	  <select id="planes" name="planes" style="background-color:#CCCCCC" size=1 
	   onchange="xajax_refresca_planes(document.formulario.planes.value);
	   xajax_refresca_textarea(document.formulario.planes.value);">
	  </select>
	</td>
   </tr>
</table>
<table width="97%" border="0" style="background-color:$body_color">
  <tr>
    <td colspan="3" align="center" style="background-color:'.$td_color.'">Socio</td>
    <td width="4%">&nbsp;</td>
    <td width="5%" align="center" style="background-color:'.$td_color.'">Edad</td>
    <td width="5%" align="center" style="background-color:'.$td_color.'">Sexo</td>
    <td width="7%" >&nbsp;</td>
    <td width="20%" align="center" style="background-color:'.$td_color.'">Identificacion</td>
    <td width="18%" align="center" style="background-color:'.$td_color.'">Documento</td>
  </tr>

  <tr>
	<td><div id="input_padron"></div></td>					  
    <td colspan=8><div id="lista_padron"></div></td>
  </tr>
  <tr>
    <td width="4%"><input  type="text" name="cod_socio" size="7%"/></td>
    <td width="2%"><input  type="text" name="tipo_socio" size="3%"/></td>
    <td width="35%"><input  type="text" name="nombre_socio" size="70%"/></td>
    <td>&nbsp;</td>
    <td><input  type="text" name="edad_socio" size="10%"/></td>
    <td><input  type="text" name="sexo_socio" size="10%"/></td>
    <td>&nbsp;</td>
    <td><input  type="text" name="os_socio" size="40%"/></td>
    <td><input  type="text" name="doc_socio" size="35%"/></td>
  </tr>
  <tr>
    <td><input  type="text" name="" size="7%"/></td>
    <td><input  type="text" name="" size="3%"/></td>
    <td><input  type="text" name="" size="70%"/></td>
    <td>&nbsp;</td>
    <td><input  type="text" name="" size="10%"/></td>
    <td><input  type="text" name="" size="10%"/></td>
    <td>&nbsp;</td>
    <td><input  type="text" name="" size="40%"/></td>
    <td><input  type="text" name="" size="35%"/></td>
  </tr>
  <tr>
    <td><input  type="text" name="" size="7%"/></td>
    <td><input  type="text" name="" size="3%"/></td>
    <td><input  type="text" name="" size="70%"/></td>
    <td>&nbsp;</td>
    <td><input  type="text" name="" size="10%"/></td>
    <td><input  type="text" name="" size="10%"/></td>
    <td>&nbsp;</td>
    <td><input  type="text" name="" size="40%"/></td>
    <td><input  type="text" name="" size="35%"/></td>
  </tr>
  <tr>
    <td><input  type="text" name="" size="7%"/></td>
    <td><input  type="text" name="" size="3%"/></td>
    <td><input  type="text" name="" size="70%"/></td>
    <td>&nbsp;</td>
    <td><input  type="text" name="" size="10%"/></td>
    <td><input  type="text" name="" size="10%"/></td>
    <td>&nbsp;</td>
    <td><input  type="text" name="" size="40%"/></td>
    <td><input  type="text" name="" size="35%"/></td>
  </tr>
  <tr>
    <td><input  type="text" name="" size="7%"/></td>
    <td><input  type="text" name="" size="3%"/></td>
    <td><input  type="text" name="" size="70%"/></td>
    <td>&nbsp;</td>
    <td><input  type="text" name="" size="10%"/></td>
    <td><input  type="text" name="" size="10%"/></td>
    <td>&nbsp;</td>
    <td><input  type="text" name="" size="40%"/></td>
    <td><input  type="text" name="" size="35%"/></td>
  </tr>
</table>
<div id="td_domicilio"></div>
<table width="14%" border="0" align="right">

    <td height="48"><div id="respuesta"></div></td>

</table>
<table width="80%" border="0">
  <tr>
    <td width="20%" style="background-color:'.$td_color.'">Motivo del Llamado :</td>
	<td width="5%">
	<input  type="text" name="buscar_motivos" id="buscar_motivos" 
	              size="5" onKeyUp="buscar_motivo();
				                    xajax_refresca_motivos(document.formulario.buscar_motivos.value);
									xajax_lista_motios_new(document.formulario.buscar_motivos.value);"/>
	</td>
    <td><div id="select_motivos"></div></td>
    <td><div id="respuesta4"></div></td>
    <td><div id="respuesta3"></div></td>	
	  <select id="motivos_form" name="motivos_form" style="background-color:#CCCCCC" size=1 
	  onchange="xajax_refresca_motivos(document.formulario.motivos_form.value);">
	  </select> 
  </tr>
</table>
<table width="25%" border="0">
  <tr>
    <td width="13%">      
     <div id="respuesta2"></div>
	</td>
	<td><div id="respuesta7"></div></td>
    <td width="40%">
      <select name="select_colores" 
	  style=" background-color:'.$td_color.'"             
	  onchange="xajax_refresca_color(document.formulario.select_colores.value)">
        '.$vector_colores.'
      </select>
    </td>
  </tr>
</table>
<table width="68%" border="0">
  <tr>
    <td width="15%">Observaciones :</td>
    <td width="85%"><input  type="text" name="obs1" size="80%"/></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input  type="text" name="obs2" size="80%"/>&nbsp;&nbsp;&nbsp;
	<input type="button" name"agregar" value="Agregar Emergencia" 
																				onclick="check_emergencia(document.formulario.muestra_fecha.value,document.formulario.num_telefono.value,
																	                            document.formulario.list_planes.value,document.formulario.hora.value,document.formulario.cod_socia.value,
																								document.formulario.nombre_socia.value,document.formulario.tipo_socia.value,
																								document.formulario.edad_socia.value,document.formulario.sexo_socia.value,
																								document.formulario.os_socia.value,document.formulario.doc_socia.value,
																								document.formulario.calle.value,document.formulario.nro.value,document.formulario.piso.value,
																								document.formulario.depto.value,document.formulario.casa.value,document.formulario.mon.value,
																								document.formulario.barrio.value,document.formulario.entre1.value,document.formulario.entre2.value,
																								document.formulario.localidad.value,document.formulario.referencia.value,document.formulario.zonas_cod.value,
																								document.formulario.vector_motivos_new.value,
																								document.formulario.nombre_color.value,document.formulario.obs1.value,document.formulario.obs2.value,'.$G_legajo.'		
																								);window.close();" />
													&nbsp;&nbsp;&nbsp;<div id="mensaje_agrega"></div>
    </td>
  </tr>
</table>
</form>
</body>
</html> ';

echo $html_salida;

?>
