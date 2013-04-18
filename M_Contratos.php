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


<TITLE>M_Contratos.php</TITLE>
</HEAD>
<script>
</script>
<body style="background-color:<?echo $body_color?>">
<BODY>


<?
echo titulo_encabezado ('Modificación de Contratos' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$idcontrato = $_POST["pasacont"];
$idplan  = $_POST["cla_plan"];
$nombre1  = $_POST["cla_nombre"];
$fecha  = $_POST["cla_fecha"];


//echo $idcontrato;

?>


<br>
<FORM METHOD="POST" name="formulario"
ACTION="M_Contratos2.php">

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


$result=mysql_query("SELECT * FROM provincias order by 2");
while ($rowprov=mysql_fetch_array($result))
{ if ($rowprov['idprovincia'] == $row['provinciacob'])
     $provincias.='<option selected="selected" value="'.$rowprov['idprovincia'].'">'.$rowprov['provincia'].'</option>';
  else
     $provincias.='<option value="'.$rowprov['idprovincia'].'">'.$rowprov['provincia'].'</option>';
}
mysql_free_result($result);

$result=mysql_query("SELECT * FROM localidad order by 3");
while ($rowloc=mysql_fetch_array($result))
{ if ($rowloc['idlocalidad'] == $row['localidad'])
     $localidad.='<option selected="selected" value="'.$rowloc['idlocalidad'].'">'.$rowloc['localidad'].'</option>';
  else
     $localidad.='<option value="'.$rowloc['idlocalidad'].'">'.$rowloc['localidad'].'</option>';
}
mysql_free_result($result);

$result=mysql_query("SELECT * FROM cobrador order by 1");
while ($rowcob=mysql_fetch_array($result))
{ if ($rowcob['idcob'] == $row['codcobrador'])
     $cobrador.='<option selected="selected" value="'.$rowcob['idcob'].'">'.$rowcob['desccob'].'</option>';
  else
     $cobrador.='<option value="'.$rowcob['idcob'].'">'.$rowcob['desccob'].'</option>';
}
mysql_free_result($result);

$result=mysql_query("SELECT * FROM zonas order by 1");
while ($rowzon=mysql_fetch_array($result))
{ if ($rowzon['idzonas'] == $row['idzonacob'])
     $zonas.='<option selected="selected" value="'.$rowzon['idzonas'].'">'.$rowzon['desczonas'].'</option>';
  else
     $zonas.='<option value="'.$rowzon['idzonas'].'">'.$rowzon['desczonas'].'</option>';
}
mysql_free_result($result);

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
 echo '<TR><TD>Afiliado</TD><TD><input size= 40 type="text" disabled = "disabled" name= "idcliente" value="'.$nombre.'" ></TD></TR>';
 echo '<TR><TD>Plan</TD><TD><select name="cla_idplan">'.$planes.'</select></TD></TR>';
 echo '<TR><TD>Tipo Plan</TD><TD><select name="cla_idtipoplan">'.$tipoplan.'</select></TD></TR>';

 $resulfrec=$row['frecuencia'];
 if ($resulfrec == 'M')
    $checkfrec = '    <label>
        <input type="radio" name="cla_frecuencia" value="M" checked="checked"/>
        MENSUAL</label><label>
        <input type="radio" name="cla_frecuencia" value="B">
        BIMESTRAL</label></td></tr><TR><TD></TD><TD><label>
        <input type="radio" name="cla_frecuencia" value="S">
        SEMESTRAL</label><label>
        <input type="radio" name="cla_frecuencia" value="A">
        ANUAL</label></td></tr>';
   else
     if ($resulfrec == 'B')
       $checkfrec = '    <label>
        <input type="radio" name="cla_frecuencia" value="M">
        MENSUAL</label><label>
        <input type="radio" name="cla_frecuencia" value="B" checked="checked"/>
        BIMESTRAL</label></td></tr><TR><TD></TD><TD><label>
        <input type="radio" name="cla_frecuencia" value="S">
        SEMESTRAL</label><label>
        <input type="radio" name="cla_frecuencia" value="A">
        ANUAL</label></td></tr>';
   else
     if ($resulfrec == 'S')
       $checkfrec = '    <label>
        <input type="radio" name="cla_frecuencia" value="M">
        MENSUAL</label><label>
        <input type="radio" name="cla_frecuencia" value="B">
        BIMESTRAL</label></td></tr><TR><TD></TD><TD><label>
        <input type="radio" name="cla_frecuencia" value="S" checked="checked"/>
        SEMESTRAL</label><label>
        <input type="radio" name="cla_frecuencia" value="A">
        ANUAL</label></td></tr>';
   else
       $checkfrec = '    <label>
        <input type="radio" name="cla_frecuencia" value="M">
        MENSUAL</label><label>
        <input type="radio" name="cla_frecuencia" value="B">
        BIMESTRAL</label></td></tr><TR><TD></TD><TD><label>
        <input type="radio" name="cla_frecuencia" value="S">
        SEMESTRAL</label><label>
        <input type="radio" name="cla_frecuencia" value="A" checked="checked"/>
        ANUAL</label></td></tr>';

 echo '<TR><TD>Frecuencia</TD><TD>'.$checkfrec.'</TD></TR>';

 echo '<TR><TD>Fecha de Alta</TD><TD>
      <input type="text" name="cla_fecha" id="cla_fecha" size="10" value = "'.$row[fecalta].'"/>
      <input type="button" id="lanzador" value="Fecha de Alta" onclick="calendario();"/></TD></TR>';

 echo '<TR><TD>Fecha de Vto</TD><TD>
      <input type="text" name="cla_fecha1" id="cla_fecha1" size="10" value = "'.$row[fecvto].'"/>
      <input type="button" id="lanzador1" value="Fecha de Vto" onclick="calendario1();"/></TD></TR>';

 echo '<TR><TD>Importe</TD><TD><input size= 10 type = "text" name = "cla_importe" value = "'.$row[importe].'"/></TD></TR>';
 echo '<TR><TD>Cn Afiliados</TD><TD><input size= 10 disabled = "disabled" type = "text" name = "cla_ordenmax" value = "'.$row[ordenmax].'"/></TD></TR>';

  $resulcomp=$row['tipocomprob'];
  if ($resulcomp == 'C')
     $checkcupon = '
     <label>
       <input type="radio" name="cla_tipocomprob" value="C" checked="checked"/>
       Cupón</label>
     <label>
       <input type="radio" name="cla_tipocomprob" value="F" />
       Factura</label>
     <label>
       <input type="radio" name="cla_tipocomprob" value="T" />
       Tarjeta</label></TD>';
  else
  if ($resulcomp == 'F')
     $checkcupon = '     <label>
       <input type="radio" name="cla_tipocomprob" value="C"/>
       Cupón</label>
     <label>
       <input type="radio" name="cla_tipocomprob" value="F" checked="checked" />
       Factura</label>
     <label>
       <input type="radio" name="cla_tipocomprob" value="T" />
       Tarjeta</label></TD>';
  else
     $checkcupon = '     <label>
       <input type="radio" name="cla_tipocomprob" value="C"/>
       Cupón</label>
     <label>
       <input type="radio" name="cla_tipocomprob" value="F"/>
       Factura</label>
     <label>
       <input type="radio" name="cla_tipocomprob" value="T"  checked="checked" />
       Tarjeta</label></TD>';

$observaciones = $row[observaciones];
echo '<TR><TD>Tipo Comprob</TD><TD>'.$checkcupon.'</TD><TD>Nro Tarjeta</TD><TD><input size= 16 type = "text" name = "cla_nrotarjeta" value = "'.$row[nrotarjeta].'"/></TD></TR>';
echo '<input type="hidden" name= "pasacont" value="'.$idcontrato.'" >';
echo '<input type="hidden" name= "cla_idcliente" value="'.$idcliente.'" >';
echo '<input type="hidden" name= "cla_ordenmax" value="'.$ordenmax.'" >';
echo '<TD>Cobrador</TD><TD><select name="cla_cobrador">'.$cobrador.'</select></TD></TR>';
echo '<TR><TD>Calle    </TD><TD><input size= 50 type = "text" name = "cla_calle" value = "'.$row[callecob].'"/></TD>';
echo '<TD>Nro      </TD><TD><input size= 4 type = "text" name = "cla_nrocalle" value = "'.$row[nrocallecob].'"/></TD></TR>';
echo '<TR><TD>Entre   </TD><TD><input size= 50 type = "text" name = "cla_entre1" value = "'.$row[entre1cob].'"/></TD>';
echo '<TD>Y</TD><TD><input size= 50 type = "text" name = "cla_entre2" value = "'.$row[entre2cob].'"/></TD></TR>';
echo '<TR><TD>Piso     </TD><TD><input size= 4 type = "text" name = "cla_piso" value = "'.$row[pisocob].'"/></TD>';
echo '<TD>Depto    </TD><TD><input size= 6 type = "text" name = "cla_depto" value = "'.$row[deptocob].'"/></TD></TR>';
echo '<TR><TD>Barrio   </TD><TD><input size= 30 type = "text" name = "cla_barrio" value = "'.$row[barriocob].'"/></TD>';
echo '<TD>Cod.Post.</TD><TD><input size= 4 type = "text" name = "cla_cpostal" value = "'.$row[cpostalcob].'"/></TD></TR>';
echo '<TR><TD>Zona</TD><TD><select name="cla_zona">'.$zonas.'</select></TD>';
echo '<TR><TD>Localidad</TD><TD><select name="cla_localidad">'.$localidad.'</select></TD>';
echo '<TD>Provincia</TD><TD><select name="cla_provincia">'.$provincias.'</select></TD></TR>';
echo '<TR><TD>Telefono </TD><TD><input size= 20 type = "text" name = "cla_telefono" value = "'.$row[telefonocob].'"/></TD>';
echo '<TR><TD>Observaciones</TD><TD><textarea name="cla_observaciones" rows="5" cols="40">'.$observaciones.'</textarea></TD></TR>';

echo '</table></p></p><table><TR>' ;

echo '<td></td><td><INPUT TYPE="SUBMIT" value="Modificar"></FORM></td>' ;

echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="ABM_Contratos.php">';
echo '<input type="hidden" name= "cla_plan" value="'.$idplan.'" >';
echo '<input type="hidden" name= "cla_nombre" value="'.$nombre1.'" >';
echo '<input type="hidden" name= "cla_fecha" value="'.$fecha.'" >';
echo '<td><INPUT TYPE="SUBMIT" value="Volver sin modificar"></td>' ;

//echo ' <td width="17" align="center" style="background-color:'.$td_color.'" style="CURSOR: hand" >
//                <label onclick="this.form.submit();">
//                 <img align="middle" alt=\'Volver\' src="imagenes/Volver.ico" width="30" height="30"/>
//                </label></td>';
echo '</FORM></TD>';
echo '</TR></table>' ;

?>
    </span></th>
  </tr>
</table>
<br>
</select>


</FORM>
</div>
   </BODY>
</HTML>


