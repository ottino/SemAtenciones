<?
session_start();
######################INCLUDES################################
//archivo de configuracion
include_once ('config.php');

require_once("cookie.php");

//funciones propias
include ('funciones.php');

//incluímos la clase ajax
require ('xajax/xajax.inc.php');
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

################### Conexion a la base de datos##########################

$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

?>
<HTML>
<HEAD>

<TITLE>Cambio_clave.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>
<?
echo titulo_encabezado ('Cambio de Clave' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

//echo $destino;

$cookie = new cookieClass;
$G_usuario = $cookie->get("usuario");
$G_legajo  = $cookie->get("legajo");
$G_perfil  = $cookie->get("perfil");
$G_funcion = $cookie->get("funcion");

$legajos = $G_legajo;


echo '<FORM METHOD="POST"
ACTION="Cambio_clave2.php">';
//Creamos la sentencia SQL y la ejecutamos
$sSQL="SELECT * FROM legajos a, funciones b, perfiles c WHERE
a.funcion = b.idfunciones and a.perfil = c.idperfiles and legajo = ".$legajos;
//echo $sSQL;
$result=mysql_query($sSQL);

//Mostramos los registros en forma de menú desplegable
while ($row=mysql_fetch_array($result))
{
 echo'<Table>';
 echo '<TR><TD>Legajo</TD><TD><input disabled="disabled" size= 10 type = "text" value = "'.$row[legajo].'" /></TD></TR>';
 echo '<TR><TD>Apellido y Nombres</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_apeynomb" value = "'.$row[apeynomb].'" /></TD></TR>';
 echo '<TR><TD>Sexo</TD><TD><input disabled="disabled" size= 10 type = "text" name = "cla_sexo" value = "'.$row[sexo].'" /></TD></TR>';
 echo '<TR><TD>DNI</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_dni" value = "'.$row[dni].'" /></TD></TR>';
 echo '<TR><TD>CUIT/CUIL</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_cuit" value = "'.$row[cuit].'" /></TD></TR>';
 echo '<TR><TD>Fecha Nac.</TD><TD><input disabled="disabled" size= 10 type = "text" name = "cla_fecnac" value = "'.$row[fecnac].'" /></TD></TR>';
 echo '<TR><TD>Funcion</TD><TD><input disabled="disabled" size= 10 type = "text" name = "cla_funcion" value = "'.$row[funciones].'" /></TD></TR>';
 echo '<TR><TD>Matrícula</TD><TD><input disabled="disabled" size= 10 type = "text" name = "cla_matricula" value = "'.$row[matricula].'" /></TD></TR>';
 echo '<TR><TD>Perfiles</TD><TD><input disabled="disabled" size= 30 type = "text" name = "cla_perfiles" value = "'.$row[perfiles].'" /></TD></TR>';
 echo '<TR><TD>Clave Anterior</TD><TD><input size= 10 type = "password" name = "cla_clave" value = "" /></TD></TR>';
 echo '<TR><TD>Clave</TD><TD><input size= 10 type="password" name = "cla_clave1" /></TD></TR>';
 echo '<TR><TD>Reingrese</TD><TD><input size= 10 type="password" name = "cla_clave2" /></TD></TR>';
 echo '<input type="hidden" name= "leg" value="'.$row[legajo].'" >';
echo '</table>' ;
}
?>

    </span></th>
  </tr>
</table>
<br>
</select>

<INPUT name="SUBMIT" TYPE="submit" value="Cambiar"></FORM>
    <th width="769" scope="col">

</FORM>
</div>
   </BODY>
</HTML>