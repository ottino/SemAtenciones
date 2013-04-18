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


<TITLE>A_Adicionales.php</TITLE>
</HEAD>
<script>
</script>
<body style="background-color:<?echo $body_color?>">
<BODY>


<?
echo titulo_encabezado ('Alta de Adicionales' , $path_imagen_logo);
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
ACTION="A_Adicionales2.php">

<?

//Ejecutamos la sentencia SQL
$sSQL="Select * From contratos where idcontrato = ".$idcontrato;
$result=mysql_query($sSQL);
$row=mysql_fetch_array($result);

$idcliente = $row["idcliente"];
$ordenmax = $row["ordenmax"];
$idplan = $row["idplan"];
$nombre = buscocliente($idcliente);

$resultplan=mysql_query("SELECT * FROM planes order by 1");
while ($rowplan=mysql_fetch_array($resultplan))
{ if ($rowplan['idplan'] == $row['idplan'])
     $planes.='<option selected="selected"  value="'.$rowplan['idplan'].'">'.$rowplan['descplan'].'</option>';
  else
     $planes.='<option value="'.$rowplan['idplan'].'">'.$rowplan['descplan'].'</option>';
}
mysql_free_result($resultplan);

$sSQL="Select * From contratos where idcontrato = ".$idcontrato;
$result=mysql_query($sSQL);
$row=mysql_fetch_array($result);

 echo'<Table>';
 echo '<TR><TD>Afiliado</TD><TD><input type="text" disabled = "disabled" name= "idcliente" value="'.$nombre.'" ></TD></TR>';
 echo '<TR><TD>Plan</TD><TD><select disabled= "disabled" style="width:350px" name="cla_idplan">'.$planes.'</select></TD></TR>';

 $resulfrec=$row['frecuencia'];
 echo '<TR><TD>Frecuencia</TD><TD><input type="text" disabled = "disabled" name= "frecuencia" value="'.$resulfrec.'" ></TD></TR>';
 echo '<TR><TD>Fecha de Alta</TD><TD><input type="text" disabled = "disabled" name= "cla_fecha" value="'.$row[fecalta].'" ></TD></TR>';
 echo '<TR><TD>Fecha de Vto.</TD><TD><input type="text" disabled = "disabled" name= "frecuencia" value="'.$row[fecvto].'" ></TD></TR>';
 echo '<TR><TD>Importe</TD><TD><input size= 10 disabled = "disabled" type = "text" name = "cla_importe" value = "'.$row[importe].'"/></TD></TR>';
 echo '<TR><TD>Cn Afiliados</TD><TD><input size= 10 disabled = "disabled" type = "text" name = "cla_ordenmax" value = "'.$row[ordenmax].'"/></TD></TR>';
 echo '<TR><TD>Tipo Comprob</TD><TD><input size= 10 disabled = "disabled" type = "text" name = "cla_tipocomprob" value = "'.$row[tipocomprob].'"/></TD></TR>';
 echo '<input type="hidden" name= "pasacont" value="'.$idcontrato.'" >';
 echo '<input type="hidden" name= "cla_idcliente" value="'.$idcliente.'" >';
 echo '<input type="hidden" name= "cla_idplan" value="'.$idplan.'" >';
 echo '<input type="hidden" name= "cla_ordenmax" value="'.$ordenmax.'" >';

$resultc=mysql_query("SELECT * FROM clientes order by 8");
$clientes.='<option selected="selected" value="A">NUEVO CLIENTE</option>';
while ($rowc=mysql_fetch_array($resultc))
{
$clientes.='<option value="'.$rowc['idcliente'].'">'.$rowc['nombre'].' - '.$rowc['cuit'].'</option>';
}

echo '<TR><TD>Agregar afiliados</TD><TD><select style="width:350px" name="cla_idcliente1">'.$clientes.'</select></TD>';
echo '<TD><select style="width:350px" name="cla_idcliente2">'.$clientes.'</select></TD>';
echo '<TD><select style="width:350px" name="cla_idcliente3">'.$clientes.'</select></TD></TR>';
echo '<TR><TD></TD><TD><select style="width:350px" name="cla_idcliente4">'.$clientes.'</select></TD>';
echo '<TD><select style="width:350px" name="cla_idcliente5">'.$clientes.'</select></TD>';
echo '<TD><select style="width:350px" name="cla_idcliente6">'.$clientes.'</select></TD></TR>';
echo '<TR><TD></TD><TD><select style="width:350px" name="cla_idcliente7">'.$clientes.'</select></TD>';
echo '<TD><select style="width:350px" name="cla_idcliente8">'.$clientes.'</select></TD>';
echo '<TD><select style="width:350px" name="cla_idcliente9">'.$clientes.'</select></TD></TR>';
echo '<TR><TD></TD><TD><select style="width:350px" name="cla_idcliente10">'.$clientes.'</select></TD>';
echo '<TD><select style="width:350px" name="cla_idcliente11">'.$clientes.'</select></TD>';
echo '<TD><select style="width:350px" name="cla_idcliente12">'.$clientes.'</select></TD></TR>';

mysql_free_result($resultc);


echo'<Table>';
echo '</table>' ;




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


