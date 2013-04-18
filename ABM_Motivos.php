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
<TITLE>ABM_Motivos.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>">
<BODY>


<?
echo titulo_encabezado ('ABM de Motivos' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

//Ejecutamos la sentencia SQL
$result=mysql_query("select * from motivos order by 1,2");


echo '</p><table ><tr><td>';
echo '<FORM METHOD="POST" NAME="formulario3" ACTION="A_Motivos.php">';
echo '<input type="hidden" name= "pasacont" value="'.$idcon.'" >';
echo '<table width="100%" border = 1 align="left" cellpadding="5" cellspacing="5" style="background-color:<?echo $th_color?>;border-left-width: 0; border-top-width: 0; border-bottom-width: 0"><tr>';
echo ' <td><td align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Nuevo Motivo\' src="imagenes/172.ico" width="50" height="40"/>
                    </label>
                  </td></td>';
echo '</FORM>';
echo'</table></table>';
echo'
<table width="80%" border="1" align="left">
  <tr>
    <td width="100%" rowspan="3" valign="top"><div align="center">
      <table border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:'.$th_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
          <tr>
            <th>Cod. Color</th>
            <th>Cod. Motivo</th>
            <th>Descripcion</th>
            <th>Borrar</th>
            <th>Mod</th>
        </td>';


//Mostramos los registros
while ($row=mysql_fetch_array($result))
{

echo '<tr><td>'.$row["idmotivo"].'</td>';
echo '<td>'.$row["idmotivo2"].'</td>';

$motivos = $row["idmotivo"].'-'.$row["idmotivo2"];

echo '<td>'.$row["desc"].'&nbsp;</td>';

echo '<FORM METHOD="POST" NAME="formulario2" ACTION="B_Motivos.php">';
echo '<input type="hidden" name= "pasmotivo" value="'.$motivos.'" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Borrar\' src="imagenes/102.ICO" width="30" height="30"/>
                    </label>
                  </td>';
echo '</FORM>';

echo '<FORM METHOD="POST" NAME="formulario2" ACTION="M_Motivos.php">';
echo '<input type="hidden" name= "pasmotivo" value="'.$motivos.'" >';
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