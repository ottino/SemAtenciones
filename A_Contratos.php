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


<TITLE>A_Contratos.php</TITLE>
</HEAD>
<script>
</script>
<body style="background-color:<?echo $body_color?>">
<BODY>


<?
echo titulo_encabezado ('Alta de Contratos' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }
?>


<br>
<FORM METHOD="POST" name="formulario"
ACTION="A_Contratos2.php">

<?

//Ejecutamos la sentencia SQL
$result=mysql_query("SELECT * FROM clientes order by 8");
$clientes.='<option selected="selected" value="">Seleccione Cliente</option>';
while ($row=mysql_fetch_array($result))
{
$clientes.='<option value="'.$row['idcliente'].'">'.$row['nombre'].' - '.$row['cuit'].'</option>';
}
mysql_free_result($result);

$result=mysql_query("SELECT * FROM planes order by 2");
$planes.='<option selected="selected" value="">Seleccione Plan</option>';
while ($row=mysql_fetch_array($result))
{
$planes.='<option value="'.$row['idplan'].'">'.$row['descplan'].' - '.$row['idplan'].'</option>';
}
mysql_free_result($result);

$result=mysql_query("SELECT * FROM provincias order by 2");
$provincias.='<option selected="selected" value="">Seleccione Provincia</option>';
while ($row=mysql_fetch_array($result))
{
$provincias.='<option value="'.$row['idprovincia'].'">'.$row['provincia'].'</option>';
}
mysql_free_result($result);

$result=mysql_query("SELECT * FROM localidad order by 3");
$localidad.='<option selected="selected" value="">Seleccione Localidad</option>';
while ($row=mysql_fetch_array($result))
{
$localidad.='<option value="'.$row['idlocalidad'].'">'.$row['localidad'].'</option>';
}
mysql_free_result($result);

$result=mysql_query("SELECT * FROM cobrador order by 1");
$cobrador.='<option selected="selected" value="">Seleccione Cobrador</option>';
while ($row=mysql_fetch_array($result))
{
$cobrador.='<option value="'.$row['idcob'].'">'.$row['desccob'].'</option>';
}
mysql_free_result($result);

$result=mysql_query("SELECT * FROM zonas order by 1");
$zonas.='<option selected="selected" value="">Seleccione Zona</option>';
while ($row=mysql_fetch_array($result))
{
$zonas.='<option value="'.$row['idzonas'].'">'.$row['desczonas'].'</option>';
}
mysql_free_result($result);

$result=mysql_query("SELECT * FROM tipoplan order by 1");
$tipoplan.='<option selected="selected" value="">Seleccione Tipo Plan</option>';
while ($row=mysql_fetch_array($result))
{
$tipoplan.='<option value="'.$row['idtipoplan'].'">'.$row['desctipoplan'].'</option>';
}
mysql_free_result($result);





 echo'<Table>';
 echo '<TR><TD>Nro Contrato</TD><TD><input size= 10 type = "text" name = "cla_nrocontrato" /></TD></TR>';
 echo '<TR><TD>Afiliado</TD><TD><select name="cla_idcliente">'.$clientes.'</select></TD></TR>';
 echo '<TR><TD>Plan</TD><TD><select name="cla_idplan">'.$planes.'</select></TD></TR>';
 echo '<TR><TD>Tipo Plan</TD><TD><select name="cla_idtipoplan">'.$tipoplan.'</select></TD></TR>';
 echo '<TR><TD>Frecuencia</TD><TD>
      <label>
        <input type="radio" name="cla_frecuencia" value="M">
        MENSUAL</label><label>
        <input type="radio" name="cla_frecuencia" value="B">
        BIMESTRAL</label><label>
        <input type="radio" name="cla_frecuencia" value="S">
        SEMESTRAL</label><label>
        <input type="radio" name="cla_frecuencia" value="A">
        ANUAL</label></td></tr>';


 echo '<TR><TD>Fecha de Alta</TD><TD>
      <input type="text" name="cla_fecha" id="cla_fecha" size="10" />
      <input type="button" id="lanzador" value="Fecha de Alta" onclick="calendario();"/></TD></TR>';

 echo '<TR><TD>Fecha Vencimiento</TD><TD>
      <input type="text" name="cla_fecha1" id="cla_fecha1" size="10" />
      <input type="button" id="lanzador1" value="Fecha Vencimiento" onclick="calendario1();"/></TD></TR>';

 echo '<TR><TD>Importe</TD><TD><input size= 10 type = "text" name = "cla_importe" /></TD></TR>';
// echo '<TR><TD>Cn Afiliados</TD><TD><input disabled="disabled" size= 10 type = "text" name = "cla_ordenmax" /></TD></TR>';
 echo '<TR><TD>Tipo Comprobante</TD><TD>
     <label>
       <input type="radio" name="cla_tipocomprob" value="C" />
       Cupón</label>
     <label>
       <input type="radio" name="cla_tipocomprob" value="F" />
       Factura</label>
     <label>
       <input type="radio" name="cla_tipocomprob" value="T" />
       Tarjeta</label></TD>';
echo '<TD>Nro Tarjeta</TD><TD><input size= 16 type = "text" name = "cla_nrotarjeta" /></TD></TR>';
echo '<TD>Cobrador</TD><TD><select name="cla_cobrador">'.$cobrador.'</select></TD></TR>';
echo '<TR><TD>Calle    </TD><TD><input size= 50 type = "text" name = "cla_calle" /></TD>';
echo '<TD>Nro      </TD><TD><input size= 4 type = "text" name = "cla_nrocalle" /></TD></TR>';
echo '<TR><TD>Entre   </TD><TD><input size= 50 type = "text" name = "cla_entre1" /></TD>';
echo '<TD>Y</TD><TD><input size= 50 type = "text" name = "cla_entre2" /></TD></TR>';
echo '<TR><TD>Piso     </TD><TD><input size= 4 type = "text" name = "cla_piso" /></TD>';
echo '<TD>Depto    </TD><TD><input size= 6 type = "text" name = "cla_depto" /></TD></TR>';
echo '<TR><TD>Barrio   </TD><TD><input size= 30 type = "text" name = "cla_barrio" /></TD>';
echo '<TD>Cod.Post.</TD><TD><input size= 4 type = "text" name = "cla_cpostal" /></TD></TR>';
echo '<TR><TD>Zona</TD><TD><select name="cla_zona">'.$zonas.'</select></TD>';
echo '<TR><TD>Localidad</TD><TD><select name="cla_localidad">'.$localidad.'</select></TD>';
echo '<TD>Provincia</TD><TD><select name="cla_provincia">'.$provincias.'</select></TD></TR>';
echo '<TR><TD>Telefono </TD><TD><input size= 20 type = "text" name = "cla_telefono" /></TD>';
echo '<TR><TD>Observaciones</TD><TD><textarea name="cla_observaciones" rows="5" cols="40"></textarea></TD></TR>';


echo '</table>' ;
?>
<td><INPUT TYPE="SUBMIT" value="Insertar"></td>


    </span></th>
  </tr>
</table>
<br>
</select>


</FORM>
</div>
   </BODY>
</HTML>


