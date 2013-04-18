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


<TITLE>A_Guardias.php</TITLE>
</HEAD>
<BODY>

<?
echo titulo_encabezado ('Alta de Guardias' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$leg = $_POST["paslegajo"];

//Ejecutamos la sentencia SQL
$result=mysql_query("SELECT * FROM legajos order by 2");

$legajos= '<select name="legajo" style="background-color:'.$se_color.'"><option value="0">Personal</option>';

while ($row=mysql_fetch_array($result))
{
$funciones = $row['funcion'];

if ($row['legajo']== $leg)
   $legajos.='<option selected = "selected" value="'.$row['legajo'].'">'.$row['apeynomb'].'</option>';
else
   $legajos.='<option value="'.$row['legajo'].'">'.$row['apeynomb'].'</option>';
}
mysql_free_result($result);

$legajos.= '</select>';


//Ejecutamos la sentencia SQL  para seleccionar Funciones
$result=mysql_query("SELECT * FROM funciones where idfunciones =".$funciones);

$row=mysql_fetch_array($result);
$descfunciones = $row['funciones'];

mysql_free_result($result);



//Ejecutamos la sentencia SQL
$result=mysql_query("select * from bases order by 1");

$bases= '<select name="base" style="background-color:'.$se_color.'"><option value="0">Base</option>';

while ($row=mysql_fetch_array($result))
{
$bases.='<option value="'.$row['idbases'].'">'.$row['descbases'].'</option>';
}
mysql_free_result($result);
$bases.= '</select>';


for($c=0;$c<=31;$c++)
$vector_diai[$c]= '<select name="diai'.$c.'" style="background-color:'.$se_color.'"><option value="0">F.Ingreso</option>';

for($c=0;$c<=31;$c++)
$vector_horai[$c]= '<select name="horai'.$c.'" style="background-color:'.$se_color.'"><option value="0">Hora Ingreso</option>';

for($c=0;$c<=31;$c++)
$vector_dias[$c]= '<select name="dias'.$c.'" style="background-color:'.$se_color.'"><option value="0">F.Salida</option>';

for($c=0;$c<=31;$c++)
$vector_horas[$c]= '<select name="horas'.$c.'" style="background-color:'.$se_color.'"><option value="0">Hora Salida</option>';


for($c=0;$c<=31;$c++)
 for ($d=0;$d<=31;$d++)
 $vector_diai[$c].= '<option value="'.$d.'">'.$d.'</option>';

for($c=0;$c<=31;$c++)
$vector_diai[$c].='</select>';


for($c=0;$c<=31;$c++)
 for ($d=0;$d<=23;$d++)
 $vector_horai[$c].= '<option value="'.$d.'">'.$d.'</option>';

for($c=0;$c<=31;$c++)
$vector_horai[$c].='</select>';

for($c=0;$c<=31;$c++)
 for ($d=0;$d<=31;$d++)
 $vector_dias[$c].= '<option value="'.$d.'">'.$d.'</option>';

for($c=0;$c<=31;$c++)
$vector_dias[$c].='</select>';


for($c=0;$c<=31;$c++)
 for ($d=0;$d<=23;$d++)
 $vector_horas[$c].= '<option value="'.$d.'">'.$d.'</option>';

for($c=0;$c<=31;$c++)
$vector_horas[$c].='</select>';

$vector_meses= '<select name ="meses" style="background-color:'.$se_color.'"><option value="0">Meses</option>';
$vector_anios= '<select name ="anios" style="background-color:'.$se_color.'"><option value="0">Años</option>';

for($c=1;$c<=12;$c++)
$vector_meses.= '<option value="'.$c.'">'.$c.'</option>';

for($c=2009;$c<=2025;$c++)
$vector_anios.= '<option value="'.$c.'">'.$c.'</option>';

$vector_meses.= '</select>';
$vector_anios.= '</select>';

?>

 <!--////////////TABLA DE GUARDIAS  ////////////////////-->

<body style="background-color:<?echo $body_color?>">
<FORM METHOD="POST" NAME="formulario3"
ACTION="A_Guardias2.php">


<table width = "10%" align="left">
<TR>
<TD><? echo $legajos ?><? echo $bases ?><? echo $vector_meses ?><? echo $vector_anios ?>
</TD>
<TD>&nbsp;
</TD>
</TR></table>
<BR>
<BR>


<table width="100%" border="1">
  <tr>
    <th scope="col" style="background-color:<?echo $th_color?>">Día 1 </th>
    <th scope="col" style="background-color:<?echo $th_color?>">Día 2 </th>
    <th scope="col" style="background-color:<?echo $th_color?>">Día 3 </th>
    <th scope="col" style="background-color:<?echo $th_color?>">Día 4 </th>
    <th scope="col" style="background-color:<?echo $th_color?>">Día 5 </th>
  </tr>
  <tr>
    <td><? echo $vector_diai[1] ?>
        <? echo $vector_horai[1] ?>
        <? echo $vector_dias[1] ?>
        <? echo $vector_horas[1] ?>
    <td><? echo $vector_diai[2] ?>
        <? echo $vector_horai[2] ?>
        <? echo $vector_dias[2] ?>
        <? echo $vector_horas[2] ?>
    <td><? echo $vector_diai[3] ?>
        <? echo $vector_horai[3] ?>
        <? echo $vector_dias[3] ?>
        <? echo $vector_horas[3] ?>
    <td><? echo $vector_diai[4] ?>
        <? echo $vector_horai[4] ?>
        <? echo $vector_dias[4] ?>
        <? echo $vector_horas[4] ?>
    <td><? echo $vector_diai[5] ?>
        <? echo $vector_horai[5] ?>
        <? echo $vector_dias[5] ?>
        <? echo $vector_horas[5] ?>
  </tr>
  <tr>
    <th scope="col" style="background-color:<?echo $th_color?>">Día 6 </th>
    <th scope="col" style="background-color:<?echo $th_color?>">Día 7 </th>
    <th scope="col" style="background-color:<?echo $th_color?>">Día 8 </th>
    <th scope="col" style="background-color:<?echo $th_color?>">Día 9 </th>
    <th scope="col" style="background-color:<?echo $th_color?>">Día 10</th>
  </tr>
  <tr>
    <td><? echo $vector_diai[6] ?>
        <? echo $vector_horai[6] ?>
        <? echo $vector_dias[6] ?>
        <? echo $vector_horas[6] ?>
    <td><? echo $vector_diai[7] ?>
        <? echo $vector_horai[7] ?>
        <? echo $vector_dias[7] ?>
        <? echo $vector_horas[7] ?>
    <td><? echo $vector_diai[8] ?>
        <? echo $vector_horai[8] ?>
        <? echo $vector_dias[8] ?>
        <? echo $vector_horas[8] ?>
    <td><? echo $vector_diai[9] ?>
        <? echo $vector_horai[9] ?>
        <? echo $vector_dias[9] ?>
        <? echo $vector_horas[9] ?>
    <td><? echo $vector_diai[10] ?>
        <? echo $vector_horai[10] ?>
        <? echo $vector_dias[10] ?>
        <? echo $vector_horas[10] ?>
  </tr>
  <tr>
    <th scope="col" style="background-color:<?echo $th_color?>">Día 11</th>
    <th scope="col" style="background-color:<?echo $th_color?>">Día 12 </th>
    <th scope="col" style="background-color:<?echo $th_color?>">Día 13 </th>
    <th scope="col" style="background-color:<?echo $th_color?>">Día 14 </th>
    <th scope="col" style="background-color:<?echo $th_color?>">Día 15 </th>
  </tr>
  <tr>
    <td><? echo  $vector_diai[11] ?>
        <? echo $vector_horai[11] ?>
        <? echo  $vector_dias[11] ?>
        <? echo $vector_horas[11] ?>
    <td><? echo  $vector_diai[12] ?>
        <? echo $vector_horai[12] ?>
        <? echo  $vector_dias[12] ?>
        <? echo $vector_horas[12] ?>
    <td><? echo  $vector_diai[13] ?>
        <? echo $vector_horai[13] ?>
        <? echo  $vector_dias[13] ?>
        <? echo $vector_horas[13] ?>
    <td><? echo  $vector_diai[14] ?>
        <? echo $vector_horai[14] ?>
        <? echo  $vector_dias[14] ?>
        <? echo $vector_horas[14] ?>
    <td><? echo  $vector_diai[15] ?>
        <? echo $vector_horai[15] ?>
        <? echo  $vector_dias[15] ?>
        <? echo $vector_horas[15] ?>
  </tr>
  <tr>
    <th scope="col" style="background-color:<?echo $th_color?>">Día 16 </th>
    <th scope="col" style="background-color:<?echo $th_color?>">Día 17 </th>
    <th scope="col" style="background-color:<?echo $th_color?>">Día 18 </th>
    <th scope="col" style="background-color:<?echo $th_color?>">Día 19 </th>
    <th scope="col" style="background-color:<?echo $th_color?>">Día 20 </th>
  </tr>
  <tr>
    <td><? echo  $vector_diai[16] ?>
        <? echo $vector_horai[16] ?>
        <? echo  $vector_dias[16] ?>
        <? echo $vector_horas[16] ?>
    <td><? echo  $vector_diai[17] ?>
        <? echo $vector_horai[17] ?>
        <? echo  $vector_dias[17] ?>
        <? echo $vector_horas[17] ?>
    <td><? echo  $vector_diai[18] ?>
        <? echo $vector_horai[18] ?>
        <? echo  $vector_dias[18] ?>
        <? echo $vector_horas[18] ?>
    <td><? echo  $vector_diai[19] ?>
        <? echo $vector_horai[19] ?>
        <? echo  $vector_dias[19] ?>
        <? echo $vector_horas[19] ?>
    <td><? echo  $vector_diai[20] ?>
        <? echo $vector_horai[20] ?>
        <? echo  $vector_dias[20] ?>
        <? echo $vector_horas[20] ?>
  </tr>
  <tr>
    <th scope="col" style="background-color:<?echo $th_color?>">Día 21 </th>
    <th scope="col" style="background-color:<?echo $th_color?>">Día 22 </th>
    <th scope="col" style="background-color:<?echo $th_color?>">Día 23 </th>
    <th scope="col" style="background-color:<?echo $th_color?>">Día 24 </th>
    <th scope="col" style="background-color:<?echo $th_color?>">Día 25 </th>
  </tr>
  <tr>
    <td><? echo  $vector_diai[21] ?>
        <? echo $vector_horai[21] ?>
        <? echo  $vector_dias[21] ?>
        <? echo $vector_horas[21] ?>
    <td><? echo  $vector_diai[22] ?>
        <? echo $vector_horai[22] ?>
        <? echo  $vector_dias[22] ?>
        <? echo $vector_horas[22] ?>
    <td><? echo  $vector_diai[23] ?>
        <? echo $vector_horai[23] ?>
        <? echo  $vector_dias[23] ?>
        <? echo $vector_horas[23] ?>
    <td><? echo  $vector_diai[24] ?>
        <? echo $vector_horai[24] ?>
        <? echo  $vector_dias[24] ?>
        <? echo $vector_horas[24] ?>
    <td><? echo  $vector_diai[25] ?>
        <? echo $vector_horai[25] ?>
        <? echo  $vector_dias[25] ?>
        <? echo $vector_horas[25] ?>
  </tr>
  <tr>
    <th scope="col" style="background-color:<?echo $th_color?>">Día 26 </th>
    <th scope="col" style="background-color:<?echo $th_color?>">Día 27 </th>
    <th scope="col" style="background-color:<?echo $th_color?>">Día 28 </th>
    <th scope="col" style="background-color:<?echo $th_color?>">Día 29 </th>
    <th scope="col" style="background-color:<?echo $th_color?>">Día 30 </th>
  </tr>
  <tr>
    <td><? echo  $vector_diai[26] ?>
        <? echo $vector_horai[26] ?>
        <? echo  $vector_dias[26] ?>
        <? echo $vector_horas[26] ?>
    <td><? echo  $vector_diai[27] ?>
        <? echo $vector_horai[27] ?>
        <? echo  $vector_dias[27] ?>
        <? echo $vector_horas[27] ?>
    <td><? echo  $vector_diai[28] ?>
        <? echo $vector_horai[28] ?>
        <? echo  $vector_dias[28] ?>
        <? echo $vector_horas[28] ?>
    <td><? echo  $vector_diai[29] ?>
        <? echo $vector_horai[29] ?>
        <? echo  $vector_dias[29] ?>
        <? echo $vector_horas[29] ?>
    <td><? echo  $vector_diai[30] ?>
        <? echo $vector_horai[30] ?>
        <? echo  $vector_dias[30] ?>
        <? echo $vector_horas[30] ?>
  </tr>
  <tr>
    <th scope="col" style="background-color:<?echo $th_color?>">Día 31 </th>
    <th scope="col" style="background-color:<?echo $th_color?>">Día  </th>
    <th scope="col" style="background-color:<?echo $th_color?>">Día  </th>
    <th scope="col" style="background-color:<?echo $th_color?>">Día  </th>
    <th scope="col" style="background-color:<?echo $th_color?>">Día  </th>
  </tr>  <tr>
    <td><? echo  $vector_diai[31] ?>
        <? echo $vector_horai[31] ?>
        <? echo  $vector_dias[31] ?>
        <? echo $vector_horas[31] ?>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>


<!--////////////TABLA DE GUARDIAS  ////////////////////-->



<br>


<INPUT TYPE="SUBMIT" value="Insertar">

    </span></th>
  </tr>
</table>
<br>
</select>


</FORM>
</div>
</BODY>
</HTML>


