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


<TITLE>M_Guardias.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>
<?
echo titulo_encabezado ('Modificación de Guardias' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$guardia = $_POST["pasguardia"];
//echo $destino;


echo '<FORM METHOD="POST"
ACTION="M_Guardias2.php">';

//Creamos la sentencia SQL y la ejecutamos
$sSQL="select * from guardias where idguardia = ".$guardia;
$result=mysql_query($sSQL);
$idfuncion = mysql_fetch_array($result);

//Ejecutamos la sentencia SQL

$resultfun=mysql_query("select * from bases order by 1");
while ($rowfun=mysql_fetch_array($resultfun))
{ if ($rowfun['idbases'] == $idfuncion['base'])
     $funciones.='<option selected="selected" value="'.$rowfun['idbases'].'">'.$rowfun['descbases'].'</option>';
  else
     $funciones.='<option value="'.$rowfun['idbases'].'">'.$rowfun['descbases'].'</option>';
}
mysql_free_result($resultfun);



//Creamos la sentencia SQL y la ejecutamos
$sSQL="select * from guardias a, legajos b where
       a.legajo = b.legajo and a.idguardia = ".$guardia;
$result=mysql_query($sSQL);


//Mostramos los registros en forma de menú desplegable
while ($row=mysql_fetch_array($result))
{
 echo'<Table>';
 echo '<TR><TD>Legajo</TD><TD><input disabled="disabled" size= 10 type = "text" name = "cla_legajo" value = "'.$row[legajo].'" /></TD></TR>';
 echo '<TR><TD>Apellido y Nombres</TD><TD><input disabled="disabled" size= 50 type = "text" name = "cla_apeynomb" value = "'.$row[apeynomb].'" /></TD></TR>';

 echo '<TR><TD>F.Ingreso.</TD><TD>
      <input type="text" name="cla_fecingreso" id="cla_fecha" size="10" value = "'.$row[fecingreso].'" />
      <input type="button" id="lanzador" value="Seleccionar fecha" onclick="calendario();"/></TD></TR>';

 echo '<TR><TD>H.Ingreso</TD><TD><input size= 10 type = "text" name = "cla_horaingreso" value = "'.$row[horaingreso].'" /></TD></TR>';


 echo '<TR><TD>F.Salida.</TD><TD>
      <input type="text" name="cla_fecsalida" id="cla_fecha1" size="10" value = "'.$row[fecsalida].'" />
      <input type="button" id="lanzador1" value="Seleccionar fecha" onclick="calendario1();"/></TD></TR>';



 echo '<TR><TD>H.Salida</TD><TD><input size= 10 type = "text" name = "cla_horasalida" value = "'.$row[horasalida].'" /></TD></TR>';
 echo '<TR><TD>Base</TD><TD><select name="cla_bases">'.$funciones.'</select></TD></TR>';

 echo '<input type="hidden" name= "guar" value="'.$row["idguardia"].'" >';
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