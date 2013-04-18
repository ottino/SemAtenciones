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


<TITLE>A_Mensajes.php</TITLE>
</HEAD>
<script>
</script>
<body style="background-color:<?echo $body_color?>">
<BODY>


<?
echo titulo_encabezado ('Alta de Mensajes' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

?>

<br>
<FORM METHOD="POST" name="formulario"
ACTION="A_Enviomensaje2.php">

<?

//Ejecutamos la sentencia SQL
$result=mysql_query("select * from legajos where perfil not in (5)");
$legajos= '<select name="legajo" style="background-color:'.$se_color.'"><option value="0">Personal</option>';
while ($row=mysql_fetch_array($result))
{
$legajos.='<option value="'.$row['legajo'].'">'.$row['apeynomb'].'</option>';
}
mysql_free_result($result);
$legajos.= '</select>';


$nombre = buscopersonal($G_legajo);

 echo'<Table>';
 echo '<TR><TD>DE</TD><TD><input type="text" disabled = "disabled" name= "idcliente" value="'.$G_legajo.'" ><input type="text" disabled = "disabled" name= "idcliente" value="'.$nombre.'" ></TD></TR>';
 echo '<TR><TD>A</TD><TD>'.$legajos.'</TD></TR>';
 echo '<TR><TD>Asunto</TD><TD><input size= 80 type="text" name= "cla_asunto" value=" " ></TD></TR>';
 echo '<TR><TD>Texto</TD><TD><textarea name="cla_texto" rows="10" cols="80"></textarea></TD></TR>';

?>
<td><INPUT TYPE="SUBMIT" value="Enviar"></td>
</FORM>

<FORM METHOD="POST" name="formulario"
ACTION="ABM_Mensajes.php">
<td><INPUT TYPE="SUBMIT" value="Volver"></td>
</FORM>

    </span></th>
  </tr>
</table>
<br>
</select>


</div>
   </BODY>
</HTML>


