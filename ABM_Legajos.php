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
<TITLE>ABM_Legajos.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>" style="font-size:<?echo $fontef?>">
<BODY>


<?
echo titulo_encabezado ('ABM de Personal' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

//Ejecutamos la sentencia SQL
$result=mysql_query("SELECT * FROM legajos a, funciones b, perfiles c WHERE
a.funcion = b.idfunciones and a.perfil = c.idperfiles and a.estado <> '1' order by 2");
?>
</p>
<?
echo '<table ><tr><td>';
echo '<FORM METHOD="POST" NAME="formulario3" ACTION="A_Legajos.php">';
echo '<table width="20%" border = 1 align="left" cellpadding="5" cellspacing="5" style="background-color:'.$body_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0"><tr>';
echo ' <td><td width="25" align="center" style="background-color:'.$td_color.'" style="CURSOR: pointer" >
                    <label onclick="this.form.submit();">
                     <img align="middle" alt=\'Nuevo Personal\' src="imagenes/086.ico" width="50" height="40"/>
                    </label>
                  </td></td>';
echo'</table></table>';

echo '</FORM>';

echo'
<table width="100%" border="1" align="left">
  <tr style="background-color:'.$td_color.'">
    <td width="100%" rowspan="3" valign="top"><div align="center">
      <table style="font-size:'.$fontreg.'" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:'.$th_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
          <tr style="font-size:'.$fontt.'">
            <th>LEGAJO</th>
            <th>APELLIDO Y NOMBRES</th>
            <th>SEXO</th>
            <th>DNI</th>
            <th>CUIT/CUIL</th>
            <th>FECHA NAC</th>
            <th>FUNCION</th>
            <th>MATR.</th>
            <th>PERFIL</th>
            <th>CONS</th>
            <th>BOR</th>
            <th>MOD</th>
        </td>';

//Mostramos los registros
while ($row=mysql_fetch_array($result))
{

echo '<tr><td>'.$row["legajo"].'&nbsp;</td>';
echo '<td>'.$row["apeynomb"].'&nbsp;</td>';
echo '<td>'.$row["sexo"].'&nbsp;</td>';
echo '<td>'.$row["dni"].'&nbsp;</td>';
echo '<td>'.$row["cuit"].'&nbsp;</td>';
$fecalta = cambiarFormatoFecha($row["fecnac"]);

echo '<td>'.$fecalta.'</td>';
echo '<td>'.$row["funciones"].'&nbsp;</td>';
echo '<td>'.$row["matricula"].'&nbsp;</td>';
echo '<td>'.$row["perfiles"].'&nbsp;</td>';

$legajos = $row["legajo"];

echo '<FORM METHOD="POST" NAME="formulario2" ACTION="C_Legajos.php">';
echo '<input type="hidden" name= "paslegajos" value="'.$legajos.'" >';
echo '<input type="hidden" name= "vengo" value="A" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Consultar\' src="imagenes/INSERTAR.ICO" width="30" height="30"/>
                    </label>
                  </td>';
echo '</FORM>';

echo '<FORM METHOD="POST" NAME="formulario2" ACTION="B_Legajos.php">';
echo '<input type="hidden" name= "paslegajos" value="'.$legajos.'" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Borrar\' src="imagenes/102.ICO" width="30" height="30"/>
                    </label>
                  </td>';
echo '</FORM>';

echo '<FORM METHOD="POST" NAME="formulario2" ACTION="M_Legajos.php">';
echo '<input type="hidden" name= "paslegajos" value="'.$legajos.'" >';
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