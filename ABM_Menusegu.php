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
<TITLE>ABM_Menusegu.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>" style="font-size:<?echo $fontef?>">
<BODY>


<?
echo titulo_encabezado ('ABM de Seguridad de Menúes' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

//Ejecutamos la sentencia SQL
$result=mysql_query("select * from segmenu order by 2");

echo '</p><table ><tr style="background-color:'.$td_color.'"><td>';
echo '<FORM METHOD="POST" NAME="formulario3" ACTION="A_Menusegu.php">';
echo '<table width="20%" border = 1 align="left" cellpadding="5" cellspacing="5" style="background-color:'.$td_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0"><tr>';
echo ' <td><td width="25" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Agregar Seguridad\' src="imagenes/seguok.ico" width="50" height="40"/>
                    </label>
                  </td></td>';
echo '</FORM>';
echo'</table></table>';

echo '
<table width="100%" border="1" align="left">
  <tr style="background-color:'.$td_color.'">
    <td width="100%" rowspan="3" valign="top"><div align="center">
      <table style="font-size:'.$fontreg.'" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
          <tr style="font-size:'.$fontt.'">
            <th>ID</th>
            <th>Programa</th>
            <th>Perfil 1</th>
            <th>Perfil 2</th>
            <th>Perfil 3</th>
            <th>Perfil 4</th>
            <th>Perfil 5</th>
            <th>Perfil 6</th>
            <th>Perfil 7</th>
            <th>Perfil 8</th>
            <th>Perfil 9</th>
            <th>Perfil 10</th>
            <th>Perfil 11</th>
            <th>Perfil 12</th>
            <th>Perfil 13</th>
            <th>Perfil 14</th>
            <th>Perfil 15</th>
            <th>Borrar</th>
            <th>Editar</th>
        </td>';


//Mostramos los registros
while ($row=mysql_fetch_array($result))
{
echo '<tr><td>'.$row["idsegmenu"].'</td>';
echo '<td>'.$row["pagina"].'</td>';
echo '<td>'.$row["p1"].'</td>';
echo '<td>'.$row["p2"].'</td>';
echo '<td>'.$row["p3"].'</td>';
echo '<td>'.$row["p4"].'</td>';
echo '<td>'.$row["p5"].'</td>';
echo '<td>'.$row["p6"].'</td>';
echo '<td>'.$row["p7"].'</td>';
echo '<td>'.$row["p8"].'</td>';
echo '<td>'.$row["p9"].'</td>';
echo '<td>'.$row["p10"].'</td>';
echo '<td>'.$row["p11"].'</td>';
echo '<td>'.$row["p12"].'</td>';
echo '<td>'.$row["p13"].'</td>';
echo '<td>'.$row["p14"].'</td>';
echo '<td>'.$row["p15"].'</td>';


$idsegmenu = $row["idsegmenu"];

echo '<FORM METHOD="POST" NAME="formulario2" ACTION="B_Menusegu.php">';
echo '<input type="hidden" name= "pasmenu" value="'.$idsegmenu.'" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Borrar\' src="imagenes/102.ICO" width="30" height="30"/>
                    </label>
                  </td>';
echo '</FORM>';

echo '<FORM METHOD="POST" NAME="formulario2" ACTION="M_Menusegu.php">';
echo '<input type="hidden" name= "pasmenu" value="'.$idsegmenu.'" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
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