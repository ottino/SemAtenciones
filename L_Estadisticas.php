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


<TITLE>L_Estadisticas.php</TITLE>
</HEAD>
<BODY>

<?
echo titulo_encabezado ('Listados Estadísticos' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$estadistica1 = $_POST["cla_estad1"];
$estadistica2 = $_POST["cla_estad2"];
$estadistica3 = $_POST["cla_estad3"];
$estadistica4 = $_POST["cla_estad4"];
$estadistica5 = $_POST["cla_estad5"];
$fecha  = $_POST["cla_fecha"];
$fecha1 = $_POST["cla_fecha1"];
$color  = $_POST["cla_color"];

//if ($estadistica2 < '1')
//   $estadistica2 = '99';
//if ($estadistica3 < '1')
//   $estadistica3 = '99';
//if ($estadistica4 < '1')
//   $estadistica4 = '99';
//if ($estadistica5 < '1')
//   $estadistica5 = '99';

//Ejecutamos la sentencia SQL
$result1=mysql_query("SELECT * FROM estadisticas where id <> '99' order by 1");
$estad1= '<select name="cla_estad1" style="background-color:'.$se_color.'"><option value="0">Seleccione</option>';

while ($row1=mysql_fetch_array($result1))
{
 if ($row1['id'] == $estadistica1)
   $estad1.='<option selected = "selected" value="'.$row1['id'].'">'.$row1['nombre'].'</option>';
  else
   $estad1.='<option value="'.$row1['id'].'">'.$row1['nombre'].'</option>';
}

mysql_free_result($result1);
$estad1.= '</select>';

$result2=mysql_query("SELECT * FROM estadisticas where id < '100' order by 1");
$estad2= '<select name="cla_estad2" style="background-color:'.$se_color.'"><option value="0">Seleccione</option>';

while ($row2=mysql_fetch_array($result2))
{
 if ($row2['id']== $estadistica2)
   $estad2.='<option selected = "selected" value="'.$row2['id'].'">'.$row2['nombre'].'</option>';
  else
   $estad2.='<option value="'.$row2['id'].'">'.$row2['nombre'].'</option>';
}
mysql_free_result($result2);
$estad2.= '</select>';

$result3=mysql_query("SELECT * FROM estadisticas where id < '100' order by 1");
$estad3= '<select name="cla_estad3" style="background-color:'.$se_color.'"><option value="0">Seleccione</option>';

while ($row3=mysql_fetch_array($result3))
{
 if ($row3['id']== $estadistica3)
   $estad3.='<option selected = "selected" value="'.$row3['id'].'">'.$row3['nombre'].'</option>';
  else
   $estad3.='<option value="'.$row3['id'].'">'.$row3['nombre'].'</option>';
}
mysql_free_result($result3);
$estad3.= '</select>';

$result4=mysql_query("SELECT * FROM estadisticas where id < '100' order by 1");
$estad4= '<select name="cla_estad4" style="background-color:'.$se_color.'"><option value="0">Seleccione</option>';

while ($row4=mysql_fetch_array($result4))
{
 if ($row4['id']== $estadistica4)
   $estad4.='<option selected = "selected" value="'.$row4['id'].'">'.$row4['nombre'].'</option>';
  else
   $estad4.='<option value="'.$row4['id'].'">'.$row4['nombre'].'</option>';
}
mysql_free_result($result4);
$estad4.= '</select>';

$result5=mysql_query("SELECT * FROM estadisticas where id < '100' order by 1");
$estad5= '<select name="cla_estad5" style="background-color:'.$se_color.'"><option value="0">Seleccione</option>';

while ($row5=mysql_fetch_array($result5))
{
 if ($row5['id']== $estadistica5)
   $estad5.='<option selected = "selected" value="'.$row5['id'].'">'.$row5['nombre'].'</option>';
  else
   $estad5.='<option value="'.$row5['id'].'">'.$row5['nombre'].'</option>';
}
mysql_free_result($result5);
$estad5.= '</select>';

$result6=mysql_query("SELECT * FROM colores order by 1");
$color6= '<select name="cla_color" style="background-color:'.$se_color.'"><option value="0">Seleccione Color</option>';

while ($row6=mysql_fetch_array($result6))
{
 if ($row6['idcolor']== $color)
   $color6.='<option selected = "selected" value="'.$row6['idcolor'].'">'.$row6['desc'].'</option>';
  else
   $color6.='<option value="'.$row6['idcolor'].'">'.$row6['desc'].'</option>';
}
mysql_free_result($result6);
$color6.= '</select>';


echo '<body style="background-color:'.$body_color.'">';

if ($color > '0')
  echo '<FORM METHOD="POST" NAME="formulario3" ACTION="L_Estadisticas2.php">';

if ($estadistica1 != '99')
  if ($estadistica2 != '99')
   if ($estadistica3 != '99')
   if ($estadistica4 != '99')
   if ($estadistica5 != '99')
     echo '<FORM METHOD="POST" NAME="formulario3" ACTION="L_Estadisticas.php">';

if ($estadistica2 == '99')
  echo '<FORM METHOD="POST" NAME="formulario3" ACTION="L_Estadisticas1.php">';

if ($estadistica3 == '99')
  echo '<FORM METHOD="POST" NAME="formulario3" ACTION="L_Estadisticas1.php">';

if ($estadistica4 == '99')
  echo '<FORM METHOD="POST" NAME="formulario3" ACTION="L_Estadisticas1.php">';

if ($estadistica5 == '99')
  echo '<FORM METHOD="POST" NAME="formulario3" ACTION="L_Estadisticas1.php">';

echo '<table width = "20%" align="left">';

?>
 <TR><TD><? echo '<input type="text" name="cla_fecha" id="cla_fecha" size="10" value = "'.$fecha.'"/>
       <input type="button" id="lanzador" value="Fecha Desde" onclick="calendario();"/>';?></td></tr>
 <TR><TD><? echo '<input type="text" name="cla_fecha1" id="cla_fecha1" size="10" value = "'.$fecha1.'"/>
       <input type="button" id="lanzador1" value="Fecha Hasta" onclick="calendario1();"/>';?></td></tr>

<?
echo '<TR><TD>'.$estad1.'</td></tr>';

if ($estadistica1 > '0')
  if ($estadistica1 < '99')
   echo '<TR><TD>'.$estad2.'</td></tr>';


if ($estadistica1 == '100')
   echo '<TR><TD>'.$color6.'</td></tr>';

if ($estadistica1 == '100')
  if ($color > '0')
{   echo '<TR><TD> <SELECT style="width:230px" NAME="hora1" style="background-color:'.$se_color.'" style="border:none">
       <OPTION VALUE= "" selected="selected">Horario Desde</OPTION>
       <OPTION VALUE= "horallam">Hora Llamada</OPTION>
       <OPTION VALUE= "horadesp">Hora Despacho</OPTION></SELECT></TD>';
   echo '<TD> <SELECT style="width:230px" NAME="hora2" style="background-color:'.$se_color.'" style="border:none">
       <OPTION VALUE= "" selected="selected">Horario Hasta</OPTION>
       <OPTION VALUE= "horallegdom">Hora Lleg Domicilio</OPTION>
       <OPTION VALUE= "horalleghosp">Hora Lleg Hospital</OPTION></SELECT></TD>';
   echo '<TD><input type="text" name="cla_minuto" size="4" /></TD>';
   echo '<input type="hidden" name= "demora" value="DEMORA" >';

}

if ($estadistica2 > '0')
 if ($estadistica2 < '99')
   echo '<TR><TD>'.$estad3.'</td></tr>';

if ($estadistica3 > '0')
 if ($estadistica3 < '99')
   echo '<TR><TD>'.$estad4.'</td></tr>';

if ($estadistica4 > '0')
 if ($estadistica4 < '99')
   echo '<TR><TD>'.$estad5.'</td></tr>';

if ($estadistica5 > '0')
 if ($estadistica5 < '99')
   echo '<TR><TD>'.$estad6.'</td></tr>';
?>
</TD>
<TD>&nbsp;
</TD></TD>
</TR></TR></table>

<INPUT TYPE="SUBMIT" value="Buscar">

    </span></th>
  </tr>

</table>
<br>

</select>


</FORM>
</div>
</BODY>
</HTML>
