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
//$idemergencia_temp = $_GET['id'];

//instanciamos el objeto de la clase xajax
$xajax = new xajax();
// funciones para la libreria

function lista_destino($iddestino , $reg)
{
     $consulta_destino = mysql_query ("SELECT *
                                      FROM destino ORDER BY destino ASC");  
 
	 $list='<select name="s_lista_destino'.$reg.'" onchange="xajax_input_busca_destino(document.formulario.s_lista_destino'.$reg.'.value , '.$reg.');">';

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
   $respuesta->addAssign("lista_destino".$reg,"innerHTML",$salida);
   
   return $respuesta;
}

function input_busca_destino($iddestino , $reg)
{
   $input='<input type="text" size="7" id="i_busca_destino'.$reg.'" value="'.$iddestino.'" 
           onKeyUp="xajax_lista_destino(document.formulario.i_busca_destino'.$reg.'.value , '.$reg.');">';
  
   $salida = $input;
   //$salida="asdasd";
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("input_busca_destino_div".$reg,"innerHTML",$salida);
   return $respuesta;
}

$xajax->registerFunction("lista_destino");
$xajax->registerFunction("input_busca_destino");

$xajax->processRequests();


for ($c=0 ; $c<10 ; $c++)
{
$divs .=' 
 <div id="input_busca_destino_div'.$c.'"></div>
 <div id="lista_destino'.$c.'"></div>&nbsp;';
 
$load_xajax_noa .='
   xajax_lista_destino(0 , '.$c.');
   xajax_input_busca_destino(0 , '.$c.'); 
';  
}

$html_salida = '
<html>
 <head>
    <script>
   function load_func() {
  // xajax_lista_destino(0 , 1);
  // xajax_input_busca_destino(0 , 1);   
   '.$load_xajax_noa.'
   }
   
  </script> 
  <title>Emergencias</title>
   '.$xajax->printJavascript("xajax/").'
 </head>
 <body onload="load_func();">
 <form id="formulario" name="formulario">
  '.$divs.'
 </form>
 </body>
</html>
';
echo $html_salida ;
 
