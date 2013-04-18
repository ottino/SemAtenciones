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
<TITLE>L_Estadisticas2.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>" style="font-size:<?echo $fontef?>">
<BODY>

<?
echo titulo_encabezado ('Listado de Atenciones' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }


$lestad1      = $_POST["lestad1"];
$lestad2      = $_POST["lestad2"];
$lestad3      = $_POST["lestad3"];
$lestad4      = $_POST["lestad4"];
$lestad5      = $_POST["lestad5"];
$lestadf      = $_POST["lestadf"];
$lestadf1     = $_POST["lestadf1"];
$lestadcol    = $_POST["lestadcol"];
$lestadh1     = $_POST["lestadh1"];
$lestadh2     = $_POST["lestadh2"];
$lestadmin    = $_POST["lestadmin"];
//echo $lestad1;

$demora = $_POST["demora"];
$plan = $_POST["pasaplan"];
$zona = $_POST["pasazona"];
$movil = $_POST["pasamovil"];
$color = $_POST["pasacolor"];
$diag = $_POST["pasadiag"];
$edad = $_POST["pasaedad"];
$hora = $_POST["pasahora"];
$difcolor = $_POST["pasadifcolor"];

$fechad = $_POST["cla_fecha"];
$fechah = $_POST["cla_fecha1"];
$color1  = $_POST["cla_color"];
$hora1  = $_POST["hora1"];
$hora2  = $_POST["hora2"];
$minutos  = $_POST["cla_minuto"];

   if ($_POST["demora"] == 'DEMORA')
    {
     $fechad = $_POST["cla_fecha"];
     $fechah = $_POST["cla_fecha1"];
     $color1  = $_POST["cla_color"];
     $hora1  = $_POST["hora1"];
     $hora2  = $_POST["hora2"];
     $minutos  = $_POST["cla_minuto"];
    }

if (substr($fechad,2,1) == "/")
    $fechad = cambiarFormatoFecha2($fechad);

if (substr($fechah,2,1) == "/")
    $fechah = cambiarFormatoFecha2($fechah);

if ($color == '')
    $color = $color1;

$zona1  =  buscozona($zona);
$color1   =  buscocolor($color);
$plan1   =  buscoplan($plan);
$diagnostico =  buscodiagnostico($diag);


if ($fechah == '')
    $fechah = '2999/12/31';
if ($fechad == '')
    $fechad = '2000/01/01';


$fechad1=  cambiarFormatoFecha1($fechad);
$fechah1=  cambiarFormatoFecha1($fechah);


//Ejecutamos la sentencia SQL

if ($plan == '')
 {   $sqlplan = '';
  } else
  {  $sqlplan = " and plan = '".$plan."' ";
 }
if ($zona > '0')
{    $sqlplan = $sqlplan." and zona = '".$zona."' ";
}
if ($movil > '0')
{    $sqlplan = $sqlplan." and movil = '".$movil."' ";
}
if ($color > '0')
{    $sqlplan = $sqlplan." and color = '".$color."' ";
}
if ($edad > '')
{    $sqlplan = $sqlplan." and truncate(edad ,0) = '".$edad."' ";
}
if ($hora > '')
{    $sqlplan = $sqlplan." and hour(horallam) = '".$hora."' ";
}
if ($difcolor > '')
//{    $sqlplan = $sqlplan." and color <> colormedico and concat(color,'-',colormedico) = '".$difcolor."' ";
{    $sqlplan = $sqlplan." and concat(color,'-',colormedico) = '".$difcolor."' ";
}
if ($lestad1 == 5 || $lestad2 == 5 || $lestad3 == 5 || $lestad4 == 5 || $lestad5 == 5 )
{    $sqlplan = $sqlplan." and diagnostico = '".$diag."' ";
}

$sqlnombre1 = " order by id";

//if ($color1 > '0')
//{    $sqlplan = $sqlplan." and color = '".$color1."' ";
//}

$result=mysql_query("select * from atenciones a, planes b WHERE motanulacion < '1' and a.plan = b.idplan and fecha >= '".$fechad."' and fecha <= '".$fechah."' ".$sqlplan."  ".$sqlnombre1." ");

$ver = "select * from atenciones a, planes b WHERE a.plan = b.idplan and fecha >= '".$fechad."' and fecha <= '".$fechah."' ".$sqlplan."  ".$sqlnombre1." ";

