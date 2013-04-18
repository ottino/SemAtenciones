<?
session_start();
######################INCLUDES################################
//archivo de configuracion
include_once ('config.php');

//funciones propias
include ('funciones.php');

//incluímos la clase ajax
require ('xajax/xajax.inc.php');
require_once("cookie.php");
require_once("config.php");
$cookie = new cookieClass;
$G_usuario = $cookie->get("usuario");
$G_legajo  = $cookie->get("legajo");
$G_perfil  = $cookie->get("perfil");
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

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


<TITLE>A_Legajos.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>


<?
echo titulo_encabezado ('Alta de Personal' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

//Ejecutamos la sentencia SQL  BgColor="#d0d0d0"
$result=mysql_query("SELECT * FROM funciones order by 1");
while ($row=mysql_fetch_array($result))
{
$funciones.='<option value="'.$row['idfunciones'].'">'.$row['funciones'].'</option>';
}
mysql_free_result($result);


if ($G_perfil == '1' || $G_perfil == '3')
   $result=mysql_query("SELECT * FROM perfiles order by 1");
  else
   $result=mysql_query("SELECT * FROM perfiles where idperfiles not in (1,3) order by 1");

while ($row=mysql_fetch_array($result))
{
$perfiles.='<option value="'.$row['idperfiles'].'">'.$row['perfiles'].'</option>';
}
mysql_free_result($result);

?>


<br>
<FORM METHOD="POST" NAME="formulario3"
ACTION="A_Legajos2.php">

<?
 echo'<Table>';
 echo '<TR><TD>Legajo</TD><TD><input size= 10 type = "text" name = "cla_legajo" /></TD></TR>';
 echo '<TR><TD>Apellido y Nombres</TD><TD><input size= 50 type = "text" name = "cla_apeynomb" /></TD></TR>';
 echo '<TR><TD>Sexo</TD><TD>
     <label>
       <input type="radio" name="cla_sexo" value="M" />
       Masculino</label>
     <label>
       <input type="radio" name="cla_sexo" value="F" />
       Femenino</label></TD>
</TR>';
 echo '<TR><TD>DNI</TD><TD><input size= 50 type = "text" name = "cla_dni" /></TD></TR>';
 echo '<TR><TD>CUIT/CUIL</TD><TD><input size= 50 type = "text" name = "cla_cuit" /></TD></TR>';
 echo '<TR><TD>Fecha Alta</TD><TD>
      <input type="text" name="cla_fecalta" id="cla_fecha1" size="10" />
      <input type="button" id="lanzador1" value="Seleccionar fecha" onclick="calendario1();"/></TD></TR>';
 echo '<TR><TD>Fecha Nac.</TD><TD>
      <input type="text" name="cla_fecnac" id="cla_fecha" size="10" />
      <input type="button" id="lanzador" value="Seleccionar fecha" onclick="calendario();"/></TD></TR>';
 echo '<TR><TD>Domicilio</TD><TD><textarea name="cla_filiacion" rows="10" cols="40"></textarea></TD></TR>';
 echo '<TR><TD>Funcion</TD><TD><select name="cla_funcion">'.$funciones.'</select></TD></TR>';
 echo '<TR><TD>Matrícula</TD><TD><input size= 10 type = "text" name = "cla_matricula" /></TD></TR>';
 echo '<TR><TD>Perfiles</TD><TD><select name="cla_perfil">'.$perfiles.'</select></TD></TR>';
 echo '</table>' ;
?>

<INPUT TYPE="SUBMIT" value="Insertar">

    </span></th>
  </tr>
</table>
<br>
</select>


</FORM>
</div>
   </BODY>
</HTML>


