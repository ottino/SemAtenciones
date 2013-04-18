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


<TITLE>M_Moviles.php</TITLE>
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

$moviles = $_POST["pasmoviles"];
//echo $moviles;
echo '<FORM METHOD="POST"
ACTION="M_Moviles2.php">';
//Creamos la sentencia SQL y la ejecutamos
$sSQL="Select * From moviles where idmovil = ".$moviles;
$result=mysql_query($sSQL);


//Mostramos los registros en forma de menú desplegable
while ($row=mysql_fetch_array($result))
{
 echo'<Table>';
 echo '<input type="hidden" name= "mov" value="'.$row["idmovil"].'" >';
 echo '<TR><TD>Movil</TD><TD><input size= 50 type = "text" name = "cla_descmovil" value = "'.$row[descmovil].'" /></TD></TR>';
 echo '<TR><TD>Dominio</TD><TD><input size= 50 type = "text" name = "cla_dominio" value = "'.$row[dominio].'" /></TD></TR>';
 echo '<TR><TD>Marca</TD><TD><input size= 50 type = "text" name = "cla_marca" value = "'.$row[marca].'" /></TD></TR>';
 echo '<TR><TD>Modelo</TD><TD><input size= 50 type = "text" name = "cla_modelo" value = "'.$row[modelo].'" /></TD></TR>';
 echo '<TR><TD>Nro Motor</TD><TD><input size= 50 type = "text" name = "cla_nromotor" value = "'.$row[nromotor].'" /></TD></TR>';
 echo '<TR><TD>Nro Chasis</TD><TD><input size= 50 type = "text" name = "cla_nrochasis" value = "'.$row[nrochasis].'" /></TD></TR>';
 echo '<TR><TD>Fecha Transf.</TD><TD>
      <input type="text" name="cla_fecnac" id="cla_fecha" size="10" value = "'.$row[fectransf].'" />
      <input type="button" id="lanzador" value="Seleccionar fecha" onclick="calendario();"/></TD></TR>';
 echo '<TR><TD>Observaciones</TD><TD><input size= 50 type = "text" name = "cla_observaciones" value = "'.$row[observaciones].'" /></TD></TR>';
 echo '<TR><TD>Perfil Movil</TD><TD><input size= 50 type = "text" name = "cla_codperfil" value = "'.$row[codperfil].'" /></TD></TR>';
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

<FORM METHOD="POST" ACTION="ABM_Moviles.php">

<INPUT name="SUBMIT" TYPE="submit" value="Volver"></FORM>

   </BODY>
</HTML>