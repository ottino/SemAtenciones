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


<TITLE>B_Contratos.php</TITLE>
</HEAD>
<script>
</script>
<body style="background-color:<?echo $body_color?>">
<BODY>


<?
echo titulo_encabezado ('Baja de Contratos' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$idcontrato = $_POST["pasacont"];
//echo $idcontrato;

?>


<br>
<FORM METHOD="POST" name="formulario"
ACTION="B_Contratos2.php">

<?

//Ejecutamos la sentencia SQL
$sSQL="Select * From contratos where idcontrato = ".$idcontrato;
$result=mysql_query($sSQL);
$row=mysql_fetch_array($result);

$idcliente = $row["idcliente"];
$nombre = buscocliente($idcliente);

$resultplan=mysql_query("SELECT * FROM planes order by 1");
while ($rowplan=mysql_fetch_array($resultplan))
{ if ($rowplan['idplan'] == $row['idplan'])
     $planes.='<option selected="selected" value="'.$rowplan['idplan'].'">'.$rowplan['descplan'].'</option>';
  else
     $planes.='<option value="'.$rowplan['idplan'].'">'.$rowplan['descplan'].'</option>';
}
mysql_free_result($resultplan);

$result=mysql_query("SELECT * FROM tipoplan order by 1");
while ($rowtip=mysql_fetch_array($result))
{ if ($rowtip['idtipoplan'] == $row['tipocontrato'])
     $tipoplan.='<option selected="selected" value="'.$rowtip['idtipoplan'].'">'.$rowtip['desctipoplan'].'</option>';
  else
     $tipoplan.='<option value="'.$rowtip['idtipoplan'].'">'.$rowtip['desctipoplan'].'</option>';
}
mysql_free_result($result);



$sSQL="Select * From contratos where idcontrato = ".$idcontrato;
$result=mysql_query($sSQL);
$row=mysql_fetch_array($result);

 echo'<Table>';
 echo '<TR><TD>ID Contrato</TD><TD><input type="text" disabled = "disabled" name= "idcontrato" value="'.$row["idcontrato"].'" ></TD></TR>';
 echo '<TR><TD>Afiliado</TD><TD><input type="text" disabled = "disabled" name= "idcliente" value="'.$nombre.'" ></TD></TR>';
 echo '<TR><TD>Plan</TD><TD><select disabled = "disabled" name="cla_idplan">'.$planes.'</select></TD></TR>';
 echo '<TR><TD>Tipo Plan</TD><TD><select disabled = "disabled" name="cla_idtipoplan">'.$tipoplan.'</select></TD></TR>';

 $resulfrec=$row['frecuencia'];
 $fecalta = cambiarFormatoFecha($row[fecalta]);
 $fecvto = cambiarFormatoFecha($row[fecvto]);

 echo '<TR><TD>Frecuencia</TD><TD><input type="text" disabled = "disabled" name= "frecuencia" value="'.$resulfrec.'" ></TD></TR>';
 echo '<TR><TD>Fecha de Alta</TD><TD><input type="text" disabled = "disabled" name= "cla_fecha" value="'.$fecalta.'" ></TD></TR>';
 echo '<TR><TD>Fecha de Vto.</TD><TD><input type="text" disabled = "disabled" name= "frecuencia" value="'.$fecvto.'" ></TD></TR>';
 echo '<TR><TD>Importe</TD><TD><input size= 10 disabled = "disabled" type = "text" name = "cla_importe" value = "'.$row[importe].'"/></TD></TR>';
 echo '<TR><TD>Cn Afiliados</TD><TD><input size= 10 disabled = "disabled" type = "text" name = "cla_ordenmax" value = "'.$row[ordenmax].'"/></TD></TR>';
 echo '<TR><TD>Tipo Comprob</TD><TD><input size= 10 disabled = "disabled" type = "text" name = "cla_tipocomprob" value = "'.$row[tipocomprob].'"/></TD></TR>';
 echo '<input type="hidden" name= "pasacont" value="'.$idcontrato.'" >';
 echo '<input type="hidden" name= "cla_idcliente" value="'.$idcliente.'" >';
 echo '<input type="hidden" name= "cla_idplan" value="'.$idplan.'" >';
 echo '<input type="hidden" name= "cla_ordenmax" value="'.$ordenmax.'" >';

 echo '</table>' ;




?>
<td><INPUT TYPE="SUBMIT" value="Eliminar"></td>


    </span></th>
  </tr>
</table>
<br>
</select>


</FORM>
</div>
   </BODY>
</HTML>


