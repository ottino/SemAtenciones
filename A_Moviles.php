<?
session_start();
######################INCLUDES################################
//archivo de configuracion
include_once ('config.php');

//funciones propias
include ('funciones.php');

//inclu�mos la clase ajax
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

  <!-- librer�a principal del calendario -->
 <script type="text/javascript" src="calendario/calendar.js"></script>

 <!-- librer�a para cargar el lenguaje deseado -->
  <script type="text/javascript" src="calendario/lang/calendar-es.js"></script>

  <!-- librer�a que declara la funci�n Calendar.setup, que ayuda a generar un calendario en unas pocas l�neas de c�digo -->
  <script type="text/javascript" src="calendario/calendar-setup.js"></script>

  <!-- librer�a que declara la funci�n Calendar.setup, que ayuda a generar un calendario en unas pocas l�neas de c�digo -->
  <script type="text/javascript" src="jsfunciones.js"></script>
  <!------------------------------------------------------------------------------------------------------->

<TITLE>A_Moviles.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>


<?
echo titulo_encabezado ('Alta de Moviles' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }
?>


<br>
<FORM METHOD="POST"
ACTION="A_Moviles2.php">

<?
 echo'<Table>';
 echo '<TR><TD>ID Movil</TD><TD><input size= 50 type = "text" name = "cla_idmovil" /></TD></TR>';
 echo '<TR><TD>Descripcion</TD><TD><input size= 50 type = "text" name = "cla_descmovil" /></TD></TR>';
 echo '<TR><TD>Dominio</TD><TD><input size= 50 type = "text" name = "cla_dominio" /></TD></TR>';
 echo '<TR><TD>Marca</TD><TD><input size= 50 type = "text" name = "cla_marca" /></TD></TR>';
 echo '<TR><TD>Modelo</TD><TD><input size= 50 type = "text" name = "cla_modelo" /></TD></TR>';
 echo '<TR><TD>Nro Motor</TD><TD><input size= 50 type = "text" name = "cla_nromotor" /></TD></TR>';
 echo '<TR><TD>Nro Chasis</TD><TD><input size= 50 type = "text" name = "cla_nrochasis" /></TD></TR>';
// echo '<TR><TD>Fec Transf</TD><TD><input size= 50 type = "text" name = "cla_fectransf" /></TD></TR>';
 echo '<TR><TD>Fecha Transf.</TD><TD>
      <input type="text" name="cla_fecnac" id="cla_fecha" size="10" />
      <input type="button" id="lanzador" value="Seleccionar fecha" onclick="calendario();"/></TD></TR>';
 echo '<TR><TD>Observaciones</TD><TD><input size= 50 type = "text" name = "cla_observaciones" /></TD></TR>';
 echo '<TR><TD>Perfil</TD><TD><input size= 50 type = "text" name = "cla_codperfil" /></TD></TR>';
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
<FORM METHOD="POST" ACTION="ABM_Moviles.php">

<INPUT name="SUBMIT" TYPE="submit" value="Volver"></FORM>


   </BODY>
</HTML>


