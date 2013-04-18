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

//REGISTERRRRRRR
$xajax->registerFunction("lista_diagnostico");
$xajax->registerFunction("input_busca_diagnostico");
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
   xajax_lista_diagnostico(0);
   xajax_input_busca_diagnostico(0);
}
</script>
<title>VER LISTA DE DIAGNOSTICOS</title>
'.$xajax->printJavascript("xajax/").'
</head>
<body style="background-color:'.$body_color.'" onLoad="on_Load();">
  <form name="formulario" id="formulario">
   <table>
    <tr>
	 <td align="center" colspan="2">VER LISTADO DE DIAGNOSTICOS</td>
	</tr>
    <tr>
    <td><div id="input_busca_diagnostico_div"></td><td></div><div id="lista_diagnostico"></div></td>
	</tr>
   </table>	
  </form> 
</body>
</html>'; 
echo $html_salida;
?>