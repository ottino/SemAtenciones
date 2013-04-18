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


<TITLE>A_Movdisp.php</TITLE>
</HEAD>
<BODY style="font-size:<?echo $fontdef?>" style="background-color:<?echo $body_color?>">

<?
echo titulo_encabezado ('Alta de Moviles de Guardia' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

//Ejecutamos la sentencia SQL

$vector_tipo= '<select name ="tipo" style="background-color:'.$se_color.'"><option value="0">Tipo Guardia</option>';

$vector_tipo.= '<option value="1">UTI</option>';
$vector_tipo.= '<option value="2">PARTICULAR</option>';
$vector_tipo.= '<option value="3">TRASLADO</option>';
$vector_tipo.= '<option value="4">EVENTO</option>';

$vector_tipo.= '</select>';


$result=mysql_query("select * from legajos where funcion in (1,2) and legajo not in
(select legmedico from movildisponible where vigente <> '1') order by 2");

$legajos= '<select name="legajo" style="width:250px" style="background-color:'.$se_color.'"><option value="0">Medico</option>';
while ($row=mysql_fetch_array($result))
{
$legajos.='<option value="'.$row['legajo'].'">'.$row['apeynomb'].'</option>';
$funciones = $row['funcion'];
}

$result=mysql_query("select * from legajos where funcion in (1,2,3,4,5) and legajo not in
(select legchofer from movildisponible where vigente <> '1') order by 2");
$legajosc= '<select name="legajoc" style="width:250px" style="background-color:'.$se_color.'"><option value="0">Chofer</option>';
while ($row=mysql_fetch_array($result))
{
$legajosc.='<option value="'.$row['legajo'].'">'.$row['apeynomb'].'</option>';
}

$result=mysql_query("select * from legajos where funcion in (3,4) and legajo not in
(select legenfermero from movildisponible where vigente <> '1') order by 2");
$legajose= '<select name="legajoe" style="width:250px" style="background-color:'.$se_color.'"><option value="0">Enfermero</option>';
while ($row=mysql_fetch_array($result))
{
$legajose.='<option value="'.$row['legajo'].'">'.$row['apeynomb'].'</option>';
}

$result=mysql_query("select * from legajos order by 2");
$legajoso= '<select name="legajoo" style="width:250px" style="background-color:'.$se_color.'"><option value="0">Otro</option>';
while ($row=mysql_fetch_array($result))
{
$legajoso.='<option value="'.$row['legajo'].'">'.$row['apeynomb'].'</option>';
}

mysql_free_result($result);
$legajos.= '</select>';
$legajosc.= '</select>';
$legajose.= '</select>';
$legajoso.= '</select>';




//Ejecutamos la sentencia SQL
$result=mysql_query("select * from bases order by 1");

$bases= '<select name="base" style="width:100px" style="background-color:'.$se_color.'"><option value="0">Base</option>';

while ($row=mysql_fetch_array($result))
{
$bases.='<option value="'.$row['idbases'].'">'.$row['descbases'].'</option>';
}
mysql_free_result($result);
$bases.= '</select>';



//Ejecutamos la sentencia SQL para los moviles
$result=mysql_query("select * from moviles where idmovil not in
                     (select idmovil from movildisponible where vigente <> '1') order by 1");

$movil= '<select name="movil" style="width:200px" style="background-color:'.$se_color.'"><option value="0">Movil</option>';

while ($row=mysql_fetch_array($result))
{
$movil.='<option value="'.$row['idmovil'].'">'.$row['idmovil'].'-'.$row['descmovil'].'</option>';
}
mysql_free_result($result);
$movil.= '</select>';


?>


<BODY style="font-size:<?echo $fontdef?>" style="background-color:<?echo $body_color?>">

<FORM METHOD="POST" NAME="formulario3"
ACTION="A_Movdisp2.php">


<table width = "50%" align="left" >
 <tr style="font-size:<?echo $fontt?>">
            <th>MOVILES</th>
            <th>GUARDIA</th>
            <th>CHOFER</th>
            <th>MEDICOS</th>
 </tr>
<TR>
<TD><? echo $movil?></TD>
<TD style="width:350px"><? echo $vector_tipo ?></TD>
<TD width="17"><? echo $legajosc ?></TD>
<TD width="17"><? echo $legajos ?></TD></tr>
 <tr style="font-size:<?echo $fontt?>">
            <th></th>
            <th>BASES</th>
            <th>ENFERMERO</th>
            <th>OTRO</th>
            <th>KM SALIDA</th>
 </tr>
<TR><TD></TD>
<TD style="width:350px"><? echo $bases ?></TD>
<TD width="17"><? echo $legajose ?></TD>
<TD width="17"><? echo $legajoso ?></TD>
<TD width="10"><input size= 12 type = "text" name = "cla_kmalta" /></TD>
<td><INPUT TYPE="SUBMIT" value="Insertar"></td>

<TD>&nbsp;
</TD>
</TR></table>
</select>


</FORM>
</div>
</BODY>
</HTML>


