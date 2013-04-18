<?
session_start();
######################INCLUDES################################
//archivo de configuracion
include_once ('config.php');

//funciones propias
include ('funciones.php');

//incluímos la clase ajax
require ('xajax/xajax.inc.php');
require_once("cookie.php");
require_once("config.php");
$cookie = new cookieClass;
$G_usuario = $cookie->get("usuario");
$G_legajo  = $cookie->get("legajo");
$G_perfil  = $cookie->get("perfil");
//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@

################### Conexion a la base de datos##########################

$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);

//@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
?>


<HTML>
<HEAD>
<TITLE>A_CtrlCaja.php</TITLE>
</HEAD>

<body style="background-color:<?echo $body_color?>" style="font-size:<?echo $fontef?>">
<BODY>

<?
echo titulo_encabezado ('Alta Movimientos de Caja' , $path_imagen_logo);
$segmenu = valida_menu();
if ($segmenu <> "OK")
  { mensaje_error ('Principal.php', 'Usuario no autorizado');
   exit;
  }

$pasaid = $_POST["pasaid"];
//echo $pasaid;

if ($pasaid < 1)
  {
   $pasaid = $_GET["pasaid"];
   $resultin=mysql_query("select idsdosfinales from cjsdosfinales where fechasaldo = '".$pasaid."'");
   $rowin=mysql_fetch_array($resultin);
   $pasaid = $rowin["idsdosfinales"] +0;
   mysql_free_result($resultin);
  }

 $resultmax=mysql_query("select max(idsdosfinales) as idmax, min(idsdosfinales) as idmin from cjsdosfinales");
 $rowmax=mysql_fetch_array($resultmax);
 $pasaidmax = $rowmax["idmax"] +0;
 $pasaidmin = $rowmax["idmin"] +0;
 mysql_free_result($resultmax);

 if ($pasaid < 1)
   {
     $pasaid = $rowmax["idmax"] +0;
   };


 if ($pasaid > $pasaidmax)
   {
     $pasaid = $pasaidmax;
   };

 if ($pasaid < $pasaidmin)
   {
     $pasaid = $pasaidmin;
   };
//Ejecutamos la sentencia SQL


//$result=mysql_query("select * from cjsdosfinales a, cjmovimientos b, cjmotivos c WHERE
//                     idsdosfinales = ".$pasaid." and a.fechasaldo = b.cjmovfecha and b.cjmovmotivo = c.cjmotcodigo order by b.idcjmov ");
$result=mysql_query("select * from cjsdosfinales WHERE idsdosfinales = ".$pasaid." order by 1");
$row=mysql_fetch_array($result);


$pasaidant = $row["idsdosfinales"] -1;
$pasaidpro = $row["idsdosfinales"] +1;

$resulta=mysql_query("select * from cjsdosfinales WHERE idsdosfinales = ".$pasaidant." order by 1");
$rowa=mysql_fetch_array($resulta);

$afecha     = $rowa['fechasaldo'];
$asbanco    = $rowa['sdobanco'];
$asefectivo = $rowa['sdoefectivo'];
$ascheque   = $rowa['sdocheques'];
$afechad    = cambiarFormatoFecha($rowa['fechasaldo']);


$fecha = $row['fechasaldo'];
$sbanco    = $row['sdobanco'];
$sefectivo = $row['sdoefectivo'];
$scheque   = $row['sdocheques'];
$fechad =  cambiarFormatoFecha($row['fechasaldo']);

echo '
   <table width="100%" style="border-left-width: 0; border-top-width: 0; border-bottom-width: 0">
   <TR style="background-color:'.$td_color.'"><td>
    <table width="100%" border="1" align="left" >
    <tr>
    <td style="width:1000px"><INPUT TYPE="BUTTON" value="Imprimir" ALIGN ="left" onclick ="window.print()"></td>
    <td style="width:1000px" style="font-size:28px" align="center">'.$fechad.'</td>' ;

