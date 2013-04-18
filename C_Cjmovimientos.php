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

<TITLE>C_Cjmovimientos.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>
<?
echo titulo_encabezado ('Consulta Movimientos de Caja' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$pasaid = $_POST["cla_pasaid"];
$cjmov = $_POST["cla_cjmov"];
//echo $pasaid;

echo '<FORM METHOD="POST" ACTION="A_Ctrlcaja.php">';

//Creamos la sentencia SQL y la ejecutamos
$sSQL="SELECT * FROM cjmovimientos, cjmotivos WHERE
cjmovmotivo = cjmotcodigo and idcjmov = ".$cjmov;
//echo $sSQL;
$result=mysql_query($sSQL);




//Mostramos los registros en forma de menú desplegable
while ($row=mysql_fetch_array($result))
{
 $fechad = cambiarFormatoFecha($row["cjmovfecha"]);
 $tipomov = $row["cjmovtipo"];

 if ($tipomov == 'B')
    $dtipomov = 'BANCO';

 if ($tipomov == 'C')
    $dtipomov = 'CHEQUE';

 if ($tipomov == 'E')
    $dtipomov = 'EFECTIVO';

 echo'<Table>';
 echo '<TR><TD>FECHA</TD><TD><input disabled="disabled" size= 10 type = "text" value = "'.$fechad.'" /></TD></TR>';
 echo '<TR><TD>SECTOR</TD><TD><input disabled="disabled" size= 15 type = "text" value = "'.$dtipomov.'" /></TD></TR>';
 echo '<TR><TD>MOTIVO</TD><TD><input disabled="disabled" size= 20 type = "text" value = "'.$row[cjmotdesc].'" /></TD></TR>';
 echo '<TR><TD>IMPORTE</TD><TD><input disabled="disabled" size= 10 type = "text" value = "'.$row[cjmovimporte].'" /></TD></TR>';
 echo '<TR><TD>NRO OPERAC</TD><TD><input disabled="disabled" size= 10 type = "text" value = "'.$row[cjmovnro].'" /></TD></TR>';
 echo '<TR><TD>OBSERVACION</TD><TD><input disabled="disabled" size= 50 type = "text" value = "'.$row[cjmovobs].'" /></TD></TR>';
 echo '<input type="hidden" name= "pasaid" value="'.$pasaid.'" >';
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