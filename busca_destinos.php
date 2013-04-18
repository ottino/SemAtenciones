<?php
######################INCLUDES################################
//archivo de configuracion
include_once ('config.php');

//funciones propias
include ('funciones.php');

//incluímos la clase ajax
require ('xajax/xajax.inc.php');


################### Conexion a la base de datos##########################
$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);

######################DEF FUNCIONES XAJAX########################
//instanciamos el objeto de la clase xajax
$xajax = new xajax();
$xajax->setCharEncoding("iso-8859-1");
// funciones para la libreria

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


//REGISTERRRRRRR
$xajax->registerFunction("lista_destino");
$xajax->registerFunction("input_busca_destino");
//PETICIONNNNNN
$xajax->processRequests();


// ID DE EMERGENCIA PARA ANULAR
$html_salida = '
<html>
<head>
<?xml version="1.0" encoding="iso-8859-1"?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<script defer type="text/javascript" src="jsfunciones.js"></script>
<script language="JavaScript">
function on_Load()
{
   xajax_lista_destino(0);
   xajax_input_busca_destino(0);
}
</script>
<title>VER LISTA DE DESTINOS</title>
'.$xajax->printJavascript("xajax/").'
</head>
<body style="background-color:'.$body_color.'" onLoad="on_Load();">
  <form name="formulario" id="formulario">
   <table>
    <tr>
	 <td align="center" colspan="2">VER LISTADO DE DESTINOS</td>
	</tr>
    <tr>
    <td><div id="input_busca_destino_div"></td><td></div><div id="lista_destino"></div></td>
	</tr>
   </table>	
  </form> 
</body>
</html>'; 
echo $html_salida;
?>