if ($G_perfil == '1' || $G_perfil == '3' || $G_perfil == '4' || $G_perfil == '8')
  {
     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="A_Ctrlcaja2.php">';
     echo '<input type="hidden" name= "pasaid" value  ="'.$pasaid.'" >';
     echo ' <td  style="width:200px" align="center" style="background-color:'.$td_color.'">
                     <label onclick="this.form.submit();" style="CURSOR: pointer" >
                      <img align="middle" alt=\'Modificar\' src="imagenes/editar.png" width="30" height="30"/>
                     </label>
                   </td>';
     echo '</FORM></TD>';
  }

     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="A_Ctrlcaja.php">';
     echo '<input type="hidden" name= "pasaid" value  ="'.$pasaidmin.'" >';
     echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                     <label onclick="this.form.submit();" style="CURSOR: pointer" >
                      <img align="middle" alt=\'Inicio\' src="imagenes/117.ico" width="30" height="30"/>
                     </label></td>';
     echo '</FORM></TD>';

     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="A_Ctrlcaja.php">';
     echo '<input type="hidden" name= "pasaid" value  ="'.$pasaidant.'" >';
     echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                     <label onclick="this.form.submit();" style="CURSOR: pointer" >
                      <img align="middle" alt=\'Anterior\' src="imagenes/118.ico" width="30" height="30"/>
                     </label>
                   </td>';
     echo '</FORM></TD>';

     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="A_Ctrlcaja.php">';
     echo '<input type="hidden" name= "pasaid" value  ="'.$pasaidpro.'" >';
     echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                     <label onclick="this.form.submit();" style="CURSOR: pointer" >
                      <img align="middle" alt=\'Proximo\' src="imagenes/119.ico" width="30" height="30"/>
                     </label>
                   </td>';
     echo '</FORM></TD>';

     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="A_Ctrlcaja.php">';
     echo '<input type="hidden" name= "pasaid" value  ="'.$pasaidmax.'" >';
     echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                     <label onclick="this.form.submit();" style="CURSOR: pointer" >
                      <img align="middle" alt=\'Ultimo\' src="imagenes/120.ico" width="30" height="30"/>
                     </label>
                   </td>';
     echo '</FORM></TD>';

     echo '<td><FORM METHOD="POST" NAME="formulario2" ACTION="A_Ctrlcaja3.php">';
     echo '<input type="text" name= "pasaid" >';
     echo ' <td width="17" align="center" style="background-color:'.$td_color.'">
                     <label onclick="this.form.submit();" style="CURSOR: pointer" >
                      <img align="middle" alt=\'Ir a fecha\' src="imagenes/120.ico" width="30" height="30"/>
                     </label>
                   </td>';
     echo '</FORM>';
     echo '</tr></table></TD></TR></table>';
     echo '<table width="100%" border="1" align="left" cellspacing="3" cellpadding="3"> ';
     echo '<TR style="background-color:'.$td_color.'">';


// TABLA DE MOVIMIENTOS DE BANCO
     echo '<TD valign="top"><table width="100%" border="1" align="left" ><TR width="100%"><TD colspan =4 align = "center">';
     echo 'BANCO</td></tr>';

     echo '<TR style="background-color:'.$td_color.'"><td>SDO ANTERIOR</td><TD align="center">'.$afechad.'</td><td  align = "right">'.$asbanco.'</td><td></td></TR>';

     $result=mysql_query("select * from cjmovimientos, cjmotivos WHERE cjmovmotivo = cjmotcodigo and cjmovfecha = '".$fecha."' and cjmovtipo = 'B' order by 1");
     while ($row=mysql_fetch_array($result))
      {

     if ($row["cjmovmotivo"] < 200)
      $importe = $row["cjmovimporte"] * -1;
     else
      $importe = $row["cjmovimporte"];

     echo '<TR><td>'.substr($row['cjmotdesc'],0,15).'</td><td>'.$row['cjmovnro'].'</td><td  align = "right">'.number_format($importe,2).'</td>';
     $cjmov = $row["idcjmov"];
     echo '<FORM METHOD="POST" NAME="formulario2" ACTION="C_Cjmovimientos.php">';
     echo '<input type="hidden" name= "cla_pasaid" value="'.$pasaid.'" >';
     echo '<input type="hidden" name= "cla_cjmov" value="'.$cjmov.'" >';
     echo ' <td width="15" height="10" align="center" style="background-color:'.$td_color.'">
           <label onclick="this.form.submit();" style="CURSOR: pointer" ><img align="middle" alt=\'Consultar\' src="imagenes/INSERTAR.ICO" width="15" height="15"/></label>';
     echo '</FORM></td></TR>';

      }
     $row=mysql_fetch_array($result);

     echo '<TR style="background-color:'.$td_color.'"><td>SDO FINAL</td><TD align="center">'.$fechad.'</td><td  align = "right">'.$sbanco.'</td>';

     $tipomov = 'B';
     echo '<FORM METHOD="POST" NAME="formulario2" ACTION="A_Cjmovimientos.php">';
     echo '<input type="hidden" name= "cla_pasaid" value="'.$pasaid.'" >';
     echo '<input type="hidden" name= "cla_fecha" value="'.$fecha.'" >';
     echo '<input type="hidden" name= "cla_tipomov" value="'.$tipomov.'" >';
     echo ' <td width="15" height="10" align="center" style="background-color:'.$td_color.'">
           <label onclick="this.form.submit();" style="CURSOR: pointer" ><img align="middle" alt=\'Agregar\' src="imagenes/editar.png" width="15" height="15"/></label>';
     echo '</FORM></td></TR>';

     echo '</td></tr></table></TD>';

