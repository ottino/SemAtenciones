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
<TITLE>ABM_Contratos.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>" style="font-size:<?echo $fontef?>">
<BODY>


<?
echo titulo_encabezado ('ABM de Contratos' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$idplan  = $_POST["cla_plan"];
$nombre  = $_POST["cla_nombre"];
$fecha  = $_POST["cla_fecha"];

 if ($nombre <> '')
     $sqlnombre = " and (b.nombre like '%".$nombre."%' or a.idcontrato like '%".$nombre."%')";

if ($idplan > '0')
     $sqlnombre = $sqlnombre." and tipocontrato = '".$idplan."' ";

if ($fecha > '1900-01-01')
     $sqlnombre = $sqlnombre." and fecvto <= '".$fecha."' ";


//Ejecutamos la sentencia SQL
$result=mysql_query("select * from contratos a, clientes b, planes c
                     where a.idcliente = b.idcliente and a.idplan = c.idplan ".$sqlnombre." order by nombre");

echo '</p><table ><tr><td>';
echo '<FORM METHOD="POST" NAME="formulario3" ACTION="A_Contratos.php">';
echo '<table width="100%" border = 0 align="left" cellpadding="5" cellspacing="5" style="background-color:'.$body_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0"><tr>';
echo ' <td><td width="25" align="center" style="background-color:'.$body_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Nuevo Contratos\' src="imagenes/contratos.ico" width="50" height="40"/>
                    </label>
                  </td></td>';
echo '<td width="1000"></td><td width="60"><div align="left"><th> <a href="ABM_Contratos0.php?"/a> <img border="0" src="imagenes/Volver.ico" width="30" height="30"  align="top" /></th></div></td>';
echo '</FORM>';
echo'</table></table>';

echo'
<table width="100%" border="1" align="left">
<tr style="background-color:'.$td_color.'">
    <td width="100%" rowspan="3" valign="top"><div align="center">
      <table style="font-size:'.$fontreg.'" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:'.$th_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
          <tr style="font-size:'.$fontt.'">
            <th>Contrato</th>
            <th>Afiliado</th>
            <th>Nombre</th>
            <th>Estado</th>
            <th>F.Alta</th>
            <th>F.Vto</th>
            <th>Ult.Pago</th>
            <th>Deuda</th>
            <th>Plan</th>
            <th>Padrón</th>
            <th>Borrar</th>
            <th>Editar</th>
            <th>Adic.</th>
        </td>';

//Mostramos los registros
while ($row=mysql_fetch_array($result))
{
echo '<tr><td>'.$row["idcontrato"].'</td>';
echo '<td>'.$row["nroafiliado"].'</td>';
echo '<td>'.$row["nombre"].'</td>';
$fecalta = cambiarFormatoFecha($row[3]);
$fecvto = cambiarFormatoFecha($row[4]);

if ($row[14] == 'A')
   $estado = 'ACTIVO';

if ($row[14] == 'B')
   $estado = 'BAJA';

echo '<td>'.$estado.'</td>';

echo '<td>'.$fecalta.'</td>';
echo '<td>'.$fecvto.'</td>';
echo '<td>'.$row["upp"].'</td>';
echo '<td align="right">'.$row["deuda"].'</td>';
echo '<td>'.$row["descabrev"].'</td>';
echo '<td>'.$row["ordenmax"].'</td>';

$idcon = $row["idcontrato"];
$idcli = $row["idcliente"];

echo '<FORM METHOD="POST" NAME="formulario2" ACTION="B_Contratos.php">';
echo '<input type="hidden" name= "pasacont" value="'.$idcon.'" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Borrar\' src="imagenes/102.ICO" width="30" height="30"/>
                    </label>
                  </td>';
echo '</FORM>';

echo '<FORM METHOD="POST" NAME="formulario2" ACTION="M_Contratos.php">';
echo '<input type="hidden" name= "pasacont" value="'.$idcon.'" >';
echo '<input type="hidden" name= "cla_plan" value="'.$idplan.'" >';
echo '<input type="hidden" name= "cla_nombre" value="'.$nombre.'" >';
echo '<input type="hidden" name= "cla_fecha" value="'.$fecha.'" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Modificar\' src="imagenes/editar.png" width="30" height="30"/>
                    </label>
                  </td>';
echo '</FORM>';

echo '<FORM METHOD="POST" NAME="formulario2" ACTION="ABM_Adicionales.php">';
echo '<input type="hidden" name= "pasacont" value="'.$idcon.'" >';
echo '<input type="hidden" name= "pasacli" value="'.$idcli.'" >';
echo '<input type="hidden" name= "cla_plan" value="'.$idplan.'" >';
echo '<input type="hidden" name= "cla_nombre" value="'.$nombre.'" >';
echo '<input type="hidden" name= "cla_fecha" value="'.$fecha.'" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'ABM Adicionales\' src="imagenes/adicionales.ico" width="30" height="30"/>
                    </label>
                  </td>';
echo '</FORM>';

}

mysql_free_result($result)


?>

</table>


</BODY>
</HTML>