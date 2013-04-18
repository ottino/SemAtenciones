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
<TITLE>ABM_Planes.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>" style="font-size:<?echo $fontef?>">
<BODY>


<?
echo titulo_encabezado ('ABM de Planes' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

//Ejecutamos la sentencia SQL

$idplan  = $_POST["cla_plan"];
$nombre  = $_POST["cla_nombre"];


 if ($nombre <> '')
     $sqlnombre = " and (descplan like '%".$nombre."%' or idplan like '%".$nombre."%') ";

if ($idplan > '0')
     $sqlnombre = " and idplan = '".$idplan."' ";

$result=mysql_query("select * from planes where estado <> 'J' ".$sqlnombre." order by 1+0");

echo '</p>';
echo '<table ><tr><td>';
echo '<FORM METHOD="POST" NAME="formulario3" ACTION="A_Planes.php">';
echo '<table width="20%" border = 1 align="left" cellpadding="5" cellspacing="5" style="background-color:'.$body_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0"><tr>';
echo ' <td><td width="25" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Nuevo Plan\' src="imagenes/contratos.ico" width="50" height="40"/>
                    </label>
                  </td></td>';
echo'</table></table>';
echo '</FORM>';

echo'
<table width="80%" border="1" align="left">
  <tr style="background-color:'.$td_color.'">
    <td width="100%" rowspan="3" valign="top"><div align="center">
      <table style="font-size:'.$fontreg.'" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:'.$th_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
          <tr style="font-size:'.$fontt.'">
            <th>ID Plan</th>
            <th>Desc. Plan</th>
            <th>Estado</th>
            <th>F. Alta</th>
            <th>F. Baja</th>
            <th>Borrar</th>
            <th>Editar</th>
        </td>';


//Mostramos los registros
while ($row=mysql_fetch_array($result))
{

echo '<tr><td>'.$row["idplan"].'</td>';
echo '<td>'.$row["descplan"].'</td>';
if ($row["estado"] == 'B')
     echo '<td>BAJA</td>';
    else
     echo '<td>ACTIVO</td>';


$fecalta = cambiarFormatoFecha($row["fecalta"]);
echo '<td>'.$fecalta.'</td>';
$fecbaja = cambiarFormatoFecha($row["fecbaja"]);
echo '<td>'.$fecbaja.'</td>';

$idplan = $row["idplan"];

echo '<FORM METHOD="POST" NAME="formulario2" ACTION="B_Planes.php">';
echo '<input type="hidden" name= "pasaplan" value="'.$idplan.'" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Borrar\' src="imagenes/102.ICO" width="30" height="30"/>
                    </label>
                  </td>';
echo '</FORM>';

echo '<FORM METHOD="POST" NAME="formulario2" ACTION="M_Planes.php">';
echo '<input type="hidden" name= "pasaplan" value="'.$idplan.'" >';
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