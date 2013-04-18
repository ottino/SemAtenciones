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


<TITLE>M_Legajos.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>
<?
echo titulo_encabezado ('Modificación de Personal' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$legajos = $_POST["paslegajos"];
//echo $destino;


echo '<FORM METHOD="POST"
ACTION="M_Legajos2.php">';
//Creamos la sentencia SQL y la ejecutamos
$sSQL="Select * From legajos where legajo = ".$legajos;
$result=mysql_query($sSQL);
$idfuncion = mysql_fetch_array($result);

//Ejecutamos la sentencia SQL  BgColor="#d0d0d0"

$resultfun=mysql_query("SELECT * FROM funciones order by 1");
while ($rowfun=mysql_fetch_array($resultfun))
{ if ($rowfun['idfunciones'] == $idfuncion['funcion'])
     $funciones.='<option selected="selected" value="'.$rowfun['idfunciones'].'">'.$rowfun['funciones'].'</option>';
  else
     $funciones.='<option value="'.$rowfun['idfunciones'].'">'.$rowfun['funciones'].'</option>';
}
mysql_free_result($resultfun);

if ($G_perfil == '1' || $G_perfil == '3')
   $resultper=mysql_query("SELECT * FROM perfiles order by 1");
  else
   $resultper=mysql_query("SELECT * FROM perfiles where idperfiles not in (1,3) order by 1");

while ($rowper=mysql_fetch_array($resultper))
{ if ($rowper['idperfiles'] == $idfuncion['perfil'])
     $perfiles.='<option selected="selected" value="'.$rowper['idperfiles'].'">'.$rowper['perfiles'].'</option>';
  else
     $perfiles.='<option value="'.$rowper['idperfiles'].'">'.$rowper['perfiles'].'</option>';
}
mysql_free_result($resultper);

$resulsex=$idfuncion['sexo'];
if ($resulsex == 'M')
   $checksex = '    <label>
       <input type="radio" name="cla_sexo" value="M" checked="checked"/>
       Masculino</label>
     <label>
       <input type="radio" name="cla_sexo" value="F" />
       Femenino</label>';
  else
   $checksex = '    <label>
       <input type="radio" name="cla_sexo" value="M" />
       Masculino</label>
     <label>
       <input type="radio" name="cla_sexo" value="F" checked="checked"/>
       Femenino</label>';


//Creamos la sentencia SQL y la ejecutamos
$sSQL="Select * From legajos where legajo = ".$legajos;
$result=mysql_query($sSQL);



//Mostramos los registros en forma de menú desplegable
while ($row=mysql_fetch_array($result))
{
 echo'<Table>';
 //echo '<TR><TD>Legajo</TD><TD><input size= 10 type = "text" name = "cla_legajo" value = "'.$row[legajo].'" /></TD></TR>';

 echo '<input type="hidden" name= "leg" value="'.$row["legajo"].'" >';
 echo '<TR><TD>Apellido y Nombres</TD><TD><input size= 50 type = "text" name = "cla_apeynomb" value = "'.$row[apeynomb].'" /></TD></TR>';

 echo '<TR><TD>Sexo</TD><TD>'.$checksex.'</TD></TR>';
 echo '<TR><TD>DNI</TD><TD><input size= 50 type = "text" name = "cla_dni" value = "'.$row[dni].'" /></TD></TR>';
 echo '<TR><TD>CUIT/CUIL</TD><TD><input size= 50 type = "text" name = "cla_cuit" value = "'.$row[cuit].'" /></TD></TR>';
 echo '<TR><TD>Fecha Nac.</TD><TD>
      <input type="text" name="cla_fecnac" id="cla_fecha" size="10" value = "'.$row[fecnac].'" />
      <input type="button" id="lanzador" value="Seleccionar fecha" onclick="calendario();"/></TD></TR>';

 echo '<TR><TD>Domicilio</TD><TD><textarea name="cla_filiacion" rows="10" cols="40">'.$row[filiacion].'</textarea></TD></TR>';

 echo '<TR><TD>Funcion</TD><TD><select name="cla_funcion">'.$funciones.'</select></TD></TR>';
 echo '<TR><TD>Matrícula</TD><TD><input size= 10 type = "text" name = "cla_matricula" value = "'.$row[matricula].'" /></TD></TR>';
 echo '<TR><TD>Perfiles</TD><TD><select name="cla_perfil">'.$perfiles.'</select></TD></TR>';
 echo '</table>' ;
}
?>

    </span></th>
  </tr>
</table>
<br>
</select>

<INPUT name="SUBMIT" TYPE="submit" value="Actualizar"></FORM>
    <th width="769" scope="col">

</FORM>
</div>
   </BODY>
</HTML>