// TABLA DE MOVIMIENTOS DE CHEQUES
     echo '<TD valign="top"><table width="100%" border="1" align="left" ><TR width="100%"><TD colspan =4 align = "center" valign="top">';
     echo 'CHEQUES</td></tr>';

     echo '<TR style="background-color:'.$td_color.'"><td>SDO ANTERIOR</td><TD align="center">'.$afechad.'</td><td  align = "right">'.$ascheque.'</td><td></td></TR>';

     $result=mysql_query("select * from cjmovimientos, cjmotivos WHERE cjmovmotivo = cjmotcodigo and cjmovfecha = '".$fecha."' and cjmovtipo = 'C' order by 1");
     while ($row=mysql_fetch_array($result))
      {
     if ($row["cjmovmotivo"] < 200)
      $importe = $row["cjmovimporte"] * -1;
     else
      $importe = $row["cjmovimporte"];

     echo '<TR><td>'.substr($row['cjmotdesc'],0,15).'</td><td>'.$row['cjmovnro'].'</td><td  align = "right">'.number_format($importe,2).'</td>';
     $cjmov = $row["idcjmov"];
     echo '<FORM METHOD="POST" NAME="formulario2" ACTION="C_Cjmovimientos.php">';
     echo '<input type="hidden" name= "cla_pasaid" value="'.$pasaid.'" >';
     echo '<input type="hidden" name= "cla_cjmov" value="'.$cjmov.'" >';
     echo ' <td width="15" height="10" align="center" style="background-color:'.$td_color.'">
           <label onclick="this.form.submit();" style="CURSOR: pointer" ><img align="middle" alt=\'Consultar\' src="imagenes/INSERTAR.ICO" width="15" height="15"/></label>';
     echo '</FORM></td></TR>';

      }
     $row=mysql_fetch_array($result);

     echo '<TR style="background-color:'.$td_color.'"><td>SDO FINAL</td><TD align="center">'.$fechad.'</td><td align = "right">'.$scheque.'</td>';

     $tipomov = 'C';
     echo '<FORM METHOD="POST" NAME="formulario2" ACTION="A_Cjmovimientos.php">';
     echo '<input type="hidden" name= "cla_pasaid" value="'.$pasaid.'" >';
     echo '<input type="hidden" name= "cla_fecha" value="'.$fecha.'" >';
     echo '<input type="hidden" name= "cla_tipomov" value="'.$tipomov.'" >';
     echo ' <td width="15" height="10" align="center" style="background-color:'.$td_color.'">
           <label onclick="this.form.submit();" style="CURSOR: pointer" ><img align="middle" alt=\'Agregar\' src="imagenes/editar.png" width="15" height="15"/></label>';
     echo '</FORM></td></TR>';


     echo '<TR style="background-color:'.$td_color.'"><td></td><TD></td><td></td><td></td>';

     $result=mysql_query("select * from cjmovimientos, cjmotivos WHERE cjmovmotivo = cjmotcodigo and cjmovfecha <= '".$fecha."' and cjmotcodigo = 207 and cjmovtipo = 'C' order by 1");
     while ($row=mysql_fetch_array($result))
      {
      $importe = $row["cjmovimporte"];

     echo '<TR><td>'.substr($row['cjmotdesc'],0,15).'</td><td>'.$row['cjmovnro'].'</td><td  align = "right">'.number_format($importe,2).'</td>';
     $cjmov = $row["idcjmov"];
     echo '<FORM METHOD="POST" NAME="formulario2" ACTION="A_Valcobro.php">';
     echo '<input type="hidden" name= "cla_pasaid" value="'.$pasaid.'" >';
     echo '<input type="hidden" name= "cla_cjmov" value="'.$cjmov.'" >';
     echo ' <td width="15" height="10" align="center" style="background-color:'.$td_color.'">
           <label onclick="this.form.submit();" style="CURSOR: pointer" ><img align="middle" alt=\'Consultar\' src="imagenes/INSERTAR.ICO" width="15" height="15"/></label>';
     echo '</FORM></td></TR>';

      }
     $row=mysql_fetch_array($result);


     echo '</td></tr></table></TD>';


