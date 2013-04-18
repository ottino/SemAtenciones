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
 $cla_cli         = $_GET["cli"];
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

//echo $cla_cli;

$sSQL= "update clientes set
           cuit           =  '".$cla_cuit."',
           sexo           =  '".$cla_sexo."',
           tipoper        =  '".$cla_tipoper."',
           tipodoc        =  '".$cla_tipodoc."',
           documento      =  '".$cla_documento."',
           nroafiliado    =  '".$cla_nroafiliado."',
           nombre         =  '".strtoupper ($cla_nombre)."',
           calle          =  '".strtoupper ($cla_calle)."',
           nrocalle       =  '".$cla_nrocalle."',
           fnacimiento    =  '".$cla_fnacimiento."',
           falta          =  '".$cla_falta."',
           estadocivil    =  '".$cla_estcivil."',
           entre1         =  '".strtoupper ($cla_entre1)."',
           entre2         =  '".strtoupper ($cla_entre2)."',
           piso           =  '".$cla_piso."',
           depto          =  '".$cla_depto."',
           barrio         =  '".strtoupper ($cla_barrio)."',
           cpostal        =  '".$cla_cpostal."',
           idzona         =  '".$cla_zona."',
           localidad      =  '".$cla_localidad."',
           telefono       =  '".$cla_telefono."',
           celular        =  '".$cla_cel."' ,
           email          =  '".$cla_mail."',
           contacto       =  '".strtoupper ($cla_contacto)."',
           observaciones  =  '".strtoupper ($cla_obs)."'
          where idcliente =  '".$cla_cli."' ";

//echo $sSQL;
mysql_query($sSQL);

insertolog($legajo, "M_Clientes2", "clientes", "update", "1999-12-01", $sSQL);

//echo $sSQL;
echo mensaje_ok('ABM_Clientes.php?cla_bus=S&cla_ord=S&cla_nombre='.$cla_nroafiliado,'OK');
//echo mensaje_ok('ABM_Adicionales.php?pasacont='.$idcontrato,'OK');
?>

