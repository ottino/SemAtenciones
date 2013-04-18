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
<TITLE>L_Atencionespend.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>" style="font-size:<?echo $fontef?>">
<BODY>

<?
echo titulo_encabezado ('Listado de Atenciones Pendientes' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

//Ejecutamos la sentencia SQL

$result=mysql_query("SELECT * FROM atenciones_temp, colores WHERE color = idcolor  AND abierta <> '2' AND traslado_aux <= now( ) ORDER BY orden ASC , id ASC");

$literal = "     LISTADO DE ATENCIONES Y TRASLADOS PENDIENTES      ";

?>
</p>

<table width="100%">
 <tr> <td>
  <table width="100%" border="1" align="left">
  <tr>
    <td><INPUT TYPE="BUTTON" value="Imprimir" ALIGN ="left" onclick ="window.print()"></td><td><div align="center"><?echo $literal ?></div></td>
    <td style="width:60px"><th> <a href="javascript:history.back(1)"</a> <img border="0" src="imagenes/Volver.ico" width="30" height="30"  align="top" /></th></td>
      </td></tr></tr></table></tr> </td>
  <table width="100%" border="1" align="left">
    <td width="100%" rowspan="3" valign="top"><div align="center">
      <table style="font-size:12px"border = "1" cellspacing="1" cellpadding="1" align="left" >
          <tr style="font-size:12px">
            <th>ID</th>
            <th>FECHA</th>
            <th>LLAM</th>
            <th>NOMBRE</th>
            <th>E</th>
            <th>S</th>
            <th>DOMICILIO</th>
            <th>LOCALIDAD</th>
            <th>ZONA</th>
            <th>FONO</th>
            <th>PLAN</th>
            <th>COL</th>
            <th>MOTIVO</th>
        </tr>

<?

$totanul = '0';
$totaten = '0';
$totadi  = '0';

while ($row=mysql_fetch_array($result))
{

$id = $row["id"] + 0;
$fecha  =  cambiarFormatoFecha($row["fecha"]);
$color   =  buscocolor($row["color"]);
$motivo  =  buscomotivo($row["motivo1"],$row["motivo2"]);
$zona    =  buscozona($row["zona"]);
$horallam = cambiarFormatoHora($row["horallam"]);
$plan    =  buscoplan($row["plan"]);

 if ($row['piso'] == '')
  {
   $mpiso = '';
  } else $mpiso = ' - Piso: ';

 if ($row['depto'] == '')
  {
   $mdepto = '';
  } else $mdepto = ' - Dpto: ';



echo '<tr><td align="center" width="47">'.$id.'</td>';
echo '<td align="center" width="67">'.$fecha.'</td>';
echo '<td align="center" width="47">'.$horallam.'</td>';
echo '<td align="left" width="127">'.substr($row["nombre"],0,15).'</td>';
echo '<td align="right" width="27">'.$row["edad"].'</td>';
echo '<td align="left" width="27">'.$row["sexo"].'</td>';
echo '<td align="left" width="297">'.$row["calle"].' - '.$row["numero"].$mpiso.$row["piso"].$mdepto.$row["depto"].' - '.$row["barrio"].'</td>';
echo '<td align="left">'.substr($row["localidad"],0,12).'</td>';
echo '<td align="left">'.substr($zona,0,10).'</td>';
echo '<td align="left">'.$row["telefono"].'</td>';
echo '<td align="left">'.substr($plan,0,15).'</td>';
echo '<td align="center" width="57">'.substr($color,0,5).'</td>';
echo '<td align="left">'.substr($motivo,0,25).'</td></tr>';

}

echo '</table></tD></table></TR></table></table>';
mysql_free_result($result);

?>

</BODY>
</HTML>