<?
session_start();
######################INCLUDES################################
//archivo de configuracion
include_once ('config.php');

//funciones propias
include ('funciones.php');

//incluímos la clase ajax
require ('xajax/xajax.inc.php');
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
require_once("cookie.php");
require_once("config.php");
$cookie = new cookieClass;
$G_usuario = $cookie->get("usuario");
$G_legajo  = $cookie->get("legajo");
$G_perfil  = $cookie->get("perfil");

################### Conexion a la base de datos##########################

$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
?>


<HTML>
<HEAD>
<TITLE>ABM_Mensajes.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>" style="font-size:<?echo $fontef?>">
<BODY>


<?
echo titulo_encabezado ('Mensajes internos' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$marcamensaje = $_POST["marcamensaje"];

if ($marcamensaje == 'R')
   {  $result=mysql_query("select * from mensajes where (a = '".$G_legajo."' or a = '999999') and
                           (borrar < 1 and archivar < 1) order by fechae desc");
      $se_mensajes = 'RECIBIDOS';
   }
   else
   {  $result=mysql_query("select * from mensajes where (de = '".$G_legajo."' or a = '999999') and
                           (borrar < 1 and archivar < 1) order by fechae desc");
      $se_mensajes = 'ENVIADOS';
   }

echo '<table ><tr><td>';
     echo '<td><FORM METHOD="POST" NAME="formulario3" ACTION="A_Enviomensaje.php">';
     echo ' <td><td width="40" align="center" style="background-color:'.$td_color.'" >
                         <label onclick="this.form.submit();" style="CURSOR: pointer" >
                          <img align="middle" alt=\'Nuevo Mensaje\' src="imagenes/mails.ico" width="50" height="40"/>
                         </label>
                       </td></td>';
     echo '</FORM></TD>';

     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="ABM_Mensajes.php">';
     echo '<input type="hidden" name= "marcamensaje" value  = "E" >';
     echo ' <td width="40" align="center" style="background-color:'.$td_color.'" >
                     <label onclick="this.form.submit();" style="CURSOR: pointer" >
                      <img align="middle" alt=\'Enviados\' src="imagenes/MAIL-OUT.ICO" width="50" height="50"/>
                     </label></td>';
     echo '</FORM></TD>';

     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="ABM_Mensajes.php">';
     echo '<input type="hidden" name= "marcamensaje" value  = "R" >';
     echo ' <td width="40" align="center" style="background-color:'.$td_color.'" >
                     <label onclick="this.form.submit();" style="CURSOR: pointer" >
                      <img align="middle" alt=\'Recibidos\' src="imagenes/MAIL-IN.ICO" width="50" height="50"/>
                     </label></td>';
     echo '</FORM></TD>';

     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="ABM_Mensajesarch.php">';
     echo '<input type="hidden" name= "marcamensaje" value  = "R" >';
     echo ' <td width="40" align="center" style="background-color:'.$td_color.'" >
                     <label onclick="this.form.submit();" style="CURSOR: pointer" >
                      <img align="middle" alt=\'Archivados\' src="imagenes/GUARDIAS.ICO" width="50" height="50"/>
                     </label></td>';
     echo '</FORM></TD>';

     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="ABM_Mensajesbor.php">';
     echo '<input type="hidden" name= "marcamensaje" value  = "R" >';
     echo ' <td width="40" align="center" style="background-color:'.$td_color.'" >
                     <label onclick="this.form.submit();" style="CURSOR: pointer" >
                      <img align="middle" alt=\'Eliminados\' src="imagenes/146.ICO" width="50" height="50"/>
                     </label></td>';
     echo '</FORM></TD>';

     echo'</table></table>';
echo'<table width="100%" border="1" align="left">
             <tr><th>'.$se_mensajes.'</th></TR><TR>
    <td width="100%" rowspan="1" valign="top"><div align="center">
      <table style="font-size:13" border = 1 cellspacing="1" width="100%" cellpadding="1" align="left" style="background-color:'.$td_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
          <tr style="font-size:'.$fontt.'; background-color:'.$td_color.'">
            <th>VER</th>
            <th>DESTINATARIO</th>
            <th>ASUNTO</th>
            <th>ENVIADO</th>
            <th>ARCH</th>
            <th>BORRAR</th>
        </td>';

//Mostramos los registros
while ($row=mysql_fetch_array($result))
{
  if ($marcamensaje == 'R')
     $nombre = buscopersonal($row["de"]);
    else
     $nombre = buscopersonal($row["a"]);

$idmensaje = $row["idmensaje"];

if ($row["leido"] < 1)
 {
  echo '<TR style="background-color:'.$td_color.'"><FORM METHOD="POST" NAME="formulario2" ACTION="C_Mensajes.php">';
  echo '<input type="hidden" name= "pasasms" value="'.$idmensaje.'" >';
  echo '<input type="hidden" name= "marcamensaje" value  = "'.$marcamensaje.'" >';
  echo '<input type="hidden" name= "vengo" value="1" >';
  echo ' <td width="17" align="center" style="background-color:'.$td_color.'" >
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Ver\' src="imagenes/Mail05a.ico" width="20" height="20"/>
                    </label>
                  </td>';
  echo '</FORM>';
 }
 else
 {
  echo '<TR style="background-color:'.$td_color.'"><FORM METHOD="POST" NAME="formulario2" ACTION="C_Mensajes.php">';
  echo '<input type="hidden" name= "pasasms" value="'.$idmensaje.'" >';
  echo '<input type="hidden" name= "marcamensaje" value  = "'.$marcamensaje.'" >';
  echo '<input type="hidden" name= "vengo" value="1" >';
  echo ' <td width="17" align="center" style="background-color:'.$td_color.'" >
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Ver\' src="imagenes/Mail05b.ico" width="20" height="20"/>
                    </label>
                  </td>';
  echo '</FORM>';
 }
echo '<td>'.$nombre.'</td>';
echo '<td>'.$row["asunto"].'</td>';
$fecha = cambiarFormatoFecha($row["fechae"]);
$hora  = cambiarFormatoHora($row["horae"]);
echo '<td>'.$fecha.'-'.$hora.'</td>';
echo '<FORM METHOD="POST" NAME="formulario3" ACTION="UP_Mensajes.php">';
echo '<input type="hidden" name= "pasmensaje" value="'.$idmensaje.'" >';
echo '<input type="hidden" name= "marcamensaje" value  = "'.$marcamensaje.'" >';
echo '<input type="hidden" name= "vengo" value="1A" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.'" >
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Archivar\' src="imagenes/782.ico" width="20" height="20"/>
                    </label>
                  </td>';
echo '</FORM>';

echo '<FORM METHOD="POST" NAME="formulario3" ACTION="UP_Mensajes.php">';
echo '<input type="hidden" name= "pasmensaje" value="'.$idmensaje.'" >';
echo '<input type="hidden" name= "marcamensaje" value  = "'.$marcamensaje.'" >';
echo '<input type="hidden" name= "vengo" value="1B" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.'" >
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Borrar\' src="imagenes/783.ico" width="20" height="20"/>
                    </label>
                  </td>';
echo '</FORM>';

}

mysql_free_result($result)


?>

</table></table>

</BODY>
</HTML>