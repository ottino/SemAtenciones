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
<TITLE>ABM_Destinos.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>" style="font-size:<?echo $fontef?>">
<BODY>


<?
echo titulo_encabezado ('ABM de Destinos' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }
//Ejecutamos la sentencia SQL  BgColor="#d0d0d0"
$result=mysql_query("select * from destino order by 1");

echo '</p><table ><tr><td>';
echo '<FORM METHOD="POST" NAME="formulario3" ACTION="A_Destinos.php">';
echo '<table width="20%" border = 1 align="left" cellpadding="5" cellspacing="5" style="background-color:'.$body_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0"><tr>';
echo ' <td><td width="25" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Nuevo Destino\' src="imagenes/inicio.png" width="50" height="40"/>
                    </label>
                  </td></td>';
echo '</FORM>';
echo'</table></table>';

echo'
<table width="100%" border="1" align="left">
  <tr style="background-color:'.$td_color.'">
    <td width="100%" rowspan="3" valign="top"><div align="center">
      <table style="font-size:'.$fontreg.'" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:'.$th_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
          <tr style="font-size:'.$fontt.'">
            <th>ID Destino</th>
            <th>Destino</th>
            <th>Domicilio</th>
            <th>Localidad</th>
            <th>Telefono</th>
            <th>Tipo</th>
            <th>Borrar</th>
            <th>Modif</th>
        </td>';


//Mostramos los registros
while ($row=mysql_fetch_array($result))
{

echo '<tr><td>'.$row["iddestino"].'</td>';
echo '<td>'.$row["destino"].'&nbsp;</td>';
echo '<td>'.$row["domicilio"].'&nbsp;</td>';
echo '<td>'.$row["localidad"].'&nbsp;</td>';
echo '<td>'.$row["telefono"].'&nbsp;</td>';
echo '<td>'.$row["tipo"].'&nbsp;</td>';

$destino = $row["iddestino"];

echo '<FORM METHOD="POST" NAME="formulario2" ACTION="B_Destinos.php">';
echo '<input type="hidden" name= "pasdestino" value="'.$destino.'" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Borrar\' src="imagenes/102.ICO" width="30" height="30"/>
                    </label>
                  </td>';
echo '</FORM>';

echo '<FORM METHOD="POST" NAME="formulario2" ACTION="M_Destinos.php">';
echo '<input type="hidden" name= "pasdestino" value="'.$destino.'" >';
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