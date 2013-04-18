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
<TITLE>ABM_Guardias2.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>


<?
echo titulo_encabezado ('ABM de Guardias' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$mes = explode("-", $_POST[meses]);
$leg = $_POST[legajo];

//Ejecutamos la sentencia SQL
$result= mysql_query("select * from guardias a, legajos b, bases c WHERE
         a.legajo = b.legajo and a.base = c.idbases and a.legajo = ".$_POST[legajo]." order by 3,4");

echo '</p><table ><tr><td>';
echo '<FORM METHOD="POST" NAME="formulario3" ACTION="A_Guardias.php">';
echo '<input type="hidden" name= "paslegajo" value="'.$leg.'" >';
echo '<table width="100%" border = 1 align="left" cellpadding="5" cellspacing="5" style="background-color:<?echo $th_color?>;border-left-width: 0; border-top-width: 0; border-bottom-width: 0"><tr>';
echo ' <td><td align="center" style="background-color:'.$td_color.'" style="CURSOR: hand" >
                    <label onclick="this.form.submit();">
                     <img align="middle" alt=\'Cargar Guardias\' src="imagenes/GUARDIAS.ICO" width="50" height="40"/>
                    </label>
                  </td></td>';
echo '</FORM>';
echo'</table></table>';

?>

<table width="100%" border="1" align="left">
  <tr>
    <td width="100%" rowspan="3" valign="top"><div align="center">
      <table style="font-size:<?echo $fontreg?>" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:<?echo $th_color?>;border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
          <tr style="font-size:<?echo $fontt?>">
            <th>LEGAJO</th>
            <th>APELLIDO Y NOMBRES</th>
            <th>F. INGRESO</th>
            <th>H. INGRESO</th>
            <th>F.SALIDA</th>
            <th>H.SALIDA</th>
            <th>BASE</th>
            <th>BOR</th>
            <th>MOD</th>
        </td>

<?
//Mostramos los registros
while ($row=mysql_fetch_array($result))
{

$fecingreso = cambiarFormatoFecha($row['fecingreso']);
$fecsalida  = cambiarFormatoFecha($row['fecsalida']);
$horaingreso = cambiarFormatoHora($row['horaingreso']);
$horasalida = cambiarFormatoHora($row['horasalida']);

echo '<tr><td align="center">'.$row["legajo"].'</td>';
echo '<td align="center">'.$row["apeynomb"].'</td>';
echo '<td align="center">'.$fecingreso.'</td>';
echo '<td align="center">'.$horaingreso.'</td>';
echo '<td align="center">'.$fecsalida.'</td>';
echo '<td align="center">'.$horasalida.'</td>';
echo '<td align="center">'.$row["descbases"].'</td>';

$idguardia = $row["idguardia"];

echo '<FORM METHOD="POST" NAME="formulario2" ACTION="B_Guardias.php">';
echo '<input type="hidden" name= "pasguardia" value="'.$idguardia.'" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.'" style="CURSOR: hand" >
                    <label onclick="this.form.submit();">
                     <img align="middle" alt=\'Borrar\' src="imagenes/102.ICO" width="30" height="30"/>
                    </label>
                  </td>';
echo '</FORM>';

echo '<FORM METHOD="POST" NAME="formulario2" ACTION="M_Guardias.php">';
echo '<input type="hidden" name= "pasguardia" value="'.$idguardia.'" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.'" style="CURSOR: hand" >
                    <label onclick="this.form.submit();">
                     <img align="middle" alt=\'Modificar\' src="imagenes/editar.png" width="30" height="30"/>
                    </label>
                  </td>';
echo '</FORM>';

}

mysql_free_result($result)


?>

</table>


</BODY>
</HTML>