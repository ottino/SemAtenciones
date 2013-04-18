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

//Ejecucion de la sentencia SQL
/*
       window.location.href("A_Clientes2.php?nom="+nombre+"&perfis="+perfis+"&perju="+perju+"&tipodni="+
                              tipodni+"&tipolc="+tipolc+"&tipole="+tipole+"&tipodne="+tipodne+"&dni="+
                              dni+"&dni="+afil+"&dia="+dia+"&mes="+mes+"&anio="+anio+"&calle="+
                             calle+"&nro="+nro+"&postal="+postal+"&cuit="+cuit+"&sexo_m="+sexo_m+"&sexo_f="+sexo_f);

*/
$cla_cuit        = $_GET["cuit"];

if ($_GET['perfis'] == 'true')
{
   if ($_GET['sexo_m'] == 'true')
     $cla_sexo = 'M';
   else $cla_sexo = 'F';

   if ($_GET['tipodni'] == 'true')
    {
     $cla_tipodoc = 'DNI';
    }else if ($_GET['tipolc'] == 'true')
     {
       $cla_tipodoc = 'LC';
     }else if ($_GET['tipole'] == 'true')
       {
         $cla_tipodoc = 'LE';

       }else $cla_tipodoc = 'DNE';

   $cla_fnacimiento = $_GET["anio"].'-'.$_GET["mes"].'-'.$_GET["dia"];
   $cla_tipoper = 'FISICA';
   $cla_documento = $_GET["dni"];

}else
 {
  $cla_fnacimiento = ' ';
  $cla_sexo = ' ';
  $cla_tipoper = 'JURIDICA';
  $cla_sexo = ' ';
  $cla_tipodoc = ' ';

   //$cla_fnacimiento = $_GET["anio"].'-'.$_GET["mes"].'-'.$_GET["dia"];
   //$cla_tipoper = 'FISICA';
   $cla_documento = '';
 }

 $cla_nroafiliado = $_GET["afil"];
 $cla_falta       = date("Y-m-d");
 $cla_calle       = $_GET["calle"];
 $cla_nrocalle    = $_GET["nro"];
 $cla_nombre      = $_GET["nom"];
 $cla_estcivil    = $_GET["estcivil"];
 $cla_entre1      = $_GET["entre1"];
 $cla_entre2      = $_GET["entre2"];
 $cla_piso        = $_GET["piso"];
 $cla_depto       = $_GET["dpto"];
 $cla_barrio      = $_GET["barrio"];
 $cla_cpostal     = $_GET["codpostal"];
 $cla_zona        = $_GET["zona"];
 $cla_localidad   = $_GET["locali"];
 $cla_telefono    = $_GET["tel"];
 $cla_cel         = $_GET["cel"];
 $cla_mail        = $_GET["mail"];
 $cla_contacto    = $_GET["contac"];
 $cla_obs         = $_GET["obs"];

$sSQL= "insert into clientes (cuit , sexo, tipoper , tipodoc , documento , nroafiliado , nombre , calle ,
         nrocalle , fnacimiento  , falta , estadocivil , entre1 , entre2 , piso , depto , barrio, cpostal ,
         idzona , localidad , telefono , celular , email, contacto , observaciones)
    VALUES ('".$cla_cuit."' , '".$cla_sexo."' ,'".$cla_tipoper."' , '".$cla_tipodoc."' , '".$cla_documento."'
            , '".$cla_nroafiliado."' , '".strtoupper ($cla_nombre)."' , '".strtoupper ($cla_calle)."' ,
            '".$cla_nrocalle."' , '".$cla_fnacimiento."' , '".$cla_falta."', '".$cla_estcivil."'
            , '".strtoupper ($cla_entre1)."', '".strtoupper ($cla_entre2)."', '".$cla_piso."', '".$cla_depto."', '".strtoupper ($cla_barrio)."', '".$cla_cpostal."' ,
             '".$cla_zona."' , '".$cla_localidad."' , '".$cla_telefono."' , '".$cla_cel."' , '".$cla_mail."' , '".strtoupper ($cla_contacto)."' , '".strtoupper ($cla_obs)."'
            )";

insertolog($legajo, "A_Clientes2", "clientes", "insert", "1999-12-01", $sSQL);

//echo $sSQL;
mysql_query($sSQL);
//echo mensaje_ok('ABM_Clientes.php','OK');
echo mensaje_ok('ABM_Clientes.php?cla_bus=S&cla_ord=S&cla_nombre='.$cla_nroafiliado,'OK');

?>
