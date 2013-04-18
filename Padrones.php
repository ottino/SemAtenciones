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


$sSQL="select * from contratos";
$result=mysql_query($sSQL);
while ($row=mysql_fetch_array($result))
{
   $nroafiliado = $row[nroafiliado];
   $idcontrato  = $row[idcontrato];
   $cla_idplan  = $row[idplan];
   $cla_ordenmax = 0;

   $sSQL1="select * from clientes where nroafiliado = ".$nroafiliado;
   $result1=mysql_query($sSQL1);
    while ($row1=mysql_fetch_array($result1))
    {
        $cla_idcliente       = $row1["idcliente"];
        $cla_nroafiliado     = $row1["nroafiliado"];
        $cla_nombre          = $row1["nombre"];
        $cla_documento       = $row1["documento"];
        $cla_fnacimiento     = $row1["fnacimiento"];
        $cla_sexo            = $row1["sexo"];
        $cla_identificacion  = $row1["documento"];
        $cla_calle           = $row1["calle"];
        $cla_numero          = $row1["nrocalle"];
        $cla_piso            = $row1["piso"];
        $cla_depto           = $row1["depto"];
        $cla_barrio          = $row1["barrio"];
        $cla_localidad       = $row1["localidad"];
        $cla_provincia       = $row1["provincia"];
        $cla_ordenmax = $cla_ordenmax + 1;

        $sSQL2= "insert into padron (idpadron, idcontrato, nombre, socio, plan, integrante, fnacimiento, sexo, identificacion, documento,calle, numero,
                                  piso, depto, barrio, localidad, provincia)
          VALUES ('".$cla_documento."' ,'".$idcontrato."', '".$cla_nombre."', '".$cla_nroafiliado."' , '".$cla_idplan."' , '".$cla_ordenmax."' , '".$cla_fnacimiento."' ,
                  '".$cla_sexo."' , '".$cla_nroafiliado."' , '".$cla_documento."','".$cla_calle."',
                  '".$cla_numero."' ,'".$cla_piso."' ,'".$cla_depto."' ,'".$cla_barrio."' ,'".$cla_localidad."' ,'".$cla_provincia."')";
        mysql_query($sSQL2);

        $sSQL3= "insert into cliadicionales (idcontrato, idpadron)
            VALUES ('".$idcontrato."' , '".$cla_idcliente."' )";
        mysql_query($sSQL3);

    } ///FIN DEL SELECT DE CLIENTES

} ///FIN DEL SELECT DE CONTRATOS

echo mensaje_ok('Principal.php?','OK');

?>
