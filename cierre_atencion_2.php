<?php
//funciones propias
include ('funciones.php');

//archivo de configuracion
include_once ('config.php');

//incluímos la clase ajax
require ('xajax/xajax.inc.php');

//login usuario
require_once ('cookie.php');

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
// VARIABLES GLOBALES - DATOS DE USUARIO LOGON
$cookie = new cookieClass;
$G_usuario = $cookie->get("usuario");
$G_legajo  = $cookie->get("legajo");
$G_perfil  = $cookie->get("perfil");
$G_funcion = $cookie->get("funcion"); 
################### Conexion a la base de datos##########################


//*  CONEXION A LA BASEDE DATOS

$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);


// recupero datos de la emergencia
$idemergencia_temp = $_GET['id'];

if (!$idemergencia_temp)
 die("-");
else 
{
$consulta_atencion = mysql_query("select * from atenciones_temp where id=".$idemergencia_temp);
$atencion_datos = mysql_fetch_array($consulta_atencion);

if (mysql_affected_rows () == 0)
{
$mensaje_error = '
<html>
<head>
<script type="text/javascript">

function load()
 {
  alert("EMERGENCIA YA CERRADA");
  window.close();
 }
</script>

 </head>
   <body onload="load()">
</BODY>
</HTML>
';

echo $mensaje_error;
echo die("");
}
//*
$consulta_plan = mysql_query ("select * from planes where idplan=".$atencion_datos['plan']);
$plan = mysql_fetch_array($consulta_plan);

$consulta_receptor = mysql_query ("select * from legajos where legajo=".$atencion_datos['operec']);
$receptor = mysql_fetch_array($consulta_receptor);
$receptor_nombre= explode(",",$receptor['apeynomb']);

if ($atencion_datos['opedesp'] != null)
 {
  $consulta_ope_desp_nombre = mysql_query("select * from legajos where legajo=".$atencion_datos['opedesp']);
  $opedesp_nombre = mysql_fetch_array($consulta_ope_desp_nombre);
  $opedesp_nombre = $opedesp_nombre['apeynomb'];
 }
else $opedesp_nombre="";

if ($atencion_datos['plan'] != null)
 {
  $consulta_plan_desc = mysql_query("select * from planes where idplan=".$atencion_datos['plan']);
  $plan_desc = mysql_fetch_array($consulta_plan_desc);
  $plan_desc = $plan_desc['datos'];
 }
else $plan_desc="&nbsp;";

if ($atencion_datos['motivo1'] != null)
 {
  $consulta_motivo_desc = mysql_query("select * from motivos where idmotivo=".$atencion_datos['motivo1']." and idmotivo2 =".$atencion_datos['motivo2']);
  $fila_motivos = mysql_fetch_array($consulta_motivo_desc);
  $motivo_desc = $fila_motivos['desc'];
 }
else $motivo_desc="&nbsp;";

//******************  PREPAR INFO PARA MOSTRAR VINCULADOS ******************************
$consulta_vinculados = mysql_query ("select * from clientes_nopadron where idatencion = ".$idemergencia_temp);
$cantidad_vinculados = mysql_affected_rows();
$numero_vinc = 1;
$_FILAVINC.='
<tr>
 <td colspan="11" align="center">DATOS DE LOS CLIENTES NO APADRONADOS</td>
</tr>
<tr>
			        <td width="4%"></td>
					<td width="2%"></td> 
					<td width="10%">NOMBRE Y APELLIDO</td>  
					<td>&nbsp;</td>
					<td>EDAD</td> 
					<td>SEXO</td>
					<td>&nbsp;</td>  
					<td>OBRA SOCIAL</td> 
					<td>DOCUMENTO</td>
					<td>DESTINO</td>
					<td>DIAGNOSTICO</td>

</tr>
';

while ($fila=mysql_fetch_array ($consulta_vinculados))
 {
	$_FILAVINC.='
			  <tr>  
			        <td width="4%"><input id="nosocioid'.$numero_vinc.'" value ="'.$fila['idnopadron'].'" type="hidden" size="2%"/></td>
					<td width="2%"><input id="nosocio'.$numero_vinc.'"   type="checkbox" value="" size="6%"/></td> 
					<td width="10%"><input id="no_socio_'.$numero_vinc.'" type="text" value = "'.elimina_caracteres(htmlentities($fila['nombre'])).'" size="70%"/></td>  <td>&nbsp;</td>
					<td><input  id="no_edad_'.$numero_vinc.'" type="text" value = "'.elimina_caracteres(htmlentities($fila['edad'])).'" size="2%" /></td> 
					<td><input  id="no_sexo_'.$numero_vinc.'" type="text" value = "'.elimina_caracteres(htmlentities($fila['sexo'])).'" size="2%" /></td><td>&nbsp;</td>  
					<td><input  id="no_iden_'.$numero_vinc.'" type="text" value = "'.elimina_caracteres(htmlentities($fila['os'])).'"  size="42%" /></td> 
					<td><input  id="no_docum_'.$numero_vinc.'" type="text" value = "'.elimina_caracteres(htmlentities($fila['dni'])).'" size="20%" /></td>
					<td align="center"><img style="CURSOR: hand" src="imagenes/busca.ico" width="15" height="15" 
										onClick="window.open(\'busca_destinos.php\',\'DESTINOS\', \'width=490,height=80,scrollbars=yes\');" />
									   <input id="destino_'.$numero_vinc.'" size="3%" type="text" />
					</td>
					<td align="center"><img style="CURSOR: hand" src="imagenes/busca.ico" width="15" height="15" 
									   onClick="window.open(\'busca_diagnostico.php\',\'DIAGNOSTICOS\', \'width=490,height=80,scrollbars=yes\');" />
									   <input id="diagno_'.$numero_vinc.'" size="3%" type="text" />				   
					</td>
			  </tr>
			   '; 
	$numero_vinc++;		   
 }

$cantidad_vinculos = 24 - $numero_vinc;
for ($c=0 ; $c <= $cantidad_vinculos ; $c++)
		  {
           $_FILAVINC.='
					  <tr>  
 							<td width="4%"><input  id="nosocioid'.$numero_vinc.'" value="" type="hidden"  size="2%"/></td>
							<td width="2%"><input id="nosocio'.$numero_vinc.'" type="checkbox" value="" size="6%"/></td>
					        <td width="10%"><input id="no_socio_'.$numero_vinc.'" type="text" size="70%"/></td>  <td>&nbsp;</td>
					        <td><input id="no_edad_'.$numero_vinc.'"    type="text"  size="2%"/></td> 
							<td><input id="no_sexo_'.$numero_vinc.'"    type="text"  size="2%"/></td> <td>&nbsp;</td> 
					        <td><input id="no_iden_'.$numero_vinc.'"    type="text" size="42%"/></td> 
							<td><input  id="no_docum_'.$numero_vinc.'"  type="text" nsize="20%"/></td>
   					        <td align="center"><img style="CURSOR: hand" src="imagenes/busca.ico" width="15" height="15" 
							                    onClick="window.open(\'busca_destinos.php\',\'DESTINOS\', \'width=490,height=80,scrollbars=yes\');" />
							                   <input id="destino_'.$numero_vinc.'" size="3%" type="text" />
						    </td>
					        <td align="center"><img style="CURSOR: hand" src="imagenes/busca.ico" width="15" height="15" 
							                   onClick="window.open(\'busca_diagnostico.php\',\'DIAGNOSTICOS\', \'width=490,height=80,scrollbars=yes\');" />
							                   <input id="diagno_'.$numero_vinc.'" size="3%" type="text" />				   
							</td>
					  </tr>
					   ';
			$numero_vinc++;		   
		  }
  		
} 
######### XAJAX ##############################
//instanciamos el objeto de la clase xajax
$xajax = new xajax();
// funciones para la libreria

