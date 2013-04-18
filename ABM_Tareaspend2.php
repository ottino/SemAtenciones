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
<TITLE>ABM_Tareaspend2.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>


<?
echo titulo_encabezado ('Mantenimiento pendiente' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }


$movil = $_POST["movil"];

if ($movil > '0')
 {
  $result= mysql_query("select * from tareaspend a, moviles b, tareas c, proveedores d where
         a.idmovil = b.idmovil and a.idtarea = c.idtarea and a.idproveedor = d.idproveedores and a.idmovil = '".$movil."' order by 1 ");

   echo '</p><table ><tr><td>';
   echo '<FORM METHOD="POST" NAME="formulario3" ACTION="A_Tareaspend.php">';
   echo '<input type="hidden" name= "pasmovil" value="'.$movil.'" >';
   echo '<table width="100%" border = 1 align="left" cellpadding="5" cellspacing="5" style="background-color:'.$body_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0"><tr>';
   echo ' <td><td align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Nuevo Mantenimiento Pendiente\' src="imagenes/MANTPEND.ICO" width="50" height="40"/>
                    </label>
                  </td></td>';
   echo '<td width="1000"></td><td width="60"><div align="left"><th> <a href="ABM_Tareaspend.php?"/a> <img border="0" src="imagenes/Volver.ico" width="30" height="30"  align="top" /></th></div></td>';
   echo '</FORM>';
   echo'</table></table>';
 }
else
 {
  $result= mysql_query("select * from tareaspend a, moviles b, tareas c, proveedores d where
         a.idmovil = b.idmovil and a.idtarea = c.idtarea and a.idproveedor = d.idproveedores order by fecha desc ");

   echo '</p><table ><tr><td>';
   echo '<INPUT TYPE="BUTTON" value="Imprimir" ALIGN ="left" onclick ="window.print()">';
   echo'</table>';
 }

echo '
<table width="100%" border="1" align="left">
  <tr style="background-color:'.$td_color.'">
    <td width="100%" rowspan="3" valign="top"><div align="center">
      <table style="font-size:'.$fontreg.'" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:'.$th_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
          <tr style="font-size:'.$fontt.'">
            <th>MOVIL</th>
            <th>TAREA</th>
            <th>FECHA</th>
            <th>KM</th>
            <th>PROVEEDOR</th>
            <th>CONF</th>
            <th>BOR</th>
            <th>MOD</th>
        </td>';

//Mostramos los registros
while ($row=mysql_fetch_array($result))
{

$fecha = cambiarFormatoFecha($row['fecha']);

echo '<tr><td align="center">'.$row["idmovil"].' - '.$row["descmovil"].'</td>';
echo '<td align="left">'.$row["idtarea"].' - '.$row["desctarea"].'</td>';
echo '<td align="center">'.$fecha.'</td>';
echo '<td align="center">'.$row["km"].'</td>';
echo '<td align="center">'.$row["proveedores"].'</td>';

$idnovedad = $row["id"];

echo '<FORM METHOD="POST" NAME="formulario2" ACTION="A_Tareasconf.php">';
echo '<input type="hidden" name= "pasatareapend" value="'.$idnovedad.'" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Confirmar\' src="imagenes/MANTREAL.ICO" width="30" height="30"/>
                    </label>
                  </td>';
echo '</FORM>';

echo '<FORM METHOD="POST" NAME="formulario2" ACTION="B_Tareaspend.php">';
echo '<input type="hidden" name= "pasatareapend" value="'.$idnovedad.'" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Borrar\' src="imagenes/102.ICO" width="30" height="30"/>
                    </label>
                  </td>';
echo '</FORM>';

echo '<FORM METHOD="POST" NAME="formulario2" ACTION="M_Tareaspend.php">';
echo '<input type="hidden" name= "pasatareapend" value="'.$idnovedad.'" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Editar\' src="imagenes/editar.png" width="30" height="30"/>
                    </label>
                  </td>';
echo '</FORM>';


}

mysql_free_result($result)


?>

</table>


</BODY>
</HTML>