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
require_once("cookie.php");
require_once("config.php");
$cookie = new cookieClass;
$G_usuario = $cookie->get("usuario");
$G_legajo  = $cookie->get("legajo");
$G_perfil  = $cookie->get("perfil");
################### Conexion a la base de datos##########################

$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
?>


<HTML>
<HEAD>
<TITLE>ABM_Adicionales.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>" style="font-size:<?echo $fontef?>">
<BODY>


<?
echo titulo_encabezado ('ABM de Adicionales' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$idcontrato1 = $_GET["pasacont"];
$idcontrato = $_POST["pasacont"];
$idcon = $_POST["pasacont"];
$idplan  = $_POST["cla_plan"];
$nombre  = $_POST["cla_nombre"];
$fecha  = $_POST["cla_fecha"];


if ($idcontrato1 > '0')
{ $idcontrato = $idcontrato1;
  $idcon      = $idcontrato1;
}


//Ejecutamos la sentencia SQL
$result=mysql_query("select * from contratos a, clientes b, planes c
                     where a.idcliente = b.idcliente and
                     a.idplan = c.idplan and a.idcontrato = '".$idcontrato."'");
$row=mysql_fetch_array($result);
$ppalnombre = $row["nombre"];
$descplan   = $row["descplan"];
$ordenmax   = $row["ordenmax"];



$result=mysql_query("select * from cliadicionales a, contratos b, clientes c, planes d
                     where a.idcontrato = b.idcontrato and a.idpadron = c.idcliente and
                     b.idplan = d.idplan and a.idcontrato = '".$idcontrato."' order by 1, 2 ");

echo '</p><table width="100%"><tr><td>';
echo '<FORM METHOD="POST" NAME="formulario3" ACTION="A_Adicionales.php">';
echo '<input type="hidden" name= "pasacont" value="'.$idcon.'" >';
echo '<table width="100%" border = 1 align="left" cellpadding="5" cellspacing="5" style="background-color:'.$body_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0"><tr>';
echo ' <td><td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Nuevo Adicional\' src="imagenes/contratos.ico" width="50" height="40"/>
                    </label>
                  </td></td>';
echo '<td>'.$idcontrato.'</td>';
echo '<td>'.$ppalnombre.'</td>';
echo '<td>'.$descplan.'</td>';
echo '<td>'.$ordenmax.'</td>';
echo '</FORM>';

echo '<td width="500" style="border:"0"><FORM METHOD="POST" NAME="formulario2" ACTION="ABM_Contratos.php">';
echo '<input type="hidden" name= "cla_plan" value="'.$idplan.'" >';
echo '<input type="hidden" name= "cla_nombre" value="'.$nombre.'" >';
echo '<input type="hidden" name= "cla_fecha" value="'.$fecha.'" >';
echo ' <td width="17" style="border:"1" style="background-color:'.$body_color.'">
                <label onclick="this.form.submit();" style="CURSOR: pointer" >
                 <img align="middle" alt=\'Volver\' src="imagenes/Volver.ico" width="30" height="30"/>
                </label></td>';
echo '</FORM></TD>';

echo'</table></table>';

echo'
<table width="80%" border="1" align="left">
  <tr style="background-color:'.$td_color.'">
    <td width="100%" rowspan="3" valign="top"><div align="center">
      <table style="font-size:'.$fontreg.'" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:'.$th_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
           <tr style="font-size:'.$fontt.'; background-color:'.$td_color.'">
            <th>Afiliado</th>
            <th>Nombre</th>
            <th>Documento</th>
            <th>F.Nacimiento</th>
            <th>Plan</th>
            <th>Borrar</th>
            <th>Editar</th>
        </td>';

//Mostramos los registros
while ($row=mysql_fetch_array($result))
{
echo '<tr><td>'.$row["nroafiliado"].'</td>';
echo '<td>'.$row["nombre"].'</td>';
echo '<td>'.$row["documento"].'</td>';
$fecnac = cambiarFormatoFecha($row['fnacimiento']);
echo '<td>'.$fecnac.'</td>';
echo '<td>'.$row["descabrev"].'</td>';

$idcon = $row["idcontrato"];

echo '<FORM METHOD="POST" NAME="formulario2" ACTION="B_Adicionales.php">';
echo '<input type="hidden" name= "pasacont" value="'.$idcon.'" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Borrar\' src="imagenes/102.ICO" width="30" height="30"/>
                    </label>
                  </td>';
echo '</FORM>';

echo '<FORM METHOD="POST" NAME="formulario2" ACTION="M_Adicionales.php">';
echo '<input type="hidden" name= "pasacont" value="'.$idcon.'" >';
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