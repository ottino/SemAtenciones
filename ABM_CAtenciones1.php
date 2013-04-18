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
<TITLE>ABM_CAtenciones1.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>" style="font-size:<?echo $fontdef?>">
<BODY>

<?
echo titulo_encabezado ('Listado de Atenciones' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$plan1 = $_POST["cla_plan"];
$fechad = $_POST["cla_fecha"];
$fechah = $_POST["cla_fecha1"];
$nombre = $_POST["cla_nombre"];
$diag = $_POST["cla_diag"];
$idatencion = $_POST["cla_idatencion"];
$idord = $_POST["cla_ord"];
$idestado = $_POST["cla_estado"];
$imagen_volver = "imagenes/Volver.ico";

if ($_GET["vengo"] == "ATENCION")
{
$plan1 = $_GET["cla_plan"];
$fechad = $_GET["cla_fecha"];
$fechah = $_GET["cla_fecha1"];
$nombre = $_GET["cla_nombre"];
$diag = $_GET["cla_diag"];
$idatencion = $_GET["cla_idatencion"];
$idord = $_GET["cla_ord"];
$idestado = $_GET["cla_estado"];
}


if (substr($fechad,2,1) == "/")
    $fechad = cambiarFormatoFecha2($fechad);

if (substr($fechah,2,1) == "/")
    $fechah = cambiarFormatoFecha2($fechah);

if ($fechah == '')
    $fechah = '2999/12/31';
if ($fechad == '')
    $fechad = '2000/01/01';


$fechad1=  cambiarFormatoFecha1($fechad);
$fechah1=  cambiarFormatoFecha1($fechah);


//Ejecutamos la sentencia SQL

if ($nombre == '')
    $sqlnombre = '';
   else
    $sqlnombre = " and (a.nombre like '%".$nombre."%' or b.nombre like '%".$nombre."%') ";

if ($idatencion > '0')
    $sqlnombre = $sqlnombre." and id = '".$idatencion."' ";

if ($diag > '0')
    $sqlnombre = $sqlnombre." and (diagnostico = '".$diag."' or cod_diagnostico = '".$diag."') ";

if ($idestado == 'A')
    $sqlnombre = $sqlnombre." and motanulacion <> '0' ";
  else
   if ($idestado == 'D')
       $sqlnombre = $sqlnombre." and motanulacion < '1' ";

$sqlnombre1 = " order by id";


 if ($idord == 'I')
     $sqlnombre1 = " order by id desc";

 if ($idord == 'F')
     $sqlnombre1 = " order by fecha desc";

 if ($idord == 'P')
     $sqlnombre1 = " order by plan";

 if ($idord == 'N')
     $sqlnombre1 = " order by nombre";

$comienzo = "SELECT a.fecha, a.plan, a.diagnostico, a.id, a.nombre, a.medico, a.impcoseguro,
 a.color, a.colormedico, a.motanulacion, a.horallam, a.telefono,
 a.edad, a.sexo, a.cta, b.nombre as nombre2 , b.cod_diagnostico as diagnostico2
FROM atenciones a LEFT JOIN clientes_nopadron b ON a.id = b.idatencion";


if ($plan1 < '1')
  {   $result=mysql_query($comienzo." WHERE fecha >= '".$fechad."' and fecha <= '".$fechah."' and a.plan = a.plan ".$sqlnombre."  ".$sqlnombre1." ");
      $lit_plan = "****  TODOS  ****  ";
  }
  else
  {   $result=mysql_query($comienzo."  WHERE fecha >= '".$fechad."' and fecha <= '".$fechah."' and
                      a.plan in (select idplan from planes where idplan = ".$plan1.") ".$sqlnombre."  ".$sqlnombre1." ");
      $lit_plan = $row["descplan"];
   }

$literal = "     LISTADO DEL PLAN: ".$lit_plan."       DESDE ".$fechad1." HASTA ".$fechah1;


echo '<table width="100%">
       <tr> <td>
        <table width="100%" border="1" align="left">
       <tr >
        <td><INPUT TYPE="BUTTON" value="Imprimir" ALIGN ="left" onclick ="window.print()"></td><td><div align="center">'.$literal.'</div>
          </td><td><div align="center"><th> <a href="ABM_CAtenciones.php?"/a> <img border="0" src="imagenes/Volver.ico" width="30" height="30"  align="top" /></th></div></td></tr></tr></table></tr> </td>
           <table width="100%" border="0" align="left">
             <td width="100%" rowspan="3" valign="top" style="background-color:'.$td_color.'"><div align="center">
             <table style="font-size:'.$fontreg.'" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:'.$th_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
               <tr  style="font-size:'.$fontt.'">
            <th>ID</th>
            <th>FECHA</th>
            <th>HS</th>
            <th>PLAN</th>
            <th>NOMBRE</th>
            <th>FONO</th>
            <th>E</th>
            <th>S</th>
            <th>COLOR</th>
            <th>MEDICO</th>
            <th>C.MED</th>
            <th>$ COS</th>
            <th>DIAGNOSTICO</th>
            <th>CONS</th>
            <th>CTA</th>
        </td></tr>';



while ($row=mysql_fetch_array($result))
{

$id = $row["id"] + 0;
echo '<tr><td align="left">'.$id.'</td>';
$fecha  =  cambiarFormatoFecha($row["fecha"]);

$medico  =  buscopersonal($row["medico"]);
$color   =  buscocolor($row["color"]);
$colorm  =  buscocolor($row["colormedico"]);
$diagnostico  =  buscodiagnostico($row["diagnostico"]);

if ($row["motanulacion"] > '0')
{   $medico = 'ANULADO';
   $diagnostico = buscoanulacion($row["motanulacion"]);
}

$horallam = cambiarFormatoHora($row["horallam"]);
echo '<td align="left">'.$fecha.'&nbsp;</td>';
echo '<td align="right">'.$horallam.'&nbsp;</td>';
echo '<td align="left">'.$row["descabrev"].'&nbsp;</td>';
echo '<td align="left">'.$row["nombre"].'&nbsp;</td>';
echo '<td align="left">'.$row["telefono"].'&nbsp;</td>';
echo '<td align="right">'.$row["edad"].'&nbsp;</td>';
echo '<td align="left">'.$row["sexo"].'&nbsp;</td>';
echo '<td align="left">'.$color.'&nbsp;</td>';
echo '<td align="left">'.$medico.'&nbsp;</td>';
echo '<td align="left">'.$colorm.'&nbsp;</td>';
echo '<td align="right">'.$row[impcoseguro].'&nbsp;</td>';
echo '<td align="left">'.$diagnostico.'&nbsp;</td>';
echo '<FORM METHOD="POST" NAME="formulario2" ACTION="C_Atenciones.php">';
echo '<input type="hidden" name= "pasaid" value="'.$id.'" >';
echo '<input type="hidden" name= "pasguardia" value="'.$row["idguardia"].'" >';
echo '<input type="hidden" name= "cla_plan" value="'.$plan1.'" >';
echo '<input type="hidden" name= "cla_fecha" value="'.$fechad.'" >';
echo '<input type="hidden" name= "cla_fecha1" value="'.$fechah.'" >';
echo '<input type="hidden" name= "cla_nombre" value="'.$nombre.'" >';
echo '<input type="hidden" name= "cla_diag" value="'.$diag.'" >';
echo '<input type="hidden" name= "cla_idatencion" value="'.$idatencion.'" >';
echo '<input type="hidden" name= "vengo" value="ATENCION" >';
echo '<input type="hidden" name= "cla_ord" value="'.$idord.'" >';
echo '<input type="hidden" name= "cla_estado" value="'.$idestado.'" >';
echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Consultar\' src="imagenes/INSERTAR.ICO" width="40" height="40"/>
                    </label>
                  </td>';
echo '</FORM></FORM>';
echo '<FORM METHOD="POST" NAME="formulario2" ACTION="A_Ctatenciones.php">';
echo '<input type="hidden" name= "pasaid" value="'.$id.'" >';

if ($row["cta"] < '1' and $row["motanulacion"] < '1')
    echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label onclick="this.form.submit();" style="CURSOR: pointer" >
                     <img align="middle" alt=\'Cierre Telefónico\' src="imagenes/Phone 4.ico" width="30" height="30"/>
                    </label>
                  </td></tr>';
   else
    echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                    <label>
                     <img align="middle" alt=\'Cerrado\' src="imagenes/PHONE2.ICO" width="30" height="30"/>
                    </label>
                  </td></tr>';


echo '</FORM>';

$resulta=mysql_query("select * from clientes_nopadron WHERE idatencion = ".$id." order by idatencion, idnopadron");
while ($rowa=mysql_fetch_array($resulta))
 {
  $diagnostico  =  buscodiagnostico($rowa["cod_diagnostico"]);


   $fecha1 = 'SIMULT';
   echo '<tr><td align="left">'.$id.'&nbsp;</td>';
   echo '<td align="left">'.$fecha1.'&nbsp;</td>';
   echo '<td align="right">'.$horallam.'&nbsp;</td>';
   echo '<td align="left">'.$row["descabrev"].'&nbsp;</td>';
   echo '<td align="left">'.$rowa["nombre"].'&nbsp;</td>';
   echo '<td align="left">'.$row["telefono1"].'&nbsp;</td>';
   echo '<td align="right">'.$rowa["edad"].'&nbsp;</td>';
   echo '<td align="left">'.$rowa["sexo"].'&nbsp;</td>';
   echo '<td align="right">'.$p.'&nbsp;</td>';
   echo '<td align="right">'.$p.'&nbsp;</td>';
   echo '<td align="right">'.$p.'&nbsp;</td>';
   echo '<td align="right">'.$p.'&nbsp;</td>';
   echo '<td align="left">'.$diagnostico.'&nbsp;</td>';
   echo '<td align="right">'.$p.'&nbsp;</td>';
   echo '<td align="right">'.$p.'&nbsp;</td></tr>';
 }
   mysql_free_result($resulta);

}

mysql_free_result($result);

?>

</table>
</table>


</BODY>
</HTML>