//echo $ver;

 $literal = " ESTADISTICAS: PLAN ".$plan1." - ZONA: ".$zona1." - COLOR: ".$color1."  DESDE ".$fechad1." HASTA ".$fechah1;


?>
</p>
<?
echo '<table width="100%">
    <tr> <td>
     <table width="100%" border="1" align="left">
     <tr>
       <td><INPUT TYPE="BUTTON" value="Imprimir" ALIGN ="left" onclick ="window.print()"></td><td><div align="center">'.$literal.'</div>
        </td>';

   if ($_POST["demora"] == 'DEMORA')
    {
     echo '<FORM METHOD="POST" NAME="formulario2" ACTION="L_Estadisticas.php">';
    }
   else
    {
     echo '<FORM METHOD="POST" NAME="formulario2" ACTION="L_Estadisticas1.php">';
     echo '<input type="hidden" name= "pasaid" value="VUELVOCATENCIONES" >';
     echo '<input type="hidden" name= "cla_estad1" value  ="'.$_POST["lestad1"].'" >';
     echo '<input type="hidden" name= "cla_estad2" value  ="'.$_POST["lestad2"].'" >';
     echo '<input type="hidden" name= "cla_estad3" value  ="'.$_POST["lestad3"].'" >';
     echo '<input type="hidden" name= "cla_estad4" value  ="'.$_POST["lestad4"].'" >';
     echo '<input type="hidden" name= "cla_estad5" value  ="'.$_POST["lestad5"].'" >';
     echo '<input type="hidden" name= "cla_fecha" value  ="'.$_POST["lestadf"].'" >';
     echo '<input type="hidden" name= "cla_fecha1" value ="'.$_POST["lestadf1"].'" >';
     echo '<input type="hidden" name= "cla_color" value="'.$_POST["lestadcol"].'" >';
     echo '<input type="hidden" name= "hora1" value ="'.$_POST["lestadh1"].'" >';
     echo '<input type="hidden" name= "hora2" value ="'.$_POST["lestadh2"].'" >';
     echo '<input type="hidden" name= "cla_minuto" value="'.$_POST["lestadmin"].'" >';
    }

?>
      <td width="17" align="center" style="background-color:'.$td_color.'">
                           <label onclick="this.form.submit();" style="CURSOR: pointer" >
                            <img align="middle" alt='Volver' src="imagenes/Volver.ico" width="30" height="30"/>
                           </label>
                   </td></FORM>

      </tr></tr></table></tr> </td>
<?

echo '<table width="100%" border="0" align="left" style="background-color:'.$td_color.'">
    <td width="100%" rowspan="3" valign="top"><div align="center">
      <table style="font-size:'.$fontreg.'" border = 1 cellspacing="5" width="100%" cellpadding="5" align="left" style="background-color:'.$th_color.';border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
         <tr style="font-size:'.$fontt.'; background-color:'.$td_color.'">
            <th>ID</th>
            <th>FECHA</th>
            <th>HS</th>
            <th>PLAN</th>
            <th>NOMBRE</th>
            <th>FONO</th>
            <th>E</th>
            <th>S</th>
            <th>COLOR</th>
            <th>ZONA</th>
            <th>C.MED</th>
            <th>$ COS</th>
            <th>DIAGNOSTICO</th>
            <th>DIF</th>
            <th>CONS</th>
        </td></tr>';



