<?
session_start();
######################INCLUDES################################
//archivo de configuracion
include_once ('config.php');

//funciones propias
include ('funciones.php');

// libreria para crear pdf
require('fpdf.php');

// BarCode
//include('codigo_barra.php');

################### Conexion a la base de datos##########################

$bd= mysql_connect($bd_host, $bd_user, $bd_pass);
mysql_select_db($bd_database, $bd);


// obejetos
class PDF extends FPDF
{
//Cabecera de página
var $titulo;
function Header(){
}

//Pie de página
function Footer(){


}

} // cierre de class PDF extends FPDF



// Validacion de acceso
/*
	$segmenu = valida_menu();
	if ($segmenu <> "OK")
	  { mensaje_error ('Principal.php', 'Usuario no autorizado');
	   exit;
	  }
*/

$periodo     = 201208;//$_POST["cla_periodo"];

/* Datos de la empresa */
$emp_dir = 'URQUIZA 1470';
$emp_tel = '(0343) 422-5544';
$emp_loc = '(3100) PARANA';
$emp_pro = 'E.R';
$emp_cuit = '30-70766126-3';
$emp_ingb = '30-70766126-3';
$emp_inic = '01/07/2001';


// modificado para 1 solo cupon
$result=mysql_query("select *, b.observaciones as observa from comprobantes a, contratos b, clientes c, planes d, cobrador g where
                     a.idcontrato = b.idcontrato and b.idcliente = c.idcliente  and
                     b.idplan = d.idplan and b.codcobrador = g.idcob and a.tipocomprob = 'C'
                     and a.idcontrato = 872 order by cobrador, 1",$bd);
 
// PARAMETROS PARA LA SALIDA EN PDF
$pdf=new PDF('P','cm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',8);

$pdf->SetAutoPageBreak(true,0.2);

/***** Parametro de los cupones *****/
# Parametros de largo y ancho
$ALTURA 		= 09.74; // Altura total del cupon
$ANCHO  		= 10.25; // Ancho total del cupon
$enca_div 		= 05.12; // Ancho de linea que divide el primer encabezado 
$cabecera_alto   	= 1.35;  // Alto de la primer cabecera
$cabecera_ancho  	= 10.45; // Ancho de la primer cabecera
$cuerpo_alto     	= 9.32; // Alto total del cuerpo del cupon		
$cuerpo_ancho    	= 10.45; // Ancho total del ancho del cupon
$cab_tit_alto    	= 1.3; // Alto total de la 2da cabecera (Info del abonado)
$cuerpo_tit_alto   	= 0.4; // Ancho total para el titulo del cuerpo
$cuerpo_div		= 8.80; // Ancho de linea que divide el cuerpo
# Coordenadas de inicio de los cupones
$eje_x_original  	= 0.20;  // Eje x : Inicio de los cupones de la izquierda
$eje_x_duplicado 	= 10.50; // Eje x : Inicio de los cupones de la derecha 
$Y1      		= 00.20; // Eje y : Inicio del 1er cupon
$Y3      		= 10.00; // Eje y : Inicio del 2do cupon
$Y5      		= 19.78; // Eje y : Inicio del 3er cupon


/**** 1er cupon ****/

// Rectangulo
$pdf->Rect($eje_x_original,$Y1,$ANCHO,$ALTURA,'D');

// Cabecera
$pdf->Line($eje_x_original, $cabecera_alto, $cabecera_ancho, $cabecera_alto); 

// Linea que divide el encabezado
$pdf->Line($enca_div + $eje_x_original, $Y1 , $enca_div + $eje_x_original, $cabecera_alto); 


$pdf->SetFont('Arial','B',20);
$pdf->SetY($Y1);
$pdf->SetX($eje_x_original);
$pdf->Cell(1.7,1,'SEM');

$pdf->SetFont('Arial','U',5);
$pdf->SetY($Y1+0.22);
$pdf->SetX($eje_x_original+1.52);
$pdf->Cell(3.5,0.22,'SERVICIO DE EMERGENCIAS MEDICAS');

$pdf->SetFont('Arial','B',4.5);
$pdf->SetY($Y1+0.80);
$pdf->SetX($eje_x_original);
$pdf->Cell(3.5,0.22,$emp_dir.' - TEL.: '.$emp_tel.' - '.$emp_loc.' '.$emp_pro);

$pdf->SetFont('Arial','B',5);
$pdf->SetY($Y1+0.2);
$pdf->SetX($eje_x_original+5.3);
$pdf->Cell(3.5,0.22,'COMPROBANTE No. 0002');

$pdf->SetFont('Arial','B',5);
$pdf->SetY($Y1+0.45);
$pdf->SetX($eje_x_original+5.3);
$pdf->Cell(3.5,0.22,'Fecha: 21/01/1985');

$pdf->SetFont('Arial','B',8);
$pdf->SetY($Y1+0.45);
$pdf->SetX($eje_x_original+8.40);
$pdf->Cell(3.5,0.22,'ORIGINAL');

$pdf->SetFont('Arial','B',4);
$pdf->SetY($Y1+0.80);
$pdf->SetX($eje_x_original+6.2);
$pdf->Cell(3.5,0.22,'C.U.I.T.: '.$emp_cuit.' - Ing. Brutos: '.$emp_ingb);

$pdf->SetFont('Arial','B',4);
$pdf->SetY($Y1+0.94);
$pdf->SetX($eje_x_original+6.8);
$pdf->Cell(3.5,0.22,'Inicio de Actividad: '.$emp_inic);

// Cabecera Info de abonado
$pdf->Line($eje_x_original, $cabecera_alto + $cab_tit_alto , $cabecera_ancho, $cabecera_alto + $cab_tit_alto ); 

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2);
$pdf->SetX(0.2);
$pdf->Cell(3.5,0.22,'Abonado:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2);
$pdf->SetX($ANCHO-2.5);
$pdf->Cell(3.5,0.22,'No.:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40);
$pdf->SetX(0.2);
$pdf->Cell(3.5,0.22,'Domicilio:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40);
$pdf->SetX($ANCHO-2.5);
$pdf->Cell(3.5,0.22,'C.U.I.T.:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40);
$pdf->SetX(0.2);
$pdf->Cell(3.5,0.22,'Condicion de Pago:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40);
$pdf->SetX($ANCHO-6.20);
$pdf->Cell(3.5,0.22,'Periodo:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40);
$pdf->SetX($ANCHO-2.5);
$pdf->Cell(3.5,0.22,'Vencimiento:');

// Cuerpo
$pdf->Line($eje_x_original, $cuerpo_alto, $cuerpo_ancho, $cuerpo_alto);  

// Titulo del cuerpo
$pdf->Line($eje_x_original, $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto , $cabecera_ancho, $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto); 

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30);
$pdf->SetX(0.60);
$pdf->Cell(3.5,0.22,'Cantidad');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30);
$pdf->SetX(3.87);
$pdf->Cell(3.5,0.22,'Descripcion');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30);
$pdf->SetX($ANCHO  - (($ANCHO - $cuerpo_div + 0.50 )/2));
$pdf->Cell(3.5,0.22,'Importe');


// Linea que divide el cuerpo
$pdf->Line($eje_x_original + $cuerpo_div ,  $cabecera_alto + $cab_tit_alto , $eje_x_original + $cuerpo_div, $cuerpo_alto + ($ALTURA - $cuerpo_alto + 0.20 ) ); 

$pdf->SetFont('Arial','B',11);
$pdf->SetY($ALTURA - 0.20);
$pdf->SetX($ANCHO  - ($ANCHO - $cuerpo_div) - 1.28  );
$pdf->Cell(1,0.22,'TOTAL');

/*Borrarrrrrrrrrrr*/

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto);
$pdf->SetX(0.15);
$pdf->Cell(3.5,0.22,'123456789123456789123456789123456789123456789123456789123456789123456789123456789');
/*****************************************/

#Duplicado
// Rectangulo
$pdf->Rect($eje_x_duplicado,$Y1,$ANCHO,$ALTURA,'D');

// Cabecera
$pdf->Line($eje_x_duplicado, $cabecera_alto, $eje_x_duplicado + $ANCHO , $cabecera_alto); 

// Linea que divide el encabezado
$pdf->Line($enca_div + $eje_x_duplicado, $Y1 , $enca_div + $eje_x_duplicado, $cabecera_alto); 


$pdf->SetFont('Arial','B',20);
$pdf->SetY($Y1);
$pdf->SetX($eje_x_duplicado);
$pdf->Cell(1.7,1,'SEM');

$pdf->SetFont('Arial','U',5);
$pdf->SetY($Y1+0.22);
$pdf->SetX($eje_x_duplicado+1.52);
$pdf->Cell(3.5,0.22,'SERVICIO DE EMERGENCIAS MEDICAS');

$pdf->SetFont('Arial','B',4.5);
$pdf->SetY($Y1+0.80);
$pdf->SetX($eje_x_duplicado);
$pdf->Cell(3.5,0.22,$emp_dir.' - TEL.: '.$emp_tel.' - '.$emp_loc.' '.$emp_pro);


$pdf->SetFont('Arial','B',5);
$pdf->SetY($Y1+0.2);
$pdf->SetX($eje_x_duplicado+5.3);
$pdf->Cell(3.5,0.22,'COMPROBANTE No. 0002');

$pdf->SetFont('Arial','B',5);
$pdf->SetY($Y1+0.45);
$pdf->SetX($eje_x_duplicado+5.3);
$pdf->Cell(3.5,0.22,'Fecha: 21/01/1985');

$pdf->SetFont('Arial','B',8);
$pdf->SetY($Y1+0.45);
$pdf->SetX($eje_x_duplicado+8.40);
$pdf->Cell(3.5,0.22,'DUPLICADO');

$pdf->SetFont('Arial','B',4);
$pdf->SetY($Y1+0.80);
$pdf->SetX($eje_x_duplicado+6.2);
$pdf->Cell(3.5,0.22,'C.U.I.T.: '.$emp_cuit.' - Ing. Brutos: '.$emp_ingb);

$pdf->SetFont('Arial','B',4);
$pdf->SetY($Y1+0.94);
$pdf->SetX($eje_x_duplicado+6.8);
$pdf->Cell(3.5,0.22,'Inicio de Actividad: '.$emp_inic);

// Cabecera Info de abonado
$pdf->Line($eje_x_duplicado, $cabecera_alto + $cab_tit_alto , $eje_x_duplicado + $ANCHO, $cabecera_alto + $cab_tit_alto ); 

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2);
$pdf->SetX($eje_x_duplicado+0.2);
$pdf->Cell(3.5,0.22,'Abonado:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2);
$pdf->SetX($eje_x_duplicado+$ANCHO-2.5);
$pdf->Cell(3.5,0.22,'No.:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40);
$pdf->SetX($eje_x_duplicado+0.2);
$pdf->Cell(3.5,0.22,'Domicilio:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40);
$pdf->SetX($eje_x_duplicado+$ANCHO-2.5);
$pdf->Cell(3.5,0.22,'C.U.I.T.:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40);
$pdf->SetX($eje_x_duplicado+0.2);
$pdf->Cell(3.5,0.22,'Condicion de Pago:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40);
$pdf->SetX($eje_x_duplicado+$ANCHO-6.20);
$pdf->Cell(3.5,0.22,'Periodo:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40);
$pdf->SetX($eje_x_duplicado+$ANCHO-2.5);
$pdf->Cell(3.5,0.22,'Vencimiento:');



// Cuerpo
$pdf->Line($eje_x_duplicado, $cuerpo_alto, $eje_x_duplicado + $ANCHO, $cuerpo_alto); 

// Titulo del cuerpo
$pdf->Line($eje_x_duplicado, $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto , $eje_x_duplicado + $ANCHO, $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto); 

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30);
$pdf->SetX($eje_x_duplicado+0.60);
$pdf->Cell(3.5,0.22,'Cantidad');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30);
$pdf->SetX($eje_x_duplicado+3.87);
$pdf->Cell(3.5,0.22,'Descripcion');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30);
$pdf->SetX($eje_x_duplicado - 0.20 + $ANCHO  - (($ANCHO - $cuerpo_div + 0.50 )/2));
$pdf->Cell(3.5,0.22,'Importe');


// Linea que divide el cuerpo
$pdf->Line($eje_x_duplicado + $cuerpo_div ,  $cabecera_alto + $cab_tit_alto , $eje_x_duplicado + $cuerpo_div, $cuerpo_alto + ($ALTURA - $cuerpo_alto + 0.20 ) ); 

$pdf->SetFont('Arial','B',11);
$pdf->SetY($ALTURA - 0.20);
$pdf->SetX($eje_x_duplicado + $ANCHO  - ($ANCHO - $cuerpo_div) - 1.28 -  0.20 );
$pdf->Cell(1,0.22,'TOTAL');


/**** 2do cupon ****/
// Rectangulo
$pdf->Rect($eje_x_original,$Y3,$ANCHO,$ALTURA,'D');

// Cabecera
$pdf->Line($eje_x_original, $cabecera_alto + $Y3 - 0.20, $cabecera_ancho, $cabecera_alto+$Y3- 0.20);

// Linea que divide el encabezado
$pdf->Line($enca_div + $eje_x_original, $Y3 , $enca_div + $eje_x_original, $cabecera_alto+$Y3- 0.20); 


$pdf->SetFont('Arial','B',20);
$pdf->SetY($Y3);
$pdf->SetX($eje_x_original);
$pdf->Cell(1.7,1,'SEM');

$pdf->SetFont('Arial','U',5);
$pdf->SetY($Y3+0.22);
$pdf->SetX($eje_x_original+1.52);
$pdf->Cell(3.5,0.22,'SERVICIO DE EMERGENCIAS MEDICAS');

$pdf->SetFont('Arial','B',4.5);
$pdf->SetY($Y3+0.80);
$pdf->SetX($eje_x_original);
$pdf->Cell(3.5,0.22,$emp_dir.' - TEL.: '.$emp_tel.' - '.$emp_loc.' '.$emp_pro);

$pdf->SetFont('Arial','B',5);
$pdf->SetY($Y3+0.2);
$pdf->SetX($eje_x_original+5.3);
$pdf->Cell(3.5,0.22,'COMPROBANTE No. 0002');

$pdf->SetFont('Arial','B',5);
$pdf->SetY($Y3+0.45);
$pdf->SetX($eje_x_original+5.3);
$pdf->Cell(3.5,0.22,'Fecha: 21/01/1985');

$pdf->SetFont('Arial','B',8);
$pdf->SetY($Y3+0.45);
$pdf->SetX($eje_x_original+8.40);
$pdf->Cell(3.5,0.22,'ORIGINAL');

$pdf->SetFont('Arial','B',4);
$pdf->SetY($Y3+0.80);
$pdf->SetX($eje_x_original+6.2);
$pdf->Cell(3.5,0.22,'C.U.I.T.: '.$emp_cuit.' - Ing. Brutos: '.$emp_ingb);

$pdf->SetFont('Arial','B',4);
$pdf->SetY($Y3+0.94);
$pdf->SetX($eje_x_original+6.8);
$pdf->Cell(3.5,0.22,'Inicio de Actividad: '.$emp_inic);

// Cabecera Info de abonado
$pdf->Line($eje_x_original, $cabecera_alto + $cab_tit_alto + $Y3 - 0.20 , $cabecera_ancho, $cabecera_alto + $cab_tit_alto +$Y3- 0.20); 

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2 + (+ $Y3 - 0.20) );
$pdf->SetX(0.2);
$pdf->Cell(3.5,0.22,'Abonado:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2 + (+ $Y3 - 0.20) );
$pdf->SetX($ANCHO-2.5);
$pdf->Cell(3.5,0.22,'No.:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40 + (+ $Y3 - 0.20) );
$pdf->SetX(0.2);
$pdf->Cell(3.5,0.22,'Domicilio:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40 + (+ $Y3 - 0.20) );
$pdf->SetX($ANCHO-2.5);
$pdf->Cell(3.5,0.22,'C.U.I.T.:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40 + (+ $Y3 - 0.20) );
$pdf->SetX(0.2);
$pdf->Cell(3.5,0.22,'Condicion de Pago:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40 + (+ $Y3 - 0.20) );
$pdf->SetX($ANCHO-6.20);
$pdf->Cell(3.5,0.22,'Periodo:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40 + (+ $Y3 - 0.20) );
$pdf->SetX($ANCHO-2.5);
$pdf->Cell(3.5,0.22,'Vencimiento:');

// Cuerpo
$pdf->Line($eje_x_original, $cuerpo_alto + $Y3 - 0.20, $cuerpo_ancho, $cuerpo_alto+$Y3- 0.20); 

// Titulo del cuerpo
$pdf->Line($eje_x_original, $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto + $Y3 - 0.20 , $cabecera_ancho, $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto +$Y3- 0.20); 

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30 + ($Y3- 0.20));
$pdf->SetX(0.60);
$pdf->Cell(3.5,0.22,'Cantidad');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30 + ($Y3- 0.20));
$pdf->SetX(3.87);
$pdf->Cell(3.5,0.22,'Descripcion');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30 + ($Y3- 0.20));
$pdf->SetX($ANCHO  - (($ANCHO - $cuerpo_div + 0.50 )/2));
$pdf->Cell(3.5,0.22,'Importe');


// Linea que divide el cuerpo
$pdf->Line($eje_x_original + $cuerpo_div ,  $cabecera_alto + $cab_tit_alto +$Y3- 0.20, $eje_x_original + $cuerpo_div , $cuerpo_alto + $Y3 - 0.20 + ($ALTURA - $cuerpo_alto + 0.20 ) ); 

$pdf->SetFont('Arial','B',11);
$pdf->SetY($ALTURA - 0.20  + $Y3 - 0.20);
$pdf->SetX($ANCHO  - ($ANCHO - $cuerpo_div) - 1.28  );
$pdf->Cell(1,0.22,'TOTAL');

#Duplicado
$pdf->Rect($eje_x_duplicado,$Y3,$ANCHO,$ALTURA,'D');

// Cabecera
$pdf->Line($eje_x_duplicado, $cabecera_alto+$Y3- 0.20, $eje_x_duplicado + $ANCHO , $cabecera_alto+$Y3- 0.20); 

// Linea que divide el encabezado
$pdf->Line($enca_div + $eje_x_duplicado, $Y3 , $enca_div + $eje_x_duplicado, $cabecera_alto+$Y3- 0.20); 


$pdf->SetFont('Arial','B',20);
$pdf->SetY($Y3);
$pdf->SetX($eje_x_duplicado);
$pdf->Cell(1.7,1,'SEM');

$pdf->SetFont('Arial','U',5);
$pdf->SetY($Y3+0.22);
$pdf->SetX($eje_x_duplicado+1.52);
$pdf->Cell(3.5,0.22,'SERVICIO DE EMERGENCIAS MEDICAS');


$pdf->SetFont('Arial','B',4.5);
$pdf->SetY($Y3+0.80);
$pdf->SetX($eje_x_duplicado);
$pdf->Cell(3.5,0.22,$emp_dir.' - TEL.: '.$emp_tel.' - '.$emp_loc.' '.$emp_pro);

$pdf->SetFont('Arial','B',5);
$pdf->SetY($Y3+0.2);
$pdf->SetX($eje_x_duplicado+5.3);
$pdf->Cell(3.5,0.22,'COMPROBANTE No. 0002');

$pdf->SetFont('Arial','B',5);
$pdf->SetY($Y3+0.45);
$pdf->SetX($eje_x_duplicado+5.3);
$pdf->Cell(3.5,0.22,'Fecha: 21/01/1985');

$pdf->SetFont('Arial','B',8);
$pdf->SetY($Y3+0.45);
$pdf->SetX($eje_x_duplicado+8.40);
$pdf->Cell(3.5,0.22,'DUPLICADO');

$pdf->SetFont('Arial','B',4);
$pdf->SetY($Y3+0.80);
$pdf->SetX($eje_x_duplicado+6.2);
$pdf->Cell(3.5,0.22,'C.U.I.T.: '.$emp_cuit.' - Ing. Brutos: '.$emp_ingb);

$pdf->SetFont('Arial','B',4);
$pdf->SetY($Y3+0.94);
$pdf->SetX($eje_x_duplicado+6.8);
$pdf->Cell(3.5,0.22,'Inicio de Actividad: '.$emp_inic);

// Cabecera Info de abonado
$pdf->Line($eje_x_duplicado, $cabecera_alto + $cab_tit_alto +$Y3- 0.20 , $eje_x_duplicado + $ANCHO, $cabecera_alto + $cab_tit_alto +$Y3- 0.20 ); 


$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2 + (+ $Y3 - 0.20) );
$pdf->SetX($eje_x_duplicado+0.2);
$pdf->Cell(3.5,0.22,'Abonado:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2 + (+ $Y3 - 0.20) );
$pdf->SetX($eje_x_duplicado+$ANCHO-2.5);
$pdf->Cell(3.5,0.22,'No.:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40 + (+ $Y3 - 0.20) );
$pdf->SetX(0.2);
$pdf->Cell(3.5,0.22,'Domicilio:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40 + (+ $Y3 - 0.20) );
$pdf->SetX($eje_x_duplicado+$ANCHO-2.5);
$pdf->Cell(3.5,0.22,'C.U.I.T.:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40 + (+ $Y3 - 0.20) );
$pdf->SetX($eje_x_duplicado+0.2);
$pdf->Cell(3.5,0.22,'Condicion de Pago:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40 + (+ $Y3 - 0.20) );
$pdf->SetX($eje_x_duplicado+$ANCHO-6.20);
$pdf->Cell(3.5,0.22,'Periodo:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40 + (+ $Y3 - 0.20) );
$pdf->SetX($eje_x_duplicado+$ANCHO-2.5);
$pdf->Cell(3.5,0.22,'Vencimiento:');


// Cuerpo
$pdf->Line($eje_x_duplicado, $cuerpo_alto+$Y3- 0.20, $eje_x_duplicado + $ANCHO, $cuerpo_alto+$Y3- 0.20);

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30 + ($Y3- 0.20));
$pdf->SetX($eje_x_duplicado+0.60);
$pdf->Cell(3.5,0.22,'Cantidad');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30  + ($Y3- 0.20));
$pdf->SetX($eje_x_duplicado+3.87);
$pdf->Cell(3.5,0.22,'Descripcion');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30 + ($Y3- 0.20));
$pdf->SetX($eje_x_duplicado - 0.20 + $ANCHO  - (($ANCHO - $cuerpo_div + 0.50 )/2));
$pdf->Cell(3.5,0.22,'Importe');

// Titulo del cuerpo
$pdf->Line($eje_x_duplicado, $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto +$Y3- 0.20 , $eje_x_duplicado + $ANCHO , $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto+$Y3- 0.20);  

// Linea que divide el cuerpo
$pdf->Line($eje_x_duplicado + $cuerpo_div ,  $cabecera_alto + $cab_tit_alto + $Y3- 0.20, $eje_x_duplicado + $cuerpo_div, $cuerpo_alto +$Y3- 0.20 + ($ALTURA - $cuerpo_alto + 0.20 ) ); 

$pdf->SetFont('Arial','B',11);
$pdf->SetY($ALTURA - 0.20 + ($Y3- 0.20));
$pdf->SetX($eje_x_duplicado + $ANCHO  - ($ANCHO - $cuerpo_div) - 1.28 -  0.20 );
$pdf->Cell(1,0.22,'TOTAL');



/* 3er cupon - Original */
// Rectangulo
$pdf->Rect($eje_x_original,$Y5,$ANCHO,$ALTURA,'D');

// Cabecera
$pdf->Line($eje_x_original, $cabecera_alto + $Y5- 0.20, $cabecera_ancho, $cabecera_alto+$Y5- 0.20); 

// Linea que divide el encabezado
$pdf->Line($enca_div + $eje_x_original, $Y5 , $enca_div + $eje_x_original, $cabecera_alto+$Y5- 0.20); 

$pdf->SetFont('Arial','B',20);
$pdf->SetY($Y5);
$pdf->SetX($eje_x_original);
$pdf->Cell(1.7,1,'SEM');

$pdf->SetFont('Arial','U',5);
$pdf->SetY($Y5+0.22);
$pdf->SetX($eje_x_original+1.52);
$pdf->Cell(3.5,0.22,'SERVICIO DE EMERGENCIAS MEDICAS');

$pdf->SetFont('Arial','B',4.5);
$pdf->SetY($Y5+0.80);
$pdf->SetX($eje_x_original);
$pdf->Cell(3.5,0.22,$emp_dir.' - TEL.: '.$emp_tel.' - '.$emp_loc.' '.$emp_pro);

$pdf->SetFont('Arial','B',5);
$pdf->SetY($Y5+0.2);
$pdf->SetX($eje_x_original+5.3);
$pdf->Cell(3.5,0.22,'COMPROBANTE No. 0002');

$pdf->SetFont('Arial','B',5);
$pdf->SetY($Y5+0.45);
$pdf->SetX($eje_x_original+5.3);
$pdf->Cell(3.5,0.22,'Fecha: 21/01/1985');

$pdf->SetFont('Arial','B',8);
$pdf->SetY($Y5+0.45);
$pdf->SetX($eje_x_original+8.4);
$pdf->Cell(3.5,0.22,'ORIGINAL');

$pdf->SetFont('Arial','B',4);
$pdf->SetY($Y5+0.80);
$pdf->SetX($eje_x_original+6.2);
$pdf->Cell(3.5,0.22,'C.U.I.T.: '.$emp_cuit.' - Ing. Brutos: '.$emp_ingb);

$pdf->SetFont('Arial','B',4);
$pdf->SetY($Y5+0.94);
$pdf->SetX($eje_x_original+6.8);
$pdf->Cell(3.5,0.22,'Inicio de Actividad: '.$emp_inic);

// Cabecera Info de abonado
$pdf->Line($eje_x_original, $cabecera_alto + $cab_tit_alto + $Y5 - 0.20 , $cabecera_ancho, $cabecera_alto + $cab_tit_alto +$Y5- 0.20); 

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2 + (+ $Y5 - 0.20) );
$pdf->SetX(0.2);
$pdf->Cell(3.5,0.22,'Abonado:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2 + (+ $Y5 - 0.20) );
$pdf->SetX($ANCHO-2.5);
$pdf->Cell(3.5,0.22,'No.:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40 + (+ $Y5 - 0.20) );
$pdf->SetX(0.2);
$pdf->Cell(3.5,0.22,'Domicilio:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40 + (+ $Y5 - 0.20) );
$pdf->SetX($ANCHO-2.5);
$pdf->Cell(3.5,0.22,'C.U.I.T.:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40 + (+ $Y5 - 0.20) );
$pdf->SetX(0.2);
$pdf->Cell(3.5,0.22,'Condicion de Pago:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40 + (+ $Y5 - 0.20) );
$pdf->SetX($ANCHO-6.20);
$pdf->Cell(3.5,0.22,'Periodo:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40 + (+ $Y5 - 0.20) );
$pdf->SetX($ANCHO-2.5);
$pdf->Cell(3.5,0.22,'Vencimiento:');



// Cuerpo
$pdf->Line($eje_x_original, $cuerpo_alto + $Y5- 0.20, $cuerpo_ancho, $cuerpo_alto+$Y5- 0.20); 

// Titulo del cuerpo
$pdf->Line($eje_x_original, $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto + $Y5 - 0.20 , $cabecera_ancho, $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto +$Y5- 0.20); 

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30 + ($Y5- 0.20));
$pdf->SetX(0.60);
$pdf->Cell(3.5,0.22,'Cantidad');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30 + ($Y5- 0.20));
$pdf->SetX(3.87);
$pdf->Cell(3.5,0.22,'Descripcion');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30 + ($Y5- 0.20));
$pdf->SetX($ANCHO  - (($ANCHO - $cuerpo_div + 0.50 )/2));
$pdf->Cell(3.5,0.22,'Importe');


// Linea que divide el cuerpo
$pdf->Line($eje_x_original + $cuerpo_div ,  $cabecera_alto + $cab_tit_alto +$Y5- 0.20, $eje_x_original + $cuerpo_div , $cuerpo_alto + $Y5 - 0.20 + ($ALTURA - $cuerpo_alto + 0.20 ) ); 

$pdf->SetFont('Arial','B',11);
$pdf->SetY($ALTURA - 0.20  + $Y5 - 0.20);
$pdf->SetX($ANCHO  - ($ANCHO - $cuerpo_div) - 1.28  );
$pdf->Cell(1,0.22,'TOTAL');

#Duplicado
//Rectangulo
$pdf->Rect($eje_x_duplicado,$Y5,$ANCHO,$ALTURA,'D');

// Cabecera
$pdf->Line($eje_x_duplicado, $cabecera_alto+$Y5- 0.20, $eje_x_duplicado + $ANCHO , $cabecera_alto+$Y5- 0.20);

// Linea que divide el encabezado
$pdf->Line($enca_div + $eje_x_duplicado, $Y5 , $enca_div + $eje_x_duplicado, $cabecera_alto+$Y5- 0.20); 

$pdf->SetFont('Arial','B',20);
$pdf->SetY($Y5);
$pdf->SetX($eje_x_duplicado);
$pdf->Cell(1.7,1,'SEM');

$pdf->SetFont('Arial','U',5);
$pdf->SetY($Y5+0.22);
$pdf->SetX($eje_x_duplicado+1.52);
$pdf->Cell(3.5,0.22,'SERVICIO DE EMERGENCIAS MEDICAS');

$pdf->SetFont('Arial','B',4.5);
$pdf->SetY($Y5+0.80);
$pdf->SetX($eje_x_duplicado);
$pdf->Cell(3.5,0.22,$emp_dir.' - TEL.: '.$emp_tel.' - '.$emp_loc.' '.$emp_pro);


$pdf->SetFont('Arial','B',5);
$pdf->SetY($Y5+0.2);
$pdf->SetX($eje_x_duplicado+5.3);
$pdf->Cell(3.5,0.22,'COMPROBANTE No. 0002');

$pdf->SetFont('Arial','B',5);
$pdf->SetY($Y5+0.45);
$pdf->SetX($eje_x_duplicado+5.3);
$pdf->Cell(3.5,0.22,'Fecha: 21/01/1985');

$pdf->SetFont('Arial','B',8);
$pdf->SetY($Y5+0.45);
$pdf->SetX($eje_x_duplicado+8.4);
$pdf->Cell(3.5,0.22,'DUPLICADO');

$pdf->SetFont('Arial','B',4);
$pdf->SetY($Y5+0.80);
$pdf->SetX($eje_x_duplicado+6.2);
$pdf->Cell(3.5,0.22,'C.U.I.T.: '.$emp_cuit.' - Ing. Brutos: '.$emp_ingb);

$pdf->SetFont('Arial','B',4);
$pdf->SetY($Y5+0.94);
$pdf->SetX($eje_x_duplicado+6.8);
$pdf->Cell(3.5,0.22,'Inicio de Actividad: '.$emp_inic);

// Cabecera Info de abonado
$pdf->Line($eje_x_duplicado, $cabecera_alto + $cab_tit_alto +$Y5- 0.20 , $eje_x_duplicado + $ANCHO, $cabecera_alto + $cab_tit_alto +$Y5- 0.20 ); 

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2 + (+ $Y5 - 0.20) );
$pdf->SetX($eje_x_duplicado+0.2);
$pdf->Cell(3.5,0.22,'Abonado:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2 + (+ $Y5 - 0.20) );
$pdf->SetX($eje_x_duplicado+$ANCHO-2.5);
$pdf->Cell(3.5,0.22,'No.:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40 + (+ $Y5 - 0.20) );
$pdf->SetX(0.2);
$pdf->Cell(3.5,0.22,'Domicilio:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40 + (+ $Y5 - 0.20) );
$pdf->SetX($eje_x_duplicado+$ANCHO-2.5);
$pdf->Cell(3.5,0.22,'C.U.I.T.:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40 + (+ $Y5 - 0.20) );
$pdf->SetX($eje_x_duplicado+0.2);
$pdf->Cell(3.5,0.22,'Condicion de Pago:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40 + (+ $Y5 - 0.20) );
$pdf->SetX($eje_x_duplicado+$ANCHO-6.20);
$pdf->Cell(3.5,0.22,'Periodo:');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40 + (+ $Y5 - 0.20) );
$pdf->SetX($eje_x_duplicado+$ANCHO-2.5);
$pdf->Cell(3.5,0.22,'Vencimiento:');

// Cuerpo
$pdf->Line($eje_x_duplicado, $cuerpo_alto+$Y5- 0.20, $eje_x_duplicado + $ANCHO, $cuerpo_alto+$Y5- 0.20); 

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30 + ($Y5- 0.20));
$pdf->SetX($eje_x_duplicado+0.60);
$pdf->Cell(3.5,0.22,'Cantidad');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY($cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30  + ($Y5- 0.20));
$pdf->SetX($eje_x_duplicado+3.87);
$pdf->Cell(3.5,0.22,'Descripcion');

$pdf->SetFont('Arial','B',5.5);
$pdf->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30 + ($Y5- 0.20));
$pdf->SetX($eje_x_duplicado - 0.20 + $ANCHO  - (($ANCHO - $cuerpo_div + 0.50 )/2));
$pdf->Cell(3.5,0.22,'Importe');

// Titulo del cuerpo
$pdf->Line($eje_x_duplicado, $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto +$Y5- 0.20 , $eje_x_duplicado + $ANCHO , $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto+$Y5- 0.20);  

$pdf->SetFont('Arial','B',11);
$pdf->SetY($ALTURA - 0.20 + ($Y5- 0.20));
$pdf->SetX($eje_x_duplicado + $ANCHO  - ($ANCHO - $cuerpo_div) - 1.28 -  0.20 );
$pdf->Cell(1,0.22,'TOTAL');


// Linea que divide el cuerpo
$pdf->Line($eje_x_duplicado + $cuerpo_div ,  $cabecera_alto + $cab_tit_alto + $Y5- 0.20, $eje_x_duplicado + $cuerpo_div, $cuerpo_alto +$Y5- 0.20 + ($ALTURA - $cuerpo_alto + 0.20 ) ); 



$pdf->Output();


//$pdf->Output('sem_comprobante_000.pdf','D');

?>