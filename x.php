<?php
 $idmotivo = 123;
 $ids ['0'] = substr($idmotivo, 0, 1);
 $ids ['1'] = substr($idmotivo, 1, 2);
echo $ids ['0'].'-'.$ids ['1'];
/*
for ($c=1 ; $c<25 ; $c++)
 
echo '	 
if ($_bandera_nosocio'.$c.'== 1) 
   { $existe_socio'.$c.' = mysql_query ("select * from clientes_nopadron where idatencion = ".$id_atencion." and idnopadron= \'".$_nosocioid'.$c.'."\'"); 
     if (mysql_affected_rows() == 0) 
	 {
  	    $insert_nosocio'.$c.' = mysql_query (\'insert into clientes_nopadron (idatencion , nombre , edad , sexo , os , dni , cod_destino , cod_diagnostico ) 
		                                 values ("\'.$id_atencion.\'" , "\'.$_nosocio'.$c.'.\'" , 
										         "\'.$_noedad'.$c.'.\'" , "\'.$_nosexo'.$c.'.\'" , 
												 "\'.$_noiden'.$c.'.\'" , "\'.$_nodocum'.$c.'.\'" ,
                                                 "\'.$_destino'.$c.'.\'" , "\'.$_diagno'.$c.'.\'" 												 
												 ) 
									   \'); 
	 }
	 else { 
	         $update_nosocio = mysql_query (\'update clientes_nopadron set nombre = "\'.$_nosocio'.$c.'.\'" , edad = "\'.$_noedad'.$c.'.\'" , 
			                                                                sexo = "\'.$_nosexo'.$c.'.\'" , os = "\'.$_noiden'.$c.'.\'" , 
																			dni = "\'.$_nodocum'.$c.'.\'" , cod_destino = "\'.$_destino'.$c.'.\'" ,
																			cod_diagnostico = "\'.$_diagno'.$c.'.\'"
			                                 where idatencion = \'.$id_atencion.\' and idnopadron= \'.$_nosocioid'.$c.'); 
		  } 
   }
   '.'<BR>'; 
   */
?>