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

<TITLE>B_Legajos.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>
<?
echo titulo_encabezado ('Consulta Personal de Baja' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$legajos = $_POST["paslegajos"];
$vengo = $_POST["vengo"];
//echo $destino;

if ($vengo == 'A')
  echo '<FORM METHOD="POST" ACTION="ABM_Legajos.php">';
 else
  echo '<FORM METHOD="POST" ACTION="ABM_Legajosb.php">';

//Creamos la sentencia SQL y la ejecutamos
$sSQL="SELECT * FROM legajos a, funciones b, perfiles c WHERE
a.funcion = b.idfunciones and a.perfil = c.idperfiles and legajo = ".$legajos;
//echo $sSQL;
$result=mysql_query($sSQL);

//Mostramos los registros en forma de menú desplegable
while ($row=mysql_fetch_array($result))
{
 $fecnac = cambiarFormatoFecha($row["fecnac"]);
 $fecalta = cambiarFormatoFecha($row["fecalta1"]);
 $fecbaja = cambiarFormatoFecha($row["fecbaja1"]);

 echo'<Table>';
 echo '<TR><TD>Legajo</TD><TD><input disabled="disabled" size= 10 type = "text" value = "'.$row[legajo].'" /></TD></TR>';
 echo '<TR><TD>Apellido y Nombres</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_apeynomb" value = "'.$row[apeynomb].'" /></TD></TR>';
 echo '<TR><TD>Sexo</TD><TD><input disabled="disabled" size= 10 type = "text" name = "cla_sexo" value = "'.$row[sexo].'" /></TD></TR>';
 echo '<TR><TD>DNI</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_dni" value = "'.$row[dni].'" /></TD></TR>';
 echo '<TR><TD>CUIT/CUIL</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_cuit" value = "'.$row[cuit].'" /></TD></TR>';
 echo '<TR><TD>Fecha Nac.</TD><TD><input disabled="disabled" size= 10 type = "text" name = "cla_fecnac" value = "'.$fecnac.'" /></TD></TR>';
 echo '<TR><TD>Domicilio</TD><TD><textarea disabled="disabled" name="cla_filiacion" rows="10" cols="40">'.$row['filiacion'].'</textarea></TD></TR>';
 echo '<TR><TD>Fecha Alta</TD><TD><input disabled="disabled" size= 10 type = "text" name = "cla_fecnac" value = "'.$fecalta.'" /></TD></TR>';
 echo '<TR><TD>Funcion</TD><TD><input disabled="disabled" size= 10 type = "text" name = "cla_funcion" value = "'.$row[funciones].'" /></TD></TR>';
 echo '<TR><TD>Matrícula</TD><TD><input disabled="disabled" size= 10 type = "text" name = "cla_matricula" value = "'.$row[matricula].'" /></TD></TR>';
 echo '<TR><TD>Perfiles</TD><TD><input disabled="disabled" size= 30 type = "text" name = "cla_perfiles" value = "'.$row[perfiles].'" /></TD></TR>';
 echo '<input type="hidden" name= "leg" value="'.$row[legajo].'" >';
 echo '<TR><TD>Fecha Baja</TD><TD><input disabled="disabled" size= 10 type = "text" name = "cla_fecbaja" value = "'.$fecbaja.'" /></TD></TR>';
 echo '<TR><TD>Observaciones</TD><TD><textarea disabled="disabled" name="cla_observaciones" rows="5" cols="40">'.$row['observac'].'</textarea></TD></TR>';
 echo '</table>' ;
}
?>

    </span></th>
  </tr>
</table>
<br>
</select>

<INPUT name="SUBMIT" TYPE="submit" value="Volver"></FORM>
    <th width="769" scope="col">

</FORM>
</div>
   </BODY>
</HTML>