// TABLA DE MOVIMIENTOS DE EFECTIVO
     echo '<TD valign="top"><table width="100%" border="1" align="left" ><TR width="100%"><TD colspan =4 align = "center" valign="top">';
     echo 'EFECTIVO</td></tr>';

     echo '<TR style="background-color:'.$td_color.'"><td>SDO ANTERIOR</td><TD align="center">'.$afechad.'</td><td  align = "right">'.$asefectivo.'</td><td></td></TR>';

     $result=mysql_query("select * from cjmovimientos, cjmotivos WHERE cjmovmotivo = cjmotcodigo and cjmovfecha = '".$fecha."' and cjmovtipo = 'E' order by 1");
     while ($row=mysql_fetch_array($result))
      {
     if ($row["cjmovmotivo"] < 200)
      $importe = $row["cjmovimporte"] * -1;
     else
      $importe = $row["cjmovimporte"];

     echo '<TR><td>'.substr($row['cjmotdesc'],0,15).'</td><td>'.$row['cjmovnro'].'</td><td  align = "right">'.number_format($importe,2).'</td>';
     $cjmov = $row["idcjmov"];
     echo '<FORM METHOD="POST" NAME="formulario2" ACTION="C_Cjmovimientos.php">';
     echo '<input type="hidden" name= "cla_pasaid" value="'.$pasaid.'" >';
     echo '<input type="hidden" name= "cla_cjmov" value="'.$cjmov.'" >';
     echo ' <td width="15" height="10" align="center" style="background-color:'.$td_color.'">
           <label onclick="this.form.submit();" style="CURSOR: pointer" ><img align="middle" alt=\'Consultar\' src="imagenes/INSERTAR.ICO" width="15" height="15"/></label>';
     echo '</FORM></td></TR>';

      }
     $row=mysql_fetch_array($result);

     echo '<TR style="background-color:'.$td_color.'"><td>SDO FINAL</td><TD align="center">'.$fechad.'</td><td  align = "right">'.$sefectivo.'</td>';
     $tipomov = 'E';
     echo '<FORM METHOD="POST" NAME="formulario2" ACTION="A_Cjmovimientos.php">';
     echo '<input type="hidden" name= "cla_pasaid" value="'.$pasaid.'" >';
     echo '<input type="hidden" name= "cla_fecha" value="'.$fecha.'" >';
     echo '<input type="hidden" name= "cla_tipomov" value="'.$tipomov.'" >';
     echo ' <td width="15" height="10" align="center" style="background-color:'.$td_color.'">
           <label onclick="this.form.submit();" style="CURSOR: pointer" ><img align="middle" alt=\'Agregar\' src="imagenes/editar.png" width="15" height="15"/></label>';
     echo '</FORM></td></TR>';


     echo '</td></tr></table></TD>';
     echo '</TR></table>';

mysql_free_result($result);

?>

</table>

</BODY>
</HTML>