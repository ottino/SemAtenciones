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

/*
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }
*/  
################### Conexion a la base de datos##########################
$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);

######################DEF FUNCIONES XAJAX########################
//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding("iso-8859-1");
// funciones para la libreria

function func_lista_anulaciones ($id_anu)
{
       $consulta_anus = mysql_query("SELECT * FROM anulacion");
	   $html_salida     ='<select name="list_anulaciones" 
	                              onchange="xajax_func_input_anus(document.formulario.list_anulaciones.value);">';
       if ($id_anu == 0)
         $html_salida.='<option value="0" selected="selected">ANULACIONES</option>';
       
	   while ($fila=mysql_fetch_array($consulta_anus))
             {
			   if ($id_anu == $fila['idanulacion'])
			   {
                $html_salida.='<option selected="selected" value="'.$fila['idanulacion'].'" />'.elimina_caracteres(htmlentities($fila['descanulacion'])).'</option>';    
               }
			   else        
			    {
			     $html_salida.='<option value="'.$fila['idanulacion'].'" />'.elimina_caracteres(htmlentities($fila['descanulacion'])).'</option>'; 
				}
			 }
        			 
  	   $html_salida.='</select>'; 

	 
   $salida = $html_salida;
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("s_lista_anu","innerHTML",$salida);
   return $respuesta;
}
function func_input_anus ($id_anu)
{
   $html_salida = '<input id="i_busca_anu" size="7" type="text" value="'.$id_anu.'" 
                    onKeyUp="xajax_func_lista_anulaciones(document.formulario.i_busca_anu.value);">';
   $salida = $html_salida;
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("i_lista_anu","innerHTML",$salida);
   return $respuesta;
}

function anula_atencion ($id_atencion,$cod_anulacion ,$obs)
{
	  global $G_legajo;
	  $usuario = $G_legajo;
	  $hora = date("H:i:s");
	  $_fecha_= date("Y.m.d");
	  $INSERT_ATENCION =mysql_query (" 
										  INSERT INTO atenciones
										  SELECT 
                                          id  ,'".$_fecha_."' , telefono  , plan , operec , horallam  , socio , integrante , nombre , 
										  tiposocio  ,edad  ,sexo  ,identificacion,  documento , calle ,numero , piso  ,depto , 
                                          casa,  monoblok,  barrio  ,entre1  ,entre2,  localidad ,referencia , zona , motivo1 ,
                                          motivo2  ,motivodesc , color ,observa1 , observa2 , obrasocial ,'".$usuario."' ,movil , horadesp , 
                                          horasalbase , horallegdom  ,horasaldom ,horalleghosp  ,horasalhosp  ,horadisp ,
                                          destino  ,coseguro  ,impcoseguro , chofer , medico , enfermero , colormedico  ,tiporecibo ,
                                          nrorecibo , diagnostico , motanulacion , movil_2 , abierta  , ' '	, ' ' , ' ', ' ', ' ' , reclamo_1, reclamo_2, reclamo_3	,							  
										  '".$hora."' , fecha
										  FROM atenciones_temp 	 
										  WHERE id =".$id_atencion);
	  
	  $CONSULTA_MOVIL =mysql_fetch_array( mysql_query ("select * from atenciones_temp where id = ".$id_atencion) );	
	  
	  if ($CONSULTA_MOVIL['horalib'] == '00:00:00') 
	  {
	   $UPDATE_MOVIL_DISP =mysql_query ("update movildisponible SET disponible = 0 where idmovildisp = ".$CONSULTA_MOVIL['movil_2']);									  
      }
	  
      $AGREGA_OBS_FINAL	= mysql_query ("UPDATE atenciones SET motanulacion = '".$cod_anulacion."' ,
	                                                          obs_final    = '".$obs."'
	                                   WHERE id ='".$id_atencion."'");
	  
	  $DELETE_ATENCION_TEMP = mysql_query (" 
										  DELETE FROM atenciones_temp
										  WHERE  id =".$id_atencion);
		
										  
      $salida = $html_salida;
      $respuesta = new xajaxResponse();
      $respuesta->addAssign("i_lista_anu","innerHTML",$salida);
      return $respuesta;
}
//REGISTERRRRRRR
$xajax->registerFunction("func_lista_anulaciones");
$xajax->registerFunction("func_input_anus");
$xajax->registerFunction("anula_atencion");
//PETICIONNNNNN
$xajax->processRequests();


// ID DE EMERGENCIA PARA ANULAR
$_id_atencion= $_GET['id_atencion'];
$html_salida = '
<html>
<head>
<?xml version="1.0" encoding="iso-8859-1"?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script defer type="text/javascript" src="jsfunciones.js"></script>
<script language="JavaScript">
function on_Load()
{
 xajax_func_lista_anulaciones(0);
 xajax_func_input_anus(0);
}
</script>
<title>ANULACIONES</title>
'.$xajax->printJavascript("xajax/").'
</head>
<body style="background-color:'.$body_color.'" onLoad="on_Load();">
<form id="formulario" name="formulario">
 <table border="0">
  <tr>
   <td colspan="2">USTED ESTA POR ANULAR EMERGENCIA NUMERO: '.$_id_atencion.'</td>
  </tr>
  <tr>
   <td align="center">CODIGO</td>
   <td align="center">DESCRIPCION</td>
  </tr>
  <tr>
   <td><div id="i_lista_anu"></div></td>
   <td><div id="s_lista_anu"></div></td>
  </tr>
  <tr>
   <td colspan="2" align="center">OBSERVACIONES</td>
  </tr>
  <tr>
   <td colspan="2">
    <textarea cols="51" rows="7" id="text_obs_final"></textarea>
   </td>
  </tr>
  <tr>
   <td colspan="2" align="center"> <input type="button" value="CONFIRMAR" 
   onclick="check_anula('.$_id_atencion.' , document.formulario.list_anulaciones.value , document.formulario.text_obs_final.value);"> </td>
  </tr>
 </table>
</form>
</body>
</html>'; 
echo $html_salida;
?>