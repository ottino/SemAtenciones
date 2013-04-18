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


<TITLE>M_Planes.php</TITLE>
</HEAD>
<script>
</script>
<body style="background-color:<?echo $body_color?>">
<BODY>


<?
echo titulo_encabezado ('Modificación de Planes' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$idplan = $_POST["pasaplan"];
//echo $idcontrato;

?>


<br>
<FORM METHOD="POST" name="formulario"
ACTION="M_Planes2.php">

<?



//Ejecutamos la sentencia SQL
$sSQL="Select * From planes where idplan = ".$idplan;
$result=mysql_query($sSQL);
$row=mysql_fetch_array($result);

$resultplan=mysql_query("SELECT * FROM tipoplan order by 1");
while ($rowplan=mysql_fetch_array($resultplan))
{ if ($rowplan['idtipoplan'] == $row['codigoplan'])
     $planes.='<option selected="selected" value="'.$rowplan['idtipoplan'].'">'.$rowplan['desctipoplan'].'</option>';
  else
     $planes.='<option value="'.$rowplan['idtipoplan'].'">'.$rowplan['desctipoplan'].'</option>';
}
mysql_free_result($resultplan);

$datos = $row[datos];

echo'<Table>';
echo '<TR><TD>ID Plan</TD><TD><input size= 6 type = "text" name = "idplan" value="'.$row[idplan].'"/></TD></TR>';
echo '<TR><TD>Descripción</TD><TD><input size= 50 type = "text" name = "descplan" value="'.$row[descplan].'"/></TD></TR>';
echo '<TR><TD>Tipo Plan</TD><TD><select name="codigoplan">'.$planes.'</select></TD></TR>';
echo '<TR><TD>Contacto</TD><TD><input size= 50 type = "text" name = "contacto" value="'.$row[contacto].'"/></TD></TR>';
echo '<TR><TD>Contacto</TD><TD><input size= 50 type = "text" name = "contacto1" value="'.$row[contacto1].'"/></TD></TR>';
echo '<TR><TD><input type="text" name="cla_fecha" id="cla_fecha" size="10" value="'.$row[fecalta].'"/></TD><TD><input type="button" id="lanzador" value="Fecha Alta" onclick="calendario();"/></td>';
echo '<TD>Imp.Unico/Anual</TD><TD><input size= 8 type = "text" name = "imp1" value="'.$row[imp1].'"/></TD>';
echo '<TD>Importe-1</TD><TD><input size= 8 type = "text" name = "imp2" value="'.$row[imp2].'"/></TD>';
echo '<TD>Importe-2</TD><TD><input size= 8 type = "text" name = "imp3" value="'.$row[imp3].'"/></TD>';
echo '<TD>Importe-3</TD><TD><input size= 8 type = "text" name = "imp4" value="'.$row[imp4].'"/></TD>';
echo '<TD>Importe-4</TD><TD><input size= 8 type = "text" name = "imp5" value="'.$row[imp5].'"/></TD></TR>';
echo '<TR><TD><input type="text" name="cla_fecha1" id="cla_fecha1" size="10" value="'.$row[fecbaja].'"/></TD><TD><input type="button" id="lanzador1" value="Fecha Baja" onclick="calendario1();"/></td>';

echo '<TD>Importe-5</TD><TD><input size= 8 type = "text" name = "imp6" value="'.$row[imp6].'"/></TD>';
echo '<TD>Importe-6</TD><TD><input size= 8 type = "text" name = "imp7" value="'.$row[imp7].'"/></TD>';
echo '<TD>Importe-7</TD><TD><input size= 8 type = "text" name = "imp8" value="'.$row[imp8].'"/></TD>';
echo '<TD>Importe-8</TD><TD><input size= 8 type = "text" name = "imp9" value="'.$row[imp9].'"/></TD>';
echo '<TD>Importe-9</TD><TD><input size= 8 type = "text" name = "imp10" value="'.$row[imp10].'"/></TD></TR>';
echo '<TR><TD>Desc Abrev</TD><TD><input size= 20 type = "text" name = "descabrev" value="'.$row[descabrev].'"/></TD>';
echo '<TD>Importe-10</TD><TD><input size= 8 type = "text" name = "imp11" value="'.$row[imp11].'"/></TD>';
echo '<TD>Importe-11</TD><TD><input size= 8 type = "text" name = "imp12" value="'.$row[imp12].'"/></TD>';
echo '<TD>Importe-12</TD><TD><input size= 8 type = "text" name = "imp13" value="'.$row[imp13].'"/></TD>';
echo '<TD>Importe-13</TD><TD><input size= 8 type = "text" name = "imp14" value="'.$row[imp14].'"/></TD>';
echo '<TD>Importe-14</TD><TD><input size= 8 type = "text" name = "imp15" value="'.$row[imp15].'"/></TD></TR>';
echo '<TR><TD>Frecuencia</TD><TD><input size= 3 type = "text" name = "frecuencia" value="'.$row[frecuencia].'"/></TD>';
echo '<TD>Importe-15</TD><TD><input size= 8 type = "text" name = "imp16" value="'.$row[imp16].'"/></TD>';
echo '<TD>Importe-16</TD><TD><input size= 8 type = "text" name = "imp17" value="'.$row[imp17].'"/></TD>';
echo '<TD>Importe-17</TD><TD><input size= 8 type = "text" name = "imp18" value="'.$row[imp18].'"/></TD>';
echo '<TD>Importe-18</TD><TD><input size= 8 type = "text" name = "imp19" value="'.$row[imp19].'"/></TD>';
echo '<TD>Importe-19</TD><TD><input size= 8 type = "text" name = "imp20" value="'.$row[imp20].'"/></TD></TR>';
echo '<TR><TD>Estado</TD><TD><input size= 3 type = "text" name = "estado" value="'.$row[estado].'"/></TD>';
echo '<TD>Coseguro</TD><TD><input size= 8 type = "text" name = "impcoseguro" value="'.$row[impcoseguro].'"/></TD>';
echo '<TD>Cn Excede</TD><TD><input size= 8 type = "text" name = "cla_cnexcede" value="'.$row[cnexcedentes].'"/></TD>';
echo '<TD>$ Excede</TD><TD><input size= 8 type = "text" name = "cla_impexcede" value="'.$row[impexcedentes].'"/></TD></TR>';
echo '</table>' ;

echo '<table>' ;
echo '<TR><TD>Instructivo</TD><TD><textarea name="datos" rows="10" cols="120">'.$datos.'</textarea></TD></TR>';
echo '</table>' ;

////////

?>
<td><INPUT TYPE="SUBMIT" value="Modificar"></td>


    </span></th>
  </tr>
</table>
<br>
</select>


</FORM>
</div>
   </BODY>
</HTML>


