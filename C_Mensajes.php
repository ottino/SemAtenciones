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
                                    <!--       CALENDARIO    -->
 <!--Hoja de estilos del calendario -->
  <link rel="stylesheet" type="text/css" media="all" href="calendario/calendar-green.css" title="win2k-cold-1" />

  <!-- librería principal del calendario -->
 <script type="text/javascript" src="calendario/calendar.js"></script>

 <!-- librería para cargar el lenguaje deseado -->
  <script type="text/javascript" src="calendario/lang/calendar-es.js"></script>

  <!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
  <script type="text/javascript" src="calendario/calendar-setup.js"></script>

  <!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
  <script type="text/javascript" src="jsfunciones.js"></script>
  <!------------------------------------------------------------------------------------------------------->


<TITLE>C_Mensajes.php</TITLE>
</HEAD>
<script>
</script>
<body style="background-color:<?echo $body_color?>">
<BODY>


<?
echo titulo_encabezado ('Consulta de Mensajes' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$idmensaje = $_POST["pasasms"];
$vengo     = $_POST["vengo"];
$marcamensaje = $_POST["marcamensaje"];

?>

<br>

<?

//Ejecutamos la sentencia SQL
$sSQL="select * from mensajes where idmensaje = ".$idmensaje;
$result=mysql_query($sSQL);
$row=mysql_fetch_array($result);
mysql_free_result($result);

$nombrede = buscopersonal($row["de"]);
$nombrea  = buscopersonal($row["a"]);

 echo'<Table>';
 echo '<TR><TD>DE</TD><TD><input size= 50 type="text" disabled = "disabled" name= "de" value="'.$nombrede.'" ></TD></TR>';
 echo '<TR><TD>A</TD><TD><input size= 50 type="text" disabled = "disabled" name= "a" value="'.$nombrea.'" ></TD></TR>';
 echo '<TR><TD>Asunto</TD><TD><input size= 80 type="text" disabled = "disabled" name= "cla_asunto" value= "'.$row[asunto].'" ></TD></TR>';
 $texto = $row[texto];
 echo '<TR><TD>Mensaje</TD><TD><textarea disabled = "disabled" name="cla_observaciones" rows="10" cols="80">'.$texto.'</textarea></TD></TR>';

if ($row["a"] == $G_legajo && $row["leido"] < '1')
  {   $sSQL= "update mensajes set leido = '1' where idmensaje = ".$idmensaje;
     mysql_query($sSQL);
     insertolog($legajo, "C_Mensajes.php", "mensajes", "update", "1999-12-01", $sSQL);
   };


if ($vengo == '1')
     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="ABM_Mensajes.php">';
   else
  if ($vengo == '2')
     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="ABM_Mensajesarch.php">';
   else
     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="ABM_Mensajesbor.php">';

     echo '<input type="hidden" name= "pasaid" value  ="'.$pasaid.'" >';
     echo '<input type="hidden" name= "marca" value  ="1" >';
     echo '<input type="hidden" name= "marcamensaje" value  ="'.$marcamensaje.'" >';
     echo ' <td width="17" align="center" style="background-color:'.$body_color.'" style="CURSOR: hand" >
                     <label onclick="this.form.submit();">
                      <img align="middle" alt=\'Volver\' src="imagenes/Volver.ico" width="30" height="30"/>
                     </label></td>';
     echo '</FORM></TD>';

 ?>

    </span></th>
  </tr>
</table>
<br>
</select>

</div>
   </BODY>
</HTML>