while ($row=mysql_fetch_array($result))
{
if ($hora2 == 'horallegdom')
    $horades = $row["horallegdom"];
   else
    $horades = $row["horalleghosp"];

if ($hora1 == 'horallam')
    $horahas = $row["horallam"];
   else
    $horahas = $row["horadesp"];

if ($demora == 'DEMORA')
    $diferencia = calcular_tiempo($horades,$horahas);
  else
    $diferencia = '--';


$marca = 1;

if ($color1 > '0')
  if ($diferencia < $minutos)
 { $marca = 0;}

if ($marca == 1)
{
 $id = $row["id"] + 0;
 echo '<tr><td align="left">'.$id.'</td>';
 $fecha  =  cambiarFormatoFecha($row["fecha"]);

 $medico  =  buscopersonal($row["medico"]);
 $zona  =  buscozona($row["zona"]);
 $color1   =  buscocolor($row["color"]);
 $colorm  =  buscocolor($row["colormedico"]);
 $diagnostico  =  buscodiagnostico($row["diagnostico"]);

 if ($row["motanulacion"] > '0')
  {   $medico = 'ANULADO';
    $diagnostico = buscoanulacion($row["motanulacion"]);
  }

 $horallam = cambiarFormatoHora($row["horallam"]);
 echo '<td align="left">'.$fecha.'</td>';
 echo '<td align="right">'.$horallam.'</td>';
 echo '<td align="left">'.$row["descplan"].'</td>';
 echo '<td align="left">'.$row["nombre"].'</td>';
 echo '<td align="left">'.$row["telefono"].'</td>';
 echo '<td align="right">'.$row["edad"].'</td>';
 echo '<td align="left">'.$row["sexo"].'</td>';
 echo '<td align="left">'.$color1.'</td>';
 echo '<td align="left">'.$zona.'</td>';
 echo '<td align="left">'.$colorm.'</td>';
 echo '<td align="left">'.$row["impcoseguro"].'</td>';
 echo '<td align="left">'.$diagnostico.'</td>';
 echo '<td align="left">'.$diferencia.'</td>';
 echo '<FORM METHOD="POST" NAME="formulario2" ACTION="C_Atenciones.php">';
 echo '<input type="hidden" name= "pasaid" value="'.$id.'" >';
 echo '<input type="hidden" name= "lestad1" value  ="'.$_POST["lestad1"].'" >';
 echo '<input type="hidden" name= "lestad2" value  ="'.$_POST["lestad2"].'" >';
 echo '<input type="hidden" name= "lestad3" value  ="'.$_POST["lestad3"].'" >';
 echo '<input type="hidden" name= "lestad4" value  ="'.$_POST["lestad4"].'" >';
 echo '<input type="hidden" name= "lestad5" value  ="'.$_POST["lestad5"].'" >';
 echo '<input type="hidden" name= "lestadf" value  ="'.$_POST["lestadf"].'" >';
 echo '<input type="hidden" name= "lestadf1" value ="'.$_POST["lestadf1"].'" >';
 echo '<input type="hidden" name= "lestadcol" value="'.$_POST["lestadcol"].'" >';
 echo '<input type="hidden" name= "lestadh1" value ="'.$_POST["lestadh1"].'" >';
 echo '<input type="hidden" name= "lestadh2" value ="'.$_POST["lestadh2"].'" >';
 echo '<input type="hidden" name= "lestadmin" value="'.$_POST["lestadmin"].'" >';
 echo '<input type="hidden" name= "demora" value="'.$_POST["demora"].'" >';

if ($demora == 'DEMORA')
 { echo '<input type="hidden" name= "lestadf" value  ="'.$fechad.'" >';
   echo '<input type="hidden" name= "lestadf1" value ="'.$fechah.'" >';
   echo '<input type="hidden" name= "lestadcol" value="'.$color.'" >';
   echo '<input type="hidden" name= "lestadh1" value ="'.$hora1.'" >';
   echo '<input type="hidden" name= "lestadh2" value ="'.$hora2.'" >';
   echo '<input type="hidden" name= "lestadmin" value="'.$minutos.'" >';
  }

 echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                     <label onclick="this.form.submit();" style="CURSOR: pointer" >
                      <img align="middle" alt=\'Consultar\' src="imagenes/INSERTAR.ICO" width="30" height="30"/>
                     </label>
                   </td>';
 echo '</FORM></FORM>';

if ($color1 < '1')
{ $resulta=mysql_query("select * from clientes_nopadron WHERE idatencion = ".$id." order by idatencion, idnopadron");
 while ($rowa=mysql_fetch_array($resulta))
  {
    echo '<tr><td align="left">'.$id.'</td>';
    echo '<td align="left">'.$fecha1.'</td>';
    echo '<td align="right">'.$horallam.'</td>';
    echo '<td align="left">'.$row["descplan"].'</td>';
    echo '<td align="left">'.$rowa["nombre"].'</td>';
    echo '<td align="left">'.$row["telefono1"].'</td>';
    echo '<td align="right">'.$rowa["edad"].'</td>';
    echo '<td align="left">'.$rowa["sexo"].'</td></tr>';
  }
    mysql_free_result($resulta);
 }

 }}
 mysql_free_result($result);

?>

</table>
</table>


</BODY>
</HTML>