//LOS PLANES NO SE MODIFICAN *****************************
function lista_planes ($idplan)
{
	
    $consulta_planes = mysql_query ("SELECT idplan , descplan , datos
                                    FROM planes");  
 
	 $list='<select name="s_lista_planes" onchange="xajax_input_busca_plan(document.formulario.s_lista_planes.value);">';

     if ($idplan == 0)
     $list.='<option selected="selected" value="0">PLANES</option>';

    
     while ($fila=mysql_fetch_array($consulta_planes))
	 {
      if ($idplan == $fila['idplan'])
	  $list.= '<option selected="selected" value="'.$fila['idplan'].'">'.elimina_caracteres(htmlentities($fila['descplan'])).'</option>';    
	  else 	  
	   $list.= '<option value="'.$fila['idplan'].'">'.elimina_caracteres(htmlentities($fila['descplan'])).'</option>';    
     }
	 	 
   $list.='</select>';	 
   
   $salida = $list;
   //$salida2='<input type="text" name="" value="'.$idplan.'" onKeyUp="xajax_lista_planes('.$idplan.')">'; 
   //$salida="asdasd";
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("lista_planes","innerHTML",$salida);
   //$respuesta->addAssign("input_busca_plan","innerHTML",$salida);
   return $respuesta;
}

function input_busca_plan ($idplan)
{
   $input='<input type="text" id="i_busca_plan" value="'.$idplan.'" onKeyUp="xajax_lista_planes(document.formulario.i_busca_plan.value);">';
  
   $salida = $input;
   //$salida="asdasd";
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("input_busca_plan_div","innerHTML",$salida);
   return $respuesta;
}
// ############################################################

function lista_diagnostico($iddiagnostico)
{
     $consulta_diagnostico = mysql_query ("SELECT *
                                     FROM diagnosticos ORDER BY descdiagnostico ASC");  
 
	 $list='<select name="s_lista_diagnostico" onchange="xajax_input_busca_diagnostico(document.formulario.s_lista_diagnostico.value);">';
     
	 $bandera=0;
     if ($iddiagnostico == -1)
     $list.='<option selected="selected" value="A">DIAGNOSTICO</option>';

     while ($fila=mysql_fetch_array($consulta_diagnostico))
	 {
      if ($iddiagnostico == $fila['iddiagnostico'])
	     {
	      $list.= '<option selected="selected" value="'.$fila['iddiagnostico'].'">'.elimina_caracteres(htmlentities($fila['descdiagnostico'])).'</option>';    
		  $bandera=1; 
		 } 
	  else  
         {	  
	      $list.= '<option value="'.$fila['iddiagnostico'].'">'.elimina_caracteres(htmlentities($fila['descdiagnostico'])).'</option>'; 	  
		 } 
     }
   if ($bandera==0) $list.='<option selected="selected" value="A">DIAGNOSTICO</option>';
   $list.='</select>';	 
   
   $salida = $list;
   //$salida="asdasd";
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("lista_diagnostico","innerHTML",$salida);
   
   return $respuesta;
}

function input_busca_diagnostico ($iddiagnostico)
{
   $input='<input size="7" type="text" id="i_busca_diagnostico" value="'.$iddiagnostico.'" onKeyUp="xajax_lista_diagnostico(document.formulario.i_busca_diagnostico.value);">';
  
   $salida = $input;
   //$salida="asdasd";
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("input_busca_diagnostico_div","innerHTML",$salida);
   return $respuesta;
}

function lista_destino($iddestino)
{
     $consulta_destino = mysql_query ("SELECT *
                                      FROM destino ORDER BY destino ASC");  
 
	 $list='<select name="s_lista_destino" onchange="xajax_input_busca_destino(document.formulario.s_lista_destino.value);">';

     if ($iddestino == 0)
     $list.='<option selected="selected" value="A">DESTINO</option>';

     while ($fila=mysql_fetch_array($consulta_destino))
	 {
      if ($iddestino == $fila['iddestino'])
	     $list.= '<option selected="selected" value="'.$fila['iddestino'].'">'.elimina_caracteres(htmlentities($fila['destino'])).'</option>';    
	  else   
	   $list.= '<option value="'.$fila['iddestino'].'">'.elimina_caracteres(htmlentities($fila['destino'])).'</option>';    
     }

   $list.='</select>';	 
   
   $salida = $list;
   //$salida="asdasd";
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("lista_destino","innerHTML",$salida);
   
   return $respuesta;
}

function input_busca_destino ($iddestino)
{
   $input='<input type="text" size="7" id="i_busca_destino" value="'.$iddestino.'" onKeyUp="xajax_lista_destino(document.formulario.i_busca_destino.value);">';
  
   $salida = $input;
   //$salida="asdasd";
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("input_busca_destino_div","innerHTML",$salida);
   return $respuesta;
}

function lista_color($idcolor)
{
     $consulta_color = mysql_query ("SELECT *
                                      FROM colores");  
 
	 $list='<select name="s_lista_color" onchange="xajax_input_busca_color(document.formulario.s_lista_color.value);">';

     if ($iddestino == 0)
     $list.='<option selected="selected" value="A">COLOR</option>';

     while ($fila=mysql_fetch_array($consulta_color))
	 {
      if ($idcolor == $fila['idcolor'])
	     $list.= '<option selected="selected" value="'.$fila['idcolor'].'">'.$fila['desc'].'</option>';    
	  else   
	   $list.= '<option value="'.$fila['idcolor'].'">'.$fila['desc'].'</option>';    
     }

   $list.='</select>';	 
   
   $salida = $list;
   //$salida="asdasd";
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("lista_color","innerHTML",$salida);
   
   return $respuesta;
}

function input_busca_color ($idcolor)
{
   $input='<input size="3" type="text" id="i_busca_color" value="'.$idcolor.'" onKeyUp="xajax_lista_color(document.formulario.i_busca_color.value);">';
  
   $salida = $input;
   //$salida="asdasd";
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("input_busca_color_div","innerHTML",$salida);
   return $respuesta;
}

function input_muestra_articulo($idmovil,$idarticulo,$idrubro)
{

     if ((is_numeric($idarticulo)) and (is_numeric($idrubro)))
	 {
	 $consulta_existe = mysql_query ("SELECT *
                                      FROM botiquines
								      WHERE idmovil   = ".$idmovil. 
									  " and  idarticulo = ".$idarticulo.
									  " and  rubro    = ".$idrubro); 
									  
     $consulta_existe = mysql_fetch_array($consulta_existe);
       									  
 
	 if (!$consulta_existe) 
	  $input_desc= '<input type="text" name="" value="">';
	 else 
	  {
 	     $consulta_articulos = mysql_query("SELECT * FROM articulos 
		                                    WHERE idarticulo = ".$idarticulo.
			 						        " and  rubro      = ".$idrubro);
	  
	     $descri_articulo= mysql_fetch_array($consulta_articulos);
		 
		 $input_desc='<input type="text" name="" value="'.elimina_caracteres(htmlentities($descri_articulo['articulo'])).'">';
	  
	  }
   } else $input_desc= '<input type="text" name="" value="">';
   
   
   $salida = $input_desc;
 
   //$salida=$idmovil.'-'.$idarticulo.'-'.$idrubro;
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("input_descarticulo_div","innerHTML",$salida);
   
   return $respuesta;
}

function input_busca_x_articulo ($idarticulo)
{

   $input='<input size="7" type="text" id="i_busca_x_articulo" value="'.$idarticulo.'"
            onKeyUp="xajax_input_muestra_articulo(document.formulario.movilhidden.value,
			                                document.formulario.i_busca_x_articulo.value,
											document.formulario.i_busca_x_rubro.value);">';
  
   $salida = $input;
   //$salida="asdasd";
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("input_busca_x_articulo_div","innerHTML",$salida);
   return $respuesta;
}

function input_busca_x_rubro ($idrubro)
{

   $input='<input size="7" type="text" id="i_busca_x_rubro" value="'.$idrubro.'"
            onKeyUp="xajax_input_muestra_articulo(document.formulario.movilhidden.value,
			                                document.formulario.i_busca_x_articulo.value,
											document.formulario.i_busca_x_rubro.value);">';
  
   $salida = $input;
   //$salida="asdasd";
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("input_busca_x_rubro_div","innerHTML",$salida);
   return $respuesta;
}

function input_valor_coseguro ($xsino)
{
   if ($xsino == 1)
      $input='<input type="text" id="valor_coseguro" onKeyUp="js_control_importe_coseg(document.formulario.valor_coseguro.value);">';
   else
   $input='';
   
  
   $salida = $input;
   //$salida="asdasd";
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("input_coseguro_div","innerHTML",$salida);
   return $respuesta;
}

function ejec ($id_atencion,$id_rubro,$id_articulo,$id_movil,$cantidad)
{
  // validaciones
  
  if ((is_numeric($id_rubro)==true) and (is_numeric($id_articulo)==true) and (is_numeric($cantidad)==true) )
      {
	     if (($id_articulo <> 0) and ($id_rubro <> 0) and ($cantidad <> 0))
		  {
		     $consulta_existe = mysql_query ("SELECT *
                                              FROM botiquines
								              WHERE idmovil   = ".$id_movil. 
									          " and  idarticulo = ".$id_articulo.
									          " and  rubro    = ".$id_rubro); 
									  
             $consulta_existe = mysql_fetch_array($consulta_existe);
       									  
             $mensaje_cantidad ='&nbsp;';
	         if (!$consulta_existe) 
			  $INSERT = ''; // no pasa nada 
			 else 
			  {
			    $control_cantidad = $consulta_existe['cantidad'] - $cantidad;
				
			    if ($control_cantidad >= 0)
				 {
		           $INSERT = mysql_query("insert into botiquin_cierre values (".$id_atencion.",".$id_rubro.",".$id_articulo.",".$id_movil.",".$cantidad.")");
				   //idbotiquines  idmovil  idarticulo  rubro  
				   $RESTA  = mysql_query("update botiquines set cantidad = ".$control_cantidad."
                   				          where  idmovil   = ".$id_movil." and  idarticulo = ".$id_articulo." and  rubro    = ".$id_rubro); 
				 }  
				else $mensaje_cantidad = '<input  size="30" disabled="disabled" type="text" value="CANTIDAD INSUFICIENTE" /><br><br><br>';
			  }	
		  }
      }
  
 

  $consulta_insert = mysql_query("select * from botiquin_cierre
								  where id_atencion =".$id_atencion);
  $html_salida = 
         '<input   size="7"  disabled="disabled" type="text"  value="Art." />
		  <input   size="7"  disabled="disabled" type="text"  value="Rubro." />
	      <input   size="7"  disabled="disabled" type="text"  value="Cantidad" /><br>';
		  
  while ($fila=mysql_fetch_array($consulta_insert))
  {	   
  $html_salida.= 
         '<input size="7"   disabled="disabled" type="text"   value='.$fila['id_articulo'].' />
		  <input  size="7"  disabled="disabled" type="text"  value='.$fila['id_rubro'].' />
	      <input  size="7"  disabled="disabled" type="text"  value='.$fila['cantidad'].' />
		  <input  size="10" disabled="disabled" type="text" value="ASIGNADO" /><br> ';		
  }
   
   $salida =$mensaje_cantidad.$html_salida;
   
   //$salida = $INSERT;
   //$salida="asdasd";
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("muestra_ejec_div","innerHTML",$salida);
   return $respuesta;
}

function cierra_atencion($id_atencion,$destino,$diagnostico,$color,$coseg_si_chek,$coseg_no_chek,$valor_coseg , $obs_final,
							$_nosocio1 , $_noedad1 , $_nosexo1, $_noiden1 , $_nodocum1 , $_destino1, $_diagno1 , 
							$_nosocio2 , $_noedad2 , $_nosexo2, $_noiden2 , $_nodocum2 , $_destino2, $_diagno2 , 
							$_nosocio3 , $_noedad3 , $_nosexo3, $_noiden3 , $_nodocum3 , $_destino3, $_diagno3 , 
							$_nosocio4 , $_noedad4 , $_nosexo4, $_noiden4 , $_nodocum4 , $_destino4, $_diagno4 , 
							$_nosocio5 , $_noedad5 , $_nosexo5, $_noiden5 , $_nodocum5 , $_destino5, $_diagno5 , 
							$_nosocio6 , $_noedad6 , $_nosexo6, $_noiden6 , $_nodocum6 , $_destino6, $_diagno6 , 
							$_nosocio7 , $_noedad7 , $_nosexo7, $_noiden7 , $_nodocum7 , $_destino7, $_diagno7 , 
							$_nosocio8 , $_noedad8 , $_nosexo8, $_noiden8 , $_nodocum8 , $_destino8, $_diagno8 , 
							$_nosocio9 , $_noedad9 , $_nosexo9, $_noiden9 , $_nodocum9 , $_destino9, $_diagno9 , 
							$_nosocio10 , $_noedad10 , $_nosexo10, $_noiden10 , $_nodocum10 , $_destino10, $_diagno10 , 
							$_nosocio11 , $_noedad11 , $_nosexo11, $_noiden11 , $_nodocum11 , $_destino11, $_diagno11 , 
							$_nosocio12 , $_noedad12 , $_nosexo12, $_noiden12 , $_nodocum12 , $_destino12, $_diagno12 , 
							$_nosocio13 , $_noedad13 , $_nosexo13, $_noiden13 , $_nodocum13 , $_destino13, $_diagno13 , 
							$_nosocio14 , $_noedad14 , $_nosexo14, $_noiden14 , $_nodocum14 , $_destino14, $_diagno14 , 
							$_nosocio15 , $_noedad15 , $_nosexo15, $_noiden15 , $_nodocum15 , $_destino15, $_diagno15 , 
							$_nosocio16 , $_noedad16 , $_nosexo16, $_noiden16 , $_nodocum16 , $_destino16, $_diagno16 , 
							$_nosocio17 , $_noedad17 , $_nosexo17, $_noiden17 , $_nodocum17 , $_destino17, $_diagno17 , 
							$_nosocio18 , $_noedad18 , $_nosexo18, $_noiden18 , $_nodocum18 , $_destino18, $_diagno18 , 
							$_nosocio19 , $_noedad19 , $_nosexo19, $_noiden19 , $_nodocum19 , $_destino19, $_diagno19 , 
							$_nosocio20 , $_noedad20 , $_nosexo20, $_noiden20 , $_nodocum20 , $_destino20, $_diagno20 , 
							$_nosocio21 , $_noedad21 , $_nosexo21, $_noiden21 , $_nodocum21 , $_destino21, $_diagno21 , 
							$_nosocio22 , $_noedad22 , $_nosexo22, $_noiden22 , $_nodocum22 , $_destino22, $_diagno22 , 
							$_nosocio23 , $_noedad23 , $_nosexo23, $_noiden23 , $_nodocum23 , $_destino23, $_diagno23 , 
							$_nosocio24 , $_noedad24 , $_nosexo24, $_noiden24 , $_nodocum24 , $_destino24, $_diagno24 ,  
							$_bandera_nosocio1 ,$_bandera_nosocio2 ,$_bandera_nosocio3 ,$_bandera_nosocio4 ,$_bandera_nosocio5 ,$_bandera_nosocio6 ,
							$_bandera_nosocio7 ,$_bandera_nosocio8 ,$_bandera_nosocio9 ,$_bandera_nosocio10 ,$_bandera_nosocio11 ,$_bandera_nosocio12 ,
							$_bandera_nosocio13 ,$_bandera_nosocio14 ,$_bandera_nosocio15 ,$_bandera_nosocio16 ,$_bandera_nosocio17 ,$_bandera_nosocio18 ,
							$_bandera_nosocio19 ,$_bandera_nosocio20 ,$_bandera_nosocio21 ,$_bandera_nosocio22 ,$_bandera_nosocio23 ,$_bandera_nosocio24 ,	
							$_catidad_vincul ,
							$_nosocioid1 ,$_nosocioid2 ,$_nosocioid3 ,$_nosocioid4 ,$_nosocioid5 ,$_nosocioid6 ,
							$_nosocioid7 ,$_nosocioid8 ,$_nosocioid9 ,$_nosocioid10 ,$_nosocioid11 ,$_nosocioid12 ,
							$_nosocioid13 ,$_nosocioid14 ,$_nosocioid15 ,$_nosocioid16 ,$_nosocioid17 ,$_nosocioid18 ,
							$_nosocioid19 ,$_nosocioid20 ,$_nosocioid21 ,$_nosocioid22 ,$_nosocioid23 ,$_nosocioid24 ,  
							$nrecibo
                        )
{

   if ( (is_numeric($id_atencion)==true) and (is_numeric($destino)==true) and 
        (is_numeric($diagnostico)==true) and (is_numeric($id_atencion)==true) )
	{	
      
	  // preparo valor coseguro
	  if (($coseg_no_chek == 'true') or ($coseg_si_chek == 'false') or ($valor_coseg < 0) or (is_numeric($valor_coseg) == false)) 
	     {
		   $valor_coseg_si_no ='no';
		   $valor_coseg = 0;
		 } else $valor_coseg_si_no='si';	
				
	  $UPDATE_ATENCION =mysql_query ("update atenciones_temp set 
	                                          destino     = '".$destino."'
	                                        , coseguro    = '".$valor_coseg_si_no."'
											, impcoseguro = ".$valor_coseg."
											, diagnostico = '".$diagnostico."'
											, colormedico = '".$color."'
											, abierta = 2 where id = ".$id_atencion);	
											
	 $CONSULTA_MOVIL =mysql_fetch_array( mysql_query ("select * from atenciones_temp where id = ".$id_atencion) );										
	 // $UPDATE_MOVIL_DISP =mysql_query ("update movildisponible SET disponible = 0 where idmovildisp = ".$CONSULTA_MOVIL['movil_2']);	
       
	  $INSERT_ATENCION =mysql_query (" 
										  INSERT INTO atenciones
										  SELECT 
                                          id  ,fecha , telefono  , plan , operec , horallam  , socio , integrante , nombre , 
										  tiposocio  ,edad  ,sexo  ,identificacion,  documento , calle ,numero , piso  ,depto , 
                                          casa,  monoblok,  barrio  ,entre1  ,entre2,  localidad ,referencia , zona , motivo1 ,
                                          motivo2  ,motivodesc , color ,observa1 , observa2 , obrasocial ,opedesp ,movil , horadesp , 
                                          horasalbase , horallegdom  ,horasaldom ,horalleghosp  ,horasalhosp  ,horadisp ,
                                          destino  ,coseguro  ,impcoseguro , chofer , medico , enfermero , colormedico  ,tiporecibo ,
                                          nrorecibo , diagnostico , motanulacion , movil_2 , abierta  , ' '	, ' ' , ' ', ' ' , ' ' , reclamo_1, reclamo_2, reclamo_3 ,
                                          horalib										  
										  FROM atenciones_temp 	 
										  WHERE id =".$id_atencion);
	
	  if  (($CONSULTA_MOVIL['color'] == 4)||($CONSULTA_MOVIL['color'] == 7))
          {
			      $date = date("Y-m-d");
			 	  $AGREGA_OBS_FINAL	= mysql_query ("UPDATE atenciones SET obs_final = '".$obs_final."' , nrecibo = '".$nrecibo."' , fecha =  NOW() 
				                                    WHERE id =".$id_atencion); 
          }else {
  		 	      $AGREGA_OBS_FINAL	= mysql_query ("UPDATE atenciones SET obs_final = '".$obs_final."' , nrecibo = '".$nrecibo."'
			                                        WHERE id =".$id_atencion);
				}
		  
	  $DELETE_ATENCION_TEMP = mysql_query (" 
										  DELETE FROM atenciones_temp
										  WHERE  id =".$id_atencion);
	  //$salida = $UPDATE_ATENCION.'<br>'.$UPDATE_MOVIL_DISP.'<br>'.$INSERT_ATENCION.'<br>'.$DELETE_ATENCION_TEMP;								  
	  //$salida = $id_atencion.'-'.$destino.'-'.$diagnostico.'-'.$color.'-'.$coseg_si_chek.'-'.$coseg_no_chek.'-'.$valor_coseg;  
      //$salida = $UPDATE_ATENCION;
	  
	    # UPDATE & INSERT DE CLIENTES NO APDRONADOS EN EL CIERRE

		if ($_bandera_nosocio1== 1) { $existe_socio1 = mysql_query ("select * from clientes_nopadron where idatencion = ".$id_atencion." and idnopadron= '".$_nosocioid1."'"); if (mysql_affected_rows() == 0) { $insert_nosocio1 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni , cod_destino , cod_diagnostico ) values ("'.$id_atencion.'" , "'.$_nosocio1.'" , "'.$_noedad1.'" , "'.$_nosexo1.'" , "'.$_noiden1.'" , "'.$_nodocum1.'" , "'.$_destino1.'" , "'.$_diagno1.'" ) '); } else { $update_nosocio = mysql_query ('update clientes_nopadron set nombre = "'.$_nosocio1.'" , edad = "'.$_noedad1.'" , sexo = "'.$_nosexo1.'" , os = "'.$_noiden1.'" , dni = "'.$_nodocum1.'" , cod_destino = "'.$_destino1.'" , cod_diagnostico = "'.$_diagno1.'" where idatencion = '.$id_atencion.' and idnopadron= '.$_nosocioid1); } } 
		if ($_bandera_nosocio2== 1) { $existe_socio2 = mysql_query ("select * from clientes_nopadron where idatencion = ".$id_atencion." and idnopadron= '".$_nosocioid2."'"); if (mysql_affected_rows() == 0) { $insert_nosocio2 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni , cod_destino , cod_diagnostico ) values ("'.$id_atencion.'" , "'.$_nosocio2.'" , "'.$_noedad2.'" , "'.$_nosexo2.'" , "'.$_noiden2.'" , "'.$_nodocum2.'" , "'.$_destino2.'" , "'.$_diagno2.'" ) '); } else { $update_nosocio = mysql_query ('update clientes_nopadron set nombre = "'.$_nosocio2.'" , edad = "'.$_noedad2.'" , sexo = "'.$_nosexo2.'" , os = "'.$_noiden2.'" , dni = "'.$_nodocum2.'" , cod_destino = "'.$_destino2.'" , cod_diagnostico = "'.$_diagno2.'" where idatencion = '.$id_atencion.' and idnopadron= '.$_nosocioid2); } } 
		if ($_bandera_nosocio3== 1) { $existe_socio3 = mysql_query ("select * from clientes_nopadron where idatencion = ".$id_atencion." and idnopadron= '".$_nosocioid3."'"); if (mysql_affected_rows() == 0) { $insert_nosocio3 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni , cod_destino , cod_diagnostico ) values ("'.$id_atencion.'" , "'.$_nosocio3.'" , "'.$_noedad3.'" , "'.$_nosexo3.'" , "'.$_noiden3.'" , "'.$_nodocum3.'" , "'.$_destino3.'" , "'.$_diagno3.'" ) '); } else { $update_nosocio = mysql_query ('update clientes_nopadron set nombre = "'.$_nosocio3.'" , edad = "'.$_noedad3.'" , sexo = "'.$_nosexo3.'" , os = "'.$_noiden3.'" , dni = "'.$_nodocum3.'" , cod_destino = "'.$_destino3.'" , cod_diagnostico = "'.$_diagno3.'" where idatencion = '.$id_atencion.' and idnopadron= '.$_nosocioid3); } } 
		if ($_bandera_nosocio4== 1) { $existe_socio4 = mysql_query ("select * from clientes_nopadron where idatencion = ".$id_atencion." and idnopadron= '".$_nosocioid4."'"); if (mysql_affected_rows() == 0) { $insert_nosocio4 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni , cod_destino , cod_diagnostico ) values ("'.$id_atencion.'" , "'.$_nosocio4.'" , "'.$_noedad4.'" , "'.$_nosexo4.'" , "'.$_noiden4.'" , "'.$_nodocum4.'" , "'.$_destino4.'" , "'.$_diagno4.'" ) '); } else { $update_nosocio = mysql_query ('update clientes_nopadron set nombre = "'.$_nosocio4.'" , edad = "'.$_noedad4.'" , sexo = "'.$_nosexo4.'" , os = "'.$_noiden4.'" , dni = "'.$_nodocum4.'" , cod_destino = "'.$_destino4.'" , cod_diagnostico = "'.$_diagno4.'" where idatencion = '.$id_atencion.' and idnopadron= '.$_nosocioid4); } } 
		if ($_bandera_nosocio5== 1) { $existe_socio5 = mysql_query ("select * from clientes_nopadron where idatencion = ".$id_atencion." and idnopadron= '".$_nosocioid5."'"); if (mysql_affected_rows() == 0) { $insert_nosocio5 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni , cod_destino , cod_diagnostico ) values ("'.$id_atencion.'" , "'.$_nosocio5.'" , "'.$_noedad5.'" , "'.$_nosexo5.'" , "'.$_noiden5.'" , "'.$_nodocum5.'" , "'.$_destino5.'" , "'.$_diagno5.'" ) '); } else { $update_nosocio = mysql_query ('update clientes_nopadron set nombre = "'.$_nosocio5.'" , edad = "'.$_noedad5.'" , sexo = "'.$_nosexo5.'" , os = "'.$_noiden5.'" , dni = "'.$_nodocum5.'" , cod_destino = "'.$_destino5.'" , cod_diagnostico = "'.$_diagno5.'" where idatencion = '.$id_atencion.' and idnopadron= '.$_nosocioid5); } } 
		if ($_bandera_nosocio6== 1) { $existe_socio6 = mysql_query ("select * from clientes_nopadron where idatencion = ".$id_atencion." and idnopadron= '".$_nosocioid6."'"); if (mysql_affected_rows() == 0) { $insert_nosocio6 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni , cod_destino , cod_diagnostico ) values ("'.$id_atencion.'" , "'.$_nosocio6.'" , "'.$_noedad6.'" , "'.$_nosexo6.'" , "'.$_noiden6.'" , "'.$_nodocum6.'" , "'.$_destino6.'" , "'.$_diagno6.'" ) '); } else { $update_nosocio = mysql_query ('update clientes_nopadron set nombre = "'.$_nosocio6.'" , edad = "'.$_noedad6.'" , sexo = "'.$_nosexo6.'" , os = "'.$_noiden6.'" , dni = "'.$_nodocum6.'" , cod_destino = "'.$_destino6.'" , cod_diagnostico = "'.$_diagno6.'" where idatencion = '.$id_atencion.' and idnopadron= '.$_nosocioid6); } } 
		if ($_bandera_nosocio7== 1) { $existe_socio7 = mysql_query ("select * from clientes_nopadron where idatencion = ".$id_atencion." and idnopadron= '".$_nosocioid7."'"); if (mysql_affected_rows() == 0) { $insert_nosocio7 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni , cod_destino , cod_diagnostico ) values ("'.$id_atencion.'" , "'.$_nosocio7.'" , "'.$_noedad7.'" , "'.$_nosexo7.'" , "'.$_noiden7.'" , "'.$_nodocum7.'" , "'.$_destino7.'" , "'.$_diagno7.'" ) '); } else { $update_nosocio = mysql_query ('update clientes_nopadron set nombre = "'.$_nosocio7.'" , edad = "'.$_noedad7.'" , sexo = "'.$_nosexo7.'" , os = "'.$_noiden7.'" , dni = "'.$_nodocum7.'" , cod_destino = "'.$_destino7.'" , cod_diagnostico = "'.$_diagno7.'" where idatencion = '.$id_atencion.' and idnopadron= '.$_nosocioid7); } } 
		if ($_bandera_nosocio8== 1) { $existe_socio8 = mysql_query ("select * from clientes_nopadron where idatencion = ".$id_atencion." and idnopadron= '".$_nosocioid8."'"); if (mysql_affected_rows() == 0) { $insert_nosocio8 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni , cod_destino , cod_diagnostico ) values ("'.$id_atencion.'" , "'.$_nosocio8.'" , "'.$_noedad8.'" , "'.$_nosexo8.'" , "'.$_noiden8.'" , "'.$_nodocum8.'" , "'.$_destino8.'" , "'.$_diagno8.'" ) '); } else { $update_nosocio = mysql_query ('update clientes_nopadron set nombre = "'.$_nosocio8.'" , edad = "'.$_noedad8.'" , sexo = "'.$_nosexo8.'" , os = "'.$_noiden8.'" , dni = "'.$_nodocum8.'" , cod_destino = "'.$_destino8.'" , cod_diagnostico = "'.$_diagno8.'" where idatencion = '.$id_atencion.' and idnopadron= '.$_nosocioid8); } } 
		if ($_bandera_nosocio9== 1) { $existe_socio9 = mysql_query ("select * from clientes_nopadron where idatencion = ".$id_atencion." and idnopadron= '".$_nosocioid9."'"); if (mysql_affected_rows() == 0) { $insert_nosocio9 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni , cod_destino , cod_diagnostico ) values ("'.$id_atencion.'" , "'.$_nosocio9.'" , "'.$_noedad9.'" , "'.$_nosexo9.'" , "'.$_noiden9.'" , "'.$_nodocum9.'" , "'.$_destino9.'" , "'.$_diagno9.'" ) '); } else { $update_nosocio = mysql_query ('update clientes_nopadron set nombre = "'.$_nosocio9.'" , edad = "'.$_noedad9.'" , sexo = "'.$_nosexo9.'" , os = "'.$_noiden9.'" , dni = "'.$_nodocum9.'" , cod_destino = "'.$_destino9.'" , cod_diagnostico = "'.$_diagno9.'" where idatencion = '.$id_atencion.' and idnopadron= '.$_nosocioid9); } } 
		if ($_bandera_nosocio10== 1) { $existe_socio10 = mysql_query ("select * from clientes_nopadron where idatencion = ".$id_atencion." and idnopadron= '".$_nosocioid10."'"); if (mysql_affected_rows() == 0) { $insert_nosocio10 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni , cod_destino , cod_diagnostico ) values ("'.$id_atencion.'" , "'.$_nosocio10.'" , "'.$_noedad10.'" , "'.$_nosexo10.'" , "'.$_noiden10.'" , "'.$_nodocum10.'" , "'.$_destino10.'" , "'.$_diagno10.'" ) '); } else { $update_nosocio = mysql_query ('update clientes_nopadron set nombre = "'.$_nosocio10.'" , edad = "'.$_noedad10.'" , sexo = "'.$_nosexo10.'" , os = "'.$_noiden10.'" , dni = "'.$_nodocum10.'" , cod_destino = "'.$_destino10.'" , cod_diagnostico = "'.$_diagno10.'" where idatencion = '.$id_atencion.' and idnopadron= '.$_nosocioid10); } } 
		if ($_bandera_nosocio11== 1) { $existe_socio11 = mysql_query ("select * from clientes_nopadron where idatencion = ".$id_atencion." and idnopadron= '".$_nosocioid11."'"); if (mysql_affected_rows() == 0) { $insert_nosocio11 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni , cod_destino , cod_diagnostico ) values ("'.$id_atencion.'" , "'.$_nosocio11.'" , "'.$_noedad11.'" , "'.$_nosexo11.'" , "'.$_noiden11.'" , "'.$_nodocum11.'" , "'.$_destino11.'" , "'.$_diagno11.'" ) '); } else { $update_nosocio = mysql_query ('update clientes_nopadron set nombre = "'.$_nosocio11.'" , edad = "'.$_noedad11.'" , sexo = "'.$_nosexo11.'" , os = "'.$_noiden11.'" , dni = "'.$_nodocum11.'" , cod_destino = "'.$_destino11.'" , cod_diagnostico = "'.$_diagno11.'" where idatencion = '.$id_atencion.' and idnopadron= '.$_nosocioid11); } } 
		if ($_bandera_nosocio12== 1) { $existe_socio12 = mysql_query ("select * from clientes_nopadron where idatencion = ".$id_atencion." and idnopadron= '".$_nosocioid12."'"); if (mysql_affected_rows() == 0) { $insert_nosocio12 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni , cod_destino , cod_diagnostico ) values ("'.$id_atencion.'" , "'.$_nosocio12.'" , "'.$_noedad12.'" , "'.$_nosexo12.'" , "'.$_noiden12.'" , "'.$_nodocum12.'" , "'.$_destino12.'" , "'.$_diagno12.'" ) '); } else { $update_nosocio = mysql_query ('update clientes_nopadron set nombre = "'.$_nosocio12.'" , edad = "'.$_noedad12.'" , sexo = "'.$_nosexo12.'" , os = "'.$_noiden12.'" , dni = "'.$_nodocum12.'" , cod_destino = "'.$_destino12.'" , cod_diagnostico = "'.$_diagno12.'" where idatencion = '.$id_atencion.' and idnopadron= '.$_nosocioid12); } } 
		if ($_bandera_nosocio13== 1) { $existe_socio13 = mysql_query ("select * from clientes_nopadron where idatencion = ".$id_atencion." and idnopadron= '".$_nosocioid13."'"); if (mysql_affected_rows() == 0) { $insert_nosocio13 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni , cod_destino , cod_diagnostico ) values ("'.$id_atencion.'" , "'.$_nosocio13.'" , "'.$_noedad13.'" , "'.$_nosexo13.'" , "'.$_noiden13.'" , "'.$_nodocum13.'" , "'.$_destino13.'" , "'.$_diagno13.'" ) '); } else { $update_nosocio = mysql_query ('update clientes_nopadron set nombre = "'.$_nosocio13.'" , edad = "'.$_noedad13.'" , sexo = "'.$_nosexo13.'" , os = "'.$_noiden13.'" , dni = "'.$_nodocum13.'" , cod_destino = "'.$_destino13.'" , cod_diagnostico = "'.$_diagno13.'" where idatencion = '.$id_atencion.' and idnopadron= '.$_nosocioid13); } } 
		if ($_bandera_nosocio14== 1) { $existe_socio14 = mysql_query ("select * from clientes_nopadron where idatencion = ".$id_atencion." and idnopadron= '".$_nosocioid14."'"); if (mysql_affected_rows() == 0) { $insert_nosocio14 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni , cod_destino , cod_diagnostico ) values ("'.$id_atencion.'" , "'.$_nosocio14.'" , "'.$_noedad14.'" , "'.$_nosexo14.'" , "'.$_noiden14.'" , "'.$_nodocum14.'" , "'.$_destino14.'" , "'.$_diagno14.'" ) '); } else { $update_nosocio = mysql_query ('update clientes_nopadron set nombre = "'.$_nosocio14.'" , edad = "'.$_noedad14.'" , sexo = "'.$_nosexo14.'" , os = "'.$_noiden14.'" , dni = "'.$_nodocum14.'" , cod_destino = "'.$_destino14.'" , cod_diagnostico = "'.$_diagno14.'" where idatencion = '.$id_atencion.' and idnopadron= '.$_nosocioid14); } } 
		if ($_bandera_nosocio15== 1) { $existe_socio15 = mysql_query ("select * from clientes_nopadron where idatencion = ".$id_atencion." and idnopadron= '".$_nosocioid15."'"); if (mysql_affected_rows() == 0) { $insert_nosocio15 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni , cod_destino , cod_diagnostico ) values ("'.$id_atencion.'" , "'.$_nosocio15.'" , "'.$_noedad15.'" , "'.$_nosexo15.'" , "'.$_noiden15.'" , "'.$_nodocum15.'" , "'.$_destino15.'" , "'.$_diagno15.'" ) '); } else { $update_nosocio = mysql_query ('update clientes_nopadron set nombre = "'.$_nosocio15.'" , edad = "'.$_noedad15.'" , sexo = "'.$_nosexo15.'" , os = "'.$_noiden15.'" , dni = "'.$_nodocum15.'" , cod_destino = "'.$_destino15.'" , cod_diagnostico = "'.$_diagno15.'" where idatencion = '.$id_atencion.' and idnopadron= '.$_nosocioid15); } } 
		if ($_bandera_nosocio16== 1) { $existe_socio16 = mysql_query ("select * from clientes_nopadron where idatencion = ".$id_atencion." and idnopadron= '".$_nosocioid16."'"); if (mysql_affected_rows() == 0) { $insert_nosocio16 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni , cod_destino , cod_diagnostico ) values ("'.$id_atencion.'" , "'.$_nosocio16.'" , "'.$_noedad16.'" , "'.$_nosexo16.'" , "'.$_noiden16.'" , "'.$_nodocum16.'" , "'.$_destino16.'" , "'.$_diagno16.'" ) '); } else { $update_nosocio = mysql_query ('update clientes_nopadron set nombre = "'.$_nosocio16.'" , edad = "'.$_noedad16.'" , sexo = "'.$_nosexo16.'" , os = "'.$_noiden16.'" , dni = "'.$_nodocum16.'" , cod_destino = "'.$_destino16.'" , cod_diagnostico = "'.$_diagno16.'" where idatencion = '.$id_atencion.' and idnopadron= '.$_nosocioid16); } } 
		if ($_bandera_nosocio17== 1) { $existe_socio17 = mysql_query ("select * from clientes_nopadron where idatencion = ".$id_atencion." and idnopadron= '".$_nosocioid17."'"); if (mysql_affected_rows() == 0) { $insert_nosocio17 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni , cod_destino , cod_diagnostico ) values ("'.$id_atencion.'" , "'.$_nosocio17.'" , "'.$_noedad17.'" , "'.$_nosexo17.'" , "'.$_noiden17.'" , "'.$_nodocum17.'" , "'.$_destino17.'" , "'.$_diagno17.'" ) '); } else { $update_nosocio = mysql_query ('update clientes_nopadron set nombre = "'.$_nosocio17.'" , edad = "'.$_noedad17.'" , sexo = "'.$_nosexo17.'" , os = "'.$_noiden17.'" , dni = "'.$_nodocum17.'" , cod_destino = "'.$_destino17.'" , cod_diagnostico = "'.$_diagno17.'" where idatencion = '.$id_atencion.' and idnopadron= '.$_nosocioid17); } } 
		if ($_bandera_nosocio18== 1) { $existe_socio18 = mysql_query ("select * from clientes_nopadron where idatencion = ".$id_atencion." and idnopadron= '".$_nosocioid18."'"); if (mysql_affected_rows() == 0) { $insert_nosocio18 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni , cod_destino , cod_diagnostico ) values ("'.$id_atencion.'" , "'.$_nosocio18.'" , "'.$_noedad18.'" , "'.$_nosexo18.'" , "'.$_noiden18.'" , "'.$_nodocum18.'" , "'.$_destino18.'" , "'.$_diagno18.'" ) '); } else { $update_nosocio = mysql_query ('update clientes_nopadron set nombre = "'.$_nosocio18.'" , edad = "'.$_noedad18.'" , sexo = "'.$_nosexo18.'" , os = "'.$_noiden18.'" , dni = "'.$_nodocum18.'" , cod_destino = "'.$_destino18.'" , cod_diagnostico = "'.$_diagno18.'" where idatencion = '.$id_atencion.' and idnopadron= '.$_nosocioid18); } } 
		if ($_bandera_nosocio19== 1) { $existe_socio19 = mysql_query ("select * from clientes_nopadron where idatencion = ".$id_atencion." and idnopadron= '".$_nosocioid19."'"); if (mysql_affected_rows() == 0) { $insert_nosocio19 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni , cod_destino , cod_diagnostico ) values ("'.$id_atencion.'" , "'.$_nosocio19.'" , "'.$_noedad19.'" , "'.$_nosexo19.'" , "'.$_noiden19.'" , "'.$_nodocum19.'" , "'.$_destino19.'" , "'.$_diagno19.'" ) '); } else { $update_nosocio = mysql_query ('update clientes_nopadron set nombre = "'.$_nosocio19.'" , edad = "'.$_noedad19.'" , sexo = "'.$_nosexo19.'" , os = "'.$_noiden19.'" , dni = "'.$_nodocum19.'" , cod_destino = "'.$_destino19.'" , cod_diagnostico = "'.$_diagno19.'" where idatencion = '.$id_atencion.' and idnopadron= '.$_nosocioid19); } } 
		if ($_bandera_nosocio20== 1) { $existe_socio20 = mysql_query ("select * from clientes_nopadron where idatencion = ".$id_atencion." and idnopadron= '".$_nosocioid20."'"); if (mysql_affected_rows() == 0) { $insert_nosocio20 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni , cod_destino , cod_diagnostico ) values ("'.$id_atencion.'" , "'.$_nosocio20.'" , "'.$_noedad20.'" , "'.$_nosexo20.'" , "'.$_noiden20.'" , "'.$_nodocum20.'" , "'.$_destino20.'" , "'.$_diagno20.'" ) '); } else { $update_nosocio = mysql_query ('update clientes_nopadron set nombre = "'.$_nosocio20.'" , edad = "'.$_noedad20.'" , sexo = "'.$_nosexo20.'" , os = "'.$_noiden20.'" , dni = "'.$_nodocum20.'" , cod_destino = "'.$_destino20.'" , cod_diagnostico = "'.$_diagno20.'" where idatencion = '.$id_atencion.' and idnopadron= '.$_nosocioid20); } } 
		if ($_bandera_nosocio21== 1) { $existe_socio21 = mysql_query ("select * from clientes_nopadron where idatencion = ".$id_atencion." and idnopadron= '".$_nosocioid21."'"); if (mysql_affected_rows() == 0) { $insert_nosocio21 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni , cod_destino , cod_diagnostico ) values ("'.$id_atencion.'" , "'.$_nosocio21.'" , "'.$_noedad21.'" , "'.$_nosexo21.'" , "'.$_noiden21.'" , "'.$_nodocum21.'" , "'.$_destino21.'" , "'.$_diagno21.'" ) '); } else { $update_nosocio = mysql_query ('update clientes_nopadron set nombre = "'.$_nosocio21.'" , edad = "'.$_noedad21.'" , sexo = "'.$_nosexo21.'" , os = "'.$_noiden21.'" , dni = "'.$_nodocum21.'" , cod_destino = "'.$_destino21.'" , cod_diagnostico = "'.$_diagno21.'" where idatencion = '.$id_atencion.' and idnopadron= '.$_nosocioid21); } } 
		if ($_bandera_nosocio22== 1) { $existe_socio22 = mysql_query ("select * from clientes_nopadron where idatencion = ".$id_atencion." and idnopadron= '".$_nosocioid22."'"); if (mysql_affected_rows() == 0) { $insert_nosocio22 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni , cod_destino , cod_diagnostico ) values ("'.$id_atencion.'" , "'.$_nosocio22.'" , "'.$_noedad22.'" , "'.$_nosexo22.'" , "'.$_noiden22.'" , "'.$_nodocum22.'" , "'.$_destino22.'" , "'.$_diagno22.'" ) '); } else { $update_nosocio = mysql_query ('update clientes_nopadron set nombre = "'.$_nosocio22.'" , edad = "'.$_noedad22.'" , sexo = "'.$_nosexo22.'" , os = "'.$_noiden22.'" , dni = "'.$_nodocum22.'" , cod_destino = "'.$_destino22.'" , cod_diagnostico = "'.$_diagno22.'" where idatencion = '.$id_atencion.' and idnopadron= '.$_nosocioid22); } } 
		if ($_bandera_nosocio23== 1) { $existe_socio23 = mysql_query ("select * from clientes_nopadron where idatencion = ".$id_atencion." and idnopadron= '".$_nosocioid23."'"); if (mysql_affected_rows() == 0) { $insert_nosocio23 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni , cod_destino , cod_diagnostico ) values ("'.$id_atencion.'" , "'.$_nosocio23.'" , "'.$_noedad23.'" , "'.$_nosexo23.'" , "'.$_noiden23.'" , "'.$_nodocum23.'" , "'.$_destino23.'" , "'.$_diagno23.'" ) '); } else { $update_nosocio = mysql_query ('update clientes_nopadron set nombre = "'.$_nosocio23.'" , edad = "'.$_noedad23.'" , sexo = "'.$_nosexo23.'" , os = "'.$_noiden23.'" , dni = "'.$_nodocum23.'" , cod_destino = "'.$_destino23.'" , cod_diagnostico = "'.$_diagno23.'" where idatencion = '.$id_atencion.' and idnopadron= '.$_nosocioid23); } } 
		if ($_bandera_nosocio24== 1) { $existe_socio24 = mysql_query ("select * from clientes_nopadron where idatencion = ".$id_atencion." and idnopadron= '".$_nosocioid24."'"); if (mysql_affected_rows() == 0) { $insert_nosocio24 = mysql_query ('insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni , cod_destino , cod_diagnostico ) values ("'.$id_atencion.'" , "'.$_nosocio24.'" , "'.$_noedad24.'" , "'.$_nosexo24.'" , "'.$_noiden24.'" , "'.$_nodocum24.'" , "'.$_destino24.'" , "'.$_diagno24.'" ) '); } else { $update_nosocio = mysql_query ('update clientes_nopadron set nombre = "'.$_nosocio24.'" , edad = "'.$_noedad24.'" , sexo = "'.$_nosexo24.'" , os = "'.$_noiden24.'" , dni = "'.$_nodocum24.'" , cod_destino = "'.$_destino24.'" , cod_diagnostico = "'.$_diagno24.'" where idatencion = '.$id_atencion.' and idnopadron= '.$_nosocioid24); } } 

	  $salida='';
	  
	  $CONT_CLI_NO_APADRONADOS = mysql_fetch_array( mysql_query (" 
																	SELECT count( * ) as CANTIDAD
																	FROM clientes_nopadron
																	WHERE idatencion =".$id_atencion) ); 
 										  
	  $UPDATE_CLI_ADI =mysql_query ("update atenciones SET cnadicionales = ".$CONT_CLI_NO_APADRONADOS['CANTIDAD']." 
	                                    where id = ".$id_atencion);		
										
   }


   
   
   //$salida=$_catidad_vincu.'-'.$_nosocio3.'-'.$_noedad3.'-'.$_nosexo3.'-'.$_noiden3.'-'.$_nodocum3.'-'.$_nosocioid3;
   //$salida = $existe_socio3;
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("muestra_insert_cierre","innerHTML",$salida);
   return $respuesta;
}
$xajax->registerFunction("lista_planes");
$xajax->registerFunction("input_busca_plan");
$xajax->registerFunction("lista_diagnostico");
$xajax->registerFunction("input_busca_diagnostico");
$xajax->registerFunction("lista_destino");
$xajax->registerFunction("input_busca_destino");
$xajax->registerFunction("lista_color");
$xajax->registerFunction("input_busca_color");
$xajax->registerFunction("input_muestra_articulo");
$xajax->registerFunction("input_busca_x_articulo");
$xajax->registerFunction("input_busca_x_rubro");
$xajax->registerFunction("input_valor_coseguro");
$xajax->registerFunction("ejec");
$xajax->registerFunction("cierra_atencion");
$xajax->processRequests();

$html_salida = '
<html>
 <head>
    <script defer type="text/javascript" src="jsfunciones.js"></script>
	<style type="text/css">
	<!--
	.style1 {
	font-size: 24px;
	font-weight: bold;
	}
	.style2 {font-family: "Courier New"}
	-->
	</style>
  <script>
   function js_control_importe_coseg(importe) {
    if (importe == 0)
    {
	 alert("Importe incorrecto");
	 xajax_input_valor_coseguro(1);
	} 
   } 
   function load_func() {
   xajax_lista_planes(0);
   xajax_lista_diagnostico(-1);
   xajax_input_busca_plan(0);
   xajax_input_busca_diagnostico(0);
   xajax_lista_destino(0);
   xajax_input_busca_destino(0);   
   xajax_lista_color(0);
   xajax_input_busca_color(0);
   xajax_input_muestra_articulo(0,0,0);
   xajax_input_busca_x_articulo(0);
   xajax_input_busca_x_rubro(0);
   xajax_input_valor_coseguro(1);
   //xajax_ejec(0,0,0);
   }
   
  </script>
  <link href="estilos.css" rel="stylesheet" type="text/css" />
  <title>Emergencias</title>
   '.$xajax->printJavascript("xajax/").'
  </head>
  <body onload="load_func();" style="background-color:'.$body_color.'" class="style1 style2">
  <form name="formulario" id="formulario">
  <input type="hidden" value="'.$atencion_datos['movil'].'" id="movilhidden"><br>
  <table width="100%" border="0" >
   <tr>
    <td align="center">
	 LLAMADO 
	</td>
	<td>
	 PLAN
	</td>
   <tr>
   <tr>
    <td align="center">
	 <input name="legajo" type="text" disabled="disabled" value="'.$idemergencia_temp.'" size="10" /> 
	</td>
	<td>
  	 <input type="text" disabled="disabled" size=8 value="'.$plan['idplan'].'">
	 <input type="text" disabled="disabled" size=50  value="'.elimina_caracteres(htmlentities($plan['descplan'])).'">
	</td>
   <tr>
  </table>

  <table width="90%" border="0" style="background-color:#E5E5E5">
  <tr>
    <td colspan="3" align="center" style="background-color:#999999">Socio</td>
    <td width="4%">&nbsp;</td>
    <td width="5%" align="center" style="background-color:#999999">Edad</td>
    <td width="5%" align="center" style="background-color:#999999">Sexo</td>
    <td width="7%" >&nbsp;</td>
    <td width="20%" align="center" style="background-color:#999999">Identificacion</td>
    <td width="14%" align="center" style="background-color:#999999">Documento</td>
  </tr>
  <tr>
    <td width="%"><input  disabled="disabled" type="text" name="" value="'.elimina_caracteres(htmlentities($atencion_datos['socio'])).'" size="7%"/></td>
    <td width="2%"><input  disabled="disabled" type="text" name="" value="'.elimina_caracteres(htmlentities($atencion_datos['tiposocio'])).'" size="2%"/></td>
    <td width="10%"><input  disabled="disabled" type="text" name="" value="'.elimina_caracteres(htmlentities($atencion_datos['nombre'])).'" size="70%"/></td>
    <td>&nbsp;</td>
    <td><input  type="text" disabled="disabled" name="" value="'.$atencion_datos['edad'].'" size="2%"/></td>
    <td><input  type="text" disabled="disabled" name="" value="'.$atencion_datos['sexo'].'" size="2%"/></td>
    <td>&nbsp;</td>
    <td><input  type="text" disabled="disabled" name="" value="'.elimina_caracteres(htmlentities($atencion_datos['identificacion'])).'" size="42%"/></td>
    <td><input  type="text" disabled="disabled" name="" value="'.$atencion_datos['documento'].'" size="38%"/></td>
  </tr>
</table>
<div class="barra_4" align="center">
<table width="91%" border="0" style="background-color:#E5E5E5">  
  '.$_FILAVINC.'
</table>
</div>
<table width="100%" border="0" >
 <tr>
  <td>DIAGNOSTICO</td><td>DESTINO</td><td>COLORES</td><td align="center">OBSERVACIONES FINALES</td>
 </tr>
 <tr>
  <td valign="top">
   <table>
    <tr>
    <td><div id="input_busca_diagnostico_div"></td><td></div><div id="lista_diagnostico"></div></td>
	</tr>
   </table>	
  </td>
  <td valign="top">
  <table>
   <tr>
   <td><div id="input_busca_destino_div"></div><td></td><td><div id="lista_destino"></div></td>
   </tr>
  </table>   
  </td>  
  <td valign="top">
   <table>
    <tr>
        <td><div id="input_busca_color_div"></div></td><td><div id="lista_color"></div></td>
    </tr>
   </table>
  </td>
  <td>
  <table align="center">
  	<tr>
     <td>
	   <textarea id="text_obs_final" name="text_obs_final" cols="35" rows="8"></textarea>
	 </td>
	</tr>
  </table>   
  </td>  
 </tr>
</table> 

<table border="0">
 <tr>
  <td>
  <div class="barra_2">
    <table border="0">
	 <tr style="background-color:#999999"><td>ARTICULO</td><td>RUBRO</td><td>DESCRIPCION</td><td>CANTIDAD</td><td>IMPACTAR</td></tr>	
	 <tr><td>
	     <div id="input_busca_x_articulo_div"></div></td><td><div id="input_busca_x_rubro_div"></div>
		 </td>
		 <td><div id="input_descarticulo_div"></div></td><td><input type="text" id="cantidad_rest" size=10 value=0></td>
		 <td ALIGN="CENTER"><input type="button" name="EJEC" VALUE="EJEC" onclick="check_ejec ( '.$idemergencia_temp.',
																								document.formulario.i_busca_x_rubro.value,
																								document.formulario.i_busca_x_articulo.value,
																								document.formulario.movilhidden.value,
																							    document.formulario.cantidad_rest.value)"></td>
     </tr>
	 <tr><td>&nbsp;</td></tr>
	 <tr>
	  <td colspan=5>
      <div id="muestra_ejec_div"></div>
	  </td>
 	 </tr>
	</table> 
	</div>
   </td>
   <td valign="top">
<table width="300" border="0"  align="right">
    <tr>
	  <td colspan=2 align="left">Coseguro</td>
	<tr>
    <tr>
      <td>
	    <label>
         <input type="radio" name="cosegurosi" value="SI" onclick="document.formulario.cosegurono.checked=false ;
                                                                   xajax_input_valor_coseguro(1); "/>
         Cobra 
		</label>
		<td>
		 <div id="input_coseguro_div"></div>
	    </td>
	  </td>
    </tr>
    <tr>
      <td colspan=2 align="left">
	    <label>
         <input type="radio" name="cosegurono" value="NO" onclick="document.formulario.cosegurosi.checked=false ;
		                                                           xajax_input_valor_coseguro(1); "/>
         No Cobra
		</label>
	  </td>
    </tr>
	<tr>
	 <td valig="">
     <br><br>  N° de Recibo <br>  <input type="text" id="nrecibo" />
     </td> 
	</tr>
   </table>   
   </td>
  </tr>   
</table>
<table border="0" width="100%">
<tr>
 <td width="80%" align="right">
  <input type="button" value="** OK **" onclick="check_cierra_atencion(
   '.$idemergencia_temp.',
   document.formulario.s_lista_destino.value,
   document.formulario.s_lista_diagnostico.value,
   document.formulario.s_lista_color.value,
   document.formulario.cosegurosi.checked,
   document.formulario.cosegurono.checked,
   document.formulario.valor_coseguro.value,
   document.formulario.text_obs_final.value ,
   
   '.$cantidad_vinculados.',
   
document.formulario.nosocio1.checked , document.formulario.no_socio_1.value , document.formulario.no_edad_1.value , document.formulario.no_sexo_1.value , document.formulario.no_iden_1.value , document.formulario.no_docum_1.value , document.formulario.destino_1.value , document.formulario.diagno_1.value , 
document.formulario.nosocio2.checked , document.formulario.no_socio_2.value , document.formulario.no_edad_2.value , document.formulario.no_sexo_2.value , document.formulario.no_iden_2.value , document.formulario.no_docum_2.value , document.formulario.destino_2.value , document.formulario.diagno_2.value , 
document.formulario.nosocio3.checked , document.formulario.no_socio_3.value , document.formulario.no_edad_3.value , document.formulario.no_sexo_3.value , document.formulario.no_iden_3.value , document.formulario.no_docum_3.value , document.formulario.destino_3.value , document.formulario.diagno_3.value , 
document.formulario.nosocio4.checked , document.formulario.no_socio_4.value , document.formulario.no_edad_4.value , document.formulario.no_sexo_4.value , document.formulario.no_iden_4.value , document.formulario.no_docum_4.value , document.formulario.destino_4.value , document.formulario.diagno_4.value , 
document.formulario.nosocio5.checked , document.formulario.no_socio_5.value , document.formulario.no_edad_5.value , document.formulario.no_sexo_5.value , document.formulario.no_iden_5.value , document.formulario.no_docum_5.value , document.formulario.destino_5.value , document.formulario.diagno_5.value , 
document.formulario.nosocio6.checked , document.formulario.no_socio_6.value , document.formulario.no_edad_6.value , document.formulario.no_sexo_6.value , document.formulario.no_iden_6.value , document.formulario.no_docum_6.value , document.formulario.destino_6.value , document.formulario.diagno_6.value , 
document.formulario.nosocio7.checked , document.formulario.no_socio_7.value , document.formulario.no_edad_7.value , document.formulario.no_sexo_7.value , document.formulario.no_iden_7.value , document.formulario.no_docum_7.value , document.formulario.destino_7.value , document.formulario.diagno_7.value , 
document.formulario.nosocio8.checked , document.formulario.no_socio_8.value , document.formulario.no_edad_8.value , document.formulario.no_sexo_8.value , document.formulario.no_iden_8.value , document.formulario.no_docum_8.value , document.formulario.destino_8.value , document.formulario.diagno_8.value , 
document.formulario.nosocio9.checked , document.formulario.no_socio_9.value , document.formulario.no_edad_9.value , document.formulario.no_sexo_9.value , document.formulario.no_iden_9.value , document.formulario.no_docum_9.value , document.formulario.destino_9.value , document.formulario.diagno_9.value , 
document.formulario.nosocio10.checked , document.formulario.no_socio_10.value , document.formulario.no_edad_10.value , document.formulario.no_sexo_10.value , document.formulario.no_iden_10.value , document.formulario.no_docum_10.value , document.formulario.destino_10.value , document.formulario.diagno_10.value , 
document.formulario.nosocio11.checked , document.formulario.no_socio_11.value , document.formulario.no_edad_11.value , document.formulario.no_sexo_11.value , document.formulario.no_iden_11.value , document.formulario.no_docum_11.value , document.formulario.destino_11.value , document.formulario.diagno_11.value , 
document.formulario.nosocio12.checked , document.formulario.no_socio_12.value , document.formulario.no_edad_12.value , document.formulario.no_sexo_12.value , document.formulario.no_iden_12.value , document.formulario.no_docum_12.value , document.formulario.destino_12.value , document.formulario.diagno_12.value , 
document.formulario.nosocio13.checked , document.formulario.no_socio_13.value , document.formulario.no_edad_13.value , document.formulario.no_sexo_13.value , document.formulario.no_iden_13.value , document.formulario.no_docum_13.value , document.formulario.destino_13.value , document.formulario.diagno_13.value , 
document.formulario.nosocio14.checked , document.formulario.no_socio_14.value , document.formulario.no_edad_14.value , document.formulario.no_sexo_14.value , document.formulario.no_iden_14.value , document.formulario.no_docum_14.value , document.formulario.destino_14.value , document.formulario.diagno_14.value , 
document.formulario.nosocio15.checked , document.formulario.no_socio_15.value , document.formulario.no_edad_15.value , document.formulario.no_sexo_15.value , document.formulario.no_iden_15.value , document.formulario.no_docum_15.value , document.formulario.destino_15.value , document.formulario.diagno_15.value , 
document.formulario.nosocio16.checked , document.formulario.no_socio_16.value , document.formulario.no_edad_16.value , document.formulario.no_sexo_16.value , document.formulario.no_iden_16.value , document.formulario.no_docum_16.value , document.formulario.destino_16.value , document.formulario.diagno_16.value , 
document.formulario.nosocio17.checked , document.formulario.no_socio_17.value , document.formulario.no_edad_17.value , document.formulario.no_sexo_17.value , document.formulario.no_iden_17.value , document.formulario.no_docum_17.value , document.formulario.destino_17.value , document.formulario.diagno_17.value , 
document.formulario.nosocio18.checked , document.formulario.no_socio_18.value , document.formulario.no_edad_18.value , document.formulario.no_sexo_18.value , document.formulario.no_iden_18.value , document.formulario.no_docum_18.value , document.formulario.destino_18.value , document.formulario.diagno_18.value , 
document.formulario.nosocio19.checked , document.formulario.no_socio_19.value , document.formulario.no_edad_19.value , document.formulario.no_sexo_19.value , document.formulario.no_iden_19.value , document.formulario.no_docum_19.value , document.formulario.destino_19.value , document.formulario.diagno_19.value , 
document.formulario.nosocio20.checked , document.formulario.no_socio_20.value , document.formulario.no_edad_20.value , document.formulario.no_sexo_20.value , document.formulario.no_iden_20.value , document.formulario.no_docum_20.value , document.formulario.destino_20.value , document.formulario.diagno_20.value , 
document.formulario.nosocio21.checked , document.formulario.no_socio_21.value , document.formulario.no_edad_21.value , document.formulario.no_sexo_21.value , document.formulario.no_iden_21.value , document.formulario.no_docum_21.value , document.formulario.destino_21.value , document.formulario.diagno_21.value , 
document.formulario.nosocio22.checked , document.formulario.no_socio_22.value , document.formulario.no_edad_22.value , document.formulario.no_sexo_22.value , document.formulario.no_iden_22.value , document.formulario.no_docum_22.value , document.formulario.destino_22.value , document.formulario.diagno_22.value , 
document.formulario.nosocio23.checked , document.formulario.no_socio_23.value , document.formulario.no_edad_23.value , document.formulario.no_sexo_23.value , document.formulario.no_iden_23.value , document.formulario.no_docum_23.value , document.formulario.destino_23.value , document.formulario.diagno_23.value , 
document.formulario.nosocio24.checked , document.formulario.no_socio_24.value , document.formulario.no_edad_24.value , document.formulario.no_sexo_24.value , document.formulario.no_iden_24.value , document.formulario.no_docum_24.value , document.formulario.destino_24.value , document.formulario.diagno_24.value , 
   
document.formulario.nosocioid1.value ,document.formulario.nosocioid2.value ,document.formulario.nosocioid3.value ,document.formulario.nosocioid4.value ,
document.formulario.nosocioid5.value ,document.formulario.nosocioid6.value ,document.formulario.nosocioid7.value ,document.formulario.nosocioid8.value ,
document.formulario.nosocioid9.value ,document.formulario.nosocioid10.value ,document.formulario.nosocioid11.value ,document.formulario.nosocioid12.value ,
document.formulario.nosocioid13.value ,document.formulario.nosocioid14.value ,document.formulario.nosocioid15.value ,document.formulario.nosocioid16.value ,
document.formulario.nosocioid17.value ,document.formulario.nosocioid18.value ,document.formulario.nosocioid19.value ,document.formulario.nosocioid20.value ,
document.formulario.nosocioid21.value ,document.formulario.nosocioid22.value ,document.formulario.nosocioid23.value ,document.formulario.nosocioid24.value ,
 
document.formulario.nrecibo.value 
  );">
 </td>
</tr>
</table>
<div id="muestra_insert_cierre"></div> 
</form>
</body>
</html>
';

echo $html_salida; 

/*
"xajax_ejec ( '.$idemergencia_temp.',
																								document.formulario.i_busca_x_rubro.value,
																								document.formulario.i_busca_x_articulo.value,
																								document.formulario.movilhidden.value,
																							    document.formulario.cantidad_rest.value)"
*/
?>