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

$id_ate = $_GET['id_atencion'];
$xajax = new xajax();

$consulta_llamdo =mysql_query ("SELECT * FROM llamados_ate WHERE idatencion = ".$id_ate);
$html_llamado = '
<table border="1" style="border:inherit" align="left">
<tr>
 <td>OPERADOR</td>
 <td>FECHA</td>
 <td>HORA</td>
 <td>OBS</td>
</tr>
';

 while ($llamados = mysql_fetch_array($consulta_llamdo))
 {

  $operador  =  buscopersonal($llamados['operador']);
  $fecha1    =  cambiarFormatoFecha($llamados['fecha_llam']);

   $html_llamado .= '
    <tr>
      <td>'.$operador.'</td>
      <td>'.$fecha1.'</td>
      <td>'.$llamados['hora_llam'].'</td>
      <td>'.$llamados['obs'].'</td>
    </tr>
   ';
 }
$html_llamado .= '</table>';


// Datos de a quien llamaron
$consulta_atencion = mysql_query("select * from atenciones_temp where id=".$id_ate);
$atencion_datos = mysql_fetch_array($consulta_atencion);

function func_ingresa_llamado ($id_ate, $obs)
{
   global $G_legajo; 
   $html_llamado = '<table border="1">';
   
   $insert =mysql_query( 'INSERT INTO llamados_ate (operador,fecha_llam,hora_llam,obs,idatencion)
                                values ( '.$G_legajo.',
                                        \''.date("Y.m.d").'\',
                                        \''.date("H:i:s").'\',
                                        \''.$obs.'\',
                                        \''.$id_ate.'\')');
  
    $consulta_llamdo =mysql_query ("SELECT * FROM llamados_ate WHERE idatencion = ".$id_ate);

     while ($llamados = mysql_fetch_array($consulta_llamdo))
        {
                $html_llamado .= '
                    <tr>
                        <td>'.$llamados['operador'].'</td>
                        <td>'.$llamados['fecha_llam'].'</td>
                        <td>'.$llamados['hora_llam'].'</td>
                        <td>'.$llamados['obs'].'</td>
                    </tr>
                ';
        }
        
   $html_llamado .='</table>';     
   
   $respuesta = new xajaxResponse();
   $respuesta->addAssign("i_lista_llam","innerHTML",$html_llamado);
   return $respuesta;
}


$xajax->registerFunction("func_ingresa_llamado");
$xajax->processRequests();


$html_salida = '
<html>
    <head>
        <?xml version="1.0" encoding="iso-8859-1"?>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <script defer type="text/javascript" src="jsfunciones.js"></script>
        '.$xajax->printJavascript("xajax/").'
        <title>LLAMADOS</title>
    </head>

    <body>
        <form id="formulario" name="formulario">
        
            <table border="0">
                <tr>
                 <td>LLAMADOS A : '.$atencion_datos['nombre'].' ( '.$id_ate.' )</td>
                </tr>

                <tr>
                 <td colspan="2" align="center">OBSERVACIONES</td>
                </tr>
                
                <tr>
                 <td colspan="2">
                  <textarea cols="51" rows="7" id="text_obs"></textarea>
                 </td>
                </tr>
                
                <tr>
                 <td colspan="2" align="center"> 
                 <input type="button" value="CONFIRMAR"
                 onclick="xajax_func_ingresa_llamado(
                                                     '.$id_ate.', 
                                                     document.formulario.text_obs.value
                                                     );
                          window.close();">
                 </td>
                </tr>  
               
            </table>
            '.$html_llamado.'
        </form>
    </body>
  </html>';


echo $html_salida;

?>