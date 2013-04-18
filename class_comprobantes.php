<?php

include_once ('config.php');

//funciones propias
include ('funciones.php');

// libreria para crear pdf
require('fpdf.php');




class comprobante extends FPDF 
{
    # PROPIEDADES

    public  $array_parametros;   # Array con datos parametrizados
    public  $array_comprobante; # Datos para imprimir en el comprobante
    public  $array_empresa; # Array con datos de la empresa

    # METODOS

    /* Metodos de la clase fpdf */
    public function Header(){
    }

    public function Footer(){
    }

    /* Metodos para codigos de barra */
    public function EAN13($x, $y, $barcode, $h=5, $w=0.15)
    {
        $this->Barcode($x,$y,$barcode,$h/10,$w/10,2);
    }

    public function UPC_A($x, $y, $barcode, $h=16, $w=.35)
    {
        $this->Barcode($x,$y,$barcode,$h,$w,12);
    }

    public function GetCheckDigit($barcode)
    {
        //Compute the check digit
        $sum=0;
        for($i=1;$i<=11;$i+=2)
            $sum+=3*$barcode[$i];
        for($i=0;$i<=10;$i+=2)
            $sum+=$barcode[$i];
        $r=$sum%10;
        if($r>0)
            $r=10-$r;
        return $r;
    }

    public function TestCheckDigit($barcode)
    {
        //Test validity of check digit
        $sum=0;
        for($i=1;$i<=11;$i+=2)
            $sum+=3*$barcode[$i];
        for($i=0;$i<=10;$i+=2)
            $sum+=$barcode[$i];
        return ($sum+$barcode[12])%10==0;
    }

    public function Barcode($x, $y, $barcode, $h, $w, $len)
    {
        //Padding
        $barcode=str_pad($barcode,$len-1,'0',STR_PAD_LEFT);
        if($len==12)
            $barcode='0'.$barcode;
        //Add or control the check digit
        if(strlen($barcode)==12)
            $barcode.=$this->GetCheckDigit($barcode);
        elseif(!$this->TestCheckDigit($barcode))
            //$this->Error('Incorrect check digit');
            return ('');
        //Convert digits to bars
        $codes=array(
            'A'=>array(
                '0'=>'0001101','1'=>'0011001','2'=>'0010011','3'=>'0111101','4'=>'0100011',
                '5'=>'0110001','6'=>'0101111','7'=>'0111011','8'=>'0110111','9'=>'0001011'),
            'B'=>array(
                '0'=>'0100111','1'=>'0110011','2'=>'0011011','3'=>'0100001','4'=>'0011101',
                '5'=>'0111001','6'=>'0000101','7'=>'0010001','8'=>'0001001','9'=>'0010111'),
            'C'=>array(
                '0'=>'1110010','1'=>'1100110','2'=>'1101100','3'=>'1000010','4'=>'1011100',
                '5'=>'1001110','6'=>'1010000','7'=>'1000100','8'=>'1001000','9'=>'1110100')
            );
        $parities=array(
            '0'=>array('A','A','A','A','A','A'),
            '1'=>array('A','A','B','A','B','B'),
            '2'=>array('A','A','B','B','A','B'),
            '3'=>array('A','A','B','B','B','A'),
            '4'=>array('A','B','A','A','B','B'),
            '5'=>array('A','B','B','A','A','B'),
            '6'=>array('A','B','B','B','A','A'),
            '7'=>array('A','B','A','B','A','B'),
            '8'=>array('A','B','A','B','B','A'),
            '9'=>array('A','B','B','A','B','A')
            );
        $code='101';
        $p=$parities[$barcode[0]];
        for($i=1;$i<=6;$i++)
            $code.=$codes[$p[$i-1]][$barcode[$i]];
        $code.='01010';
        for($i=7;$i<=12;$i++)
            $code.=$codes['C'][$barcode[$i]];
        $code.='101';
        //Draw bars
        for($i=0;$i<strlen($code);$i++)
        {
            if($code[$i]=='1')
                $this->Rect($x+$i*$w,$y,$w,$h,'F');
        }
        //Print text uder barcode
        //$this->SetFont('Arial','',5.5);
        //$this->Text($x,$y+$h+11/$this->k,substr($barcode,-$len));
    }

    /* Metodos construnctor */
    public function comprobante($var_array_param ,$var_array_empresa, $var_array_comprobante)
    {

        $this->array_empresa     = $var_array_empresa;
        $this->array_parametros  = $var_array_param;
        $this->array_comprobante = $var_array_comprobante;

        
        $this->FPDF($this->array_parametros['fpdf_orientation'],
                    $this->array_parametros['fpdf_unit'],
                    $this->array_parametros['fpdf_format']);
    }

    /* Metodos para obtener y mostrar datos */
    public function get_datos_empresa (){

        return $this->array_empresa;

    }

    public function get_datos_parametros (){

        return $this->array_parametros;

    }

    /* Metodos para imprimir los comprobantes */
    public function generar_comprobantes (){

        $this->AliasNbPages();
        $this->AddPage();
        $this->SetFont('Arial','',8);
        $this->SetAutoPageBreak(true,0.2);

        /***** Parametros fijos de los comprobantes *****/
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
        $cab_tit_alt            = 0;

        # Coordenadas de inicio de los cupones
        $eje_x_original  	= 0.20;  // Eje x : Inicio de los cupones de la izquierda
        $eje_x_duplicado 	= 10.50; // Eje x : Inicio de los cupones de la derecha
        $Y1      		= 00.20; // Eje y : Inicio del 1er cupon
        $Y3      		= 10.00; // Eje y : Inicio del 2do cupon
        $Y5      		= 19.78; // Eje y : Inicio del 3er cupon

        /**** 1er cupon ****/
        /**** 1er cupon ****/
        /**** 1er cupon ****/
        /**** 1er cupon ****/

        //for ($this->array_comprobante)
        for ($c_comp = 0 ; $c_comp <= count($this->array_comprobante) ; $c_comp++)
        {


        // Rectangulo
        $this->Rect($eje_x_original,$Y1,$ANCHO,$ALTURA,'D');

        // Cabecera
        $this->Line($eje_x_original, $cabecera_alto, $cabecera_ancho, $cabecera_alto);

        // Linea que divide el encabezado
        $this->Line($enca_div + $eje_x_original, $Y1 , $enca_div + $eje_x_original, $cabecera_alto);

        $this->SetFont('Arial','B',20);
        $this->SetY($Y1);
        $this->SetX($eje_x_original);
        $this->Image($this->array_parametros['comp_logo'], $eje_x_original+0.05, $Y1+0.05, 2, 0.75, 'jpg');

        $this->SetFont('Arial','U',4.4);
        $this->SetY($Y1+0.22);
        $this->SetX($eje_x_original+2);
        $this->Cell(3.5,0.22,$this->array_parametros['comp_tiulo']);

        $this->SetFont('Arial','B',4.5);
        $this->SetY($Y1+0.90);
        $this->SetX($eje_x_original);
        $this->Cell(3.5,0.22,$this->array_empresa['emp_dir'].
                                    ' - TEL.: '.$this->array_empresa['emp_tel'].
                                    ' - '.$this->array_empresa['emp_loc'].
                                    ' '.$this->array_empresa['emp_pro']);

        $this->SetFont('Arial','B',5);
        $this->SetY($Y1+0.2);
        $this->SetX($eje_x_original+5.3);
        $this->Cell(3.5,0.22,'COMPROBANTE No. '.$this->array_comprobante[$c_comp]['noComprobante']);

        $this->SetFont('Arial','B',5);
        $this->SetY($Y1+0.45);
        $this->SetX($eje_x_original+5.3);
        $this->Cell(3.5,0.22,'Fecha: '.$this->array_parametros['comp_fecha']);

        $this->SetFont('Arial','B',8);
        $this->SetY($Y1+0.45);
        $this->SetX($eje_x_original+8.40);
        $this->Cell(3.5,0.22,'ORIGINAL');

        $this->SetFont('Arial','B',4);
        $this->SetY($Y1+0.80);
        $this->SetX($eje_x_original+6.2);
        $this->Cell(3.5,0.22,'C.U.I.T.: '.$this->array_empresa['emp_cuit'].
                             ' - Ing. Brutos: '.$this->array_empresa['emp_ingb']);

        $this->SetFont('Arial','B',4);
        $this->SetY($Y1+0.94);
        $this->SetX($eje_x_original+6.8);
        $this->Cell(3.5,0.22,'Inicio de Actividad: '.$this->array_empresa['emp_inic']);


        // Cabecera Info de abonado
        $this->Line($eje_x_original, $cabecera_alto + $cab_tit_alto , $cabecera_ancho, $cabecera_alto + $cab_tit_alto );

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2);
        $this->SetX(0.2);
        $this->Cell(3.5,0.22,'Abonado: '.$this->array_comprobante[$c_comp]['abonado']);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2);
        $this->SetX($ANCHO-2.5);
        $this->Cell(3.5,0.22,'No.: '.$this->array_comprobante[$c_comp]['noComprobante']);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40);
        $this->SetX(0.2);
        $this->Cell(3.5,0.22,'Domicilio: '.$this->array_comprobante[$c_comp]['domicilio']);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40);
        $this->SetX($ANCHO-2.5);
        $this->Cell(3.5,0.22,'C.U.I.T.: '.$this->array_comprobante[$c_comp]['cuit']);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40);
        $this->SetX(0.2);
        $this->Cell(3.5,0.22,'Condicion de Pago: '.$this->array_comprobante[$c_comp]['condPago']);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40);
        $this->SetX($ANCHO-6.20);
        $this->Cell(3.5,0.22,'Periodo: '.$this->array_comprobante[$c_comp]['periodo']);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40);
        $this->SetX($ANCHO-2.5);
        $this->Cell(3.5,0.22,'Vencimiento: '.$this->array_comprobante[$c_comp]['vencimiento']);

        // Cuerpo
        $this->Line($eje_x_original, $cuerpo_alto, $cuerpo_ancho, $cuerpo_alto);

        // Titulo del cuerpo
        $this->Line($eje_x_original, $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto , $cabecera_ancho, $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto);

        $this->SetFont('Arial','B',5.5);
        $this->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30);
        $this->SetX(0.60);
        $this->Cell(3.5,0.22,'Cantidad');

        $this->SetFont('Arial','B',5.5);
        $this->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30);
        $this->SetX(3.87);
        $this->Cell(3.5,0.22,'Descripcion');

        $this->SetFont('Arial','B',5.5);
        $this->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30);
        $this->SetX($ANCHO  - (($ANCHO - $cuerpo_div + 0.50 )/2));
        $this->Cell(3.5,0.22,'Importe');

        for ($c=0; $c <= count($this->array_comprobante[$c_comp]['cantidad']) ; $c++) {

            /* Muestra la columna cantidad */
            $this->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30 + (0.40*($c+1)));
            $this->SetX(0.60);
            $this->Cell(3.5,0.22,$this->array_comprobante[$c_comp]['cantidad'][$c]);

            $this->SetX(3.87);
            $this->Cell(3.5,0.22,$this->array_comprobante[$c_comp]['descripcion'][$c]);

            $this->SetX($ANCHO  - (($ANCHO - $cuerpo_div + 0.50 )/2));
            $this->Cell(3.5,0.22,$this->array_comprobante[$c_comp]['importe'][$c]);

        }

        $this->SetFont('Arial','B',5);
        $this->SetY($ALTURA - 1);
        $this->SetX(0.60);
        $this->Cell(3.5,0.22,str_pad($this->array_comprobante[$c_comp]['noComprobante'], 12, "0", STR_PAD_LEFT));

        // Genero el codigos de barra
        $this->EAN13(0.60,
                     $ALTURA - 1.50,
            str_pad($this->array_comprobante[$c_comp]['noComprobante'], 12, "0", STR_PAD_LEFT));


        // Linea que divide el cuerpo
        $this->Line($eje_x_original + $cuerpo_div ,  $cabecera_alto + $cab_tit_alto , $eje_x_original + $cuerpo_div, $cuerpo_alto + ($ALTURA - $cuerpo_alto + 0.20 ) );

        $this->SetFont('Arial','B',11);
        $this->SetY($ALTURA - 0.20);
        $this->SetX($ANCHO  - ($ANCHO - $cuerpo_div) - 1.28  );
        $this->Cell(1,0.22,'TOTAL');

        $this->SetFont('Arial','B',8);
        $this->SetY($ALTURA - 0.20);
        $this->SetX($ANCHO  - 1  );
        $this->Cell(1,0.22,$this->array_comprobante[$c_comp]['total']);

        #Duplicado ************************************************************
        #**********************************************************************

        // Rectangulo
        $this->Rect($eje_x_duplicado,$Y1,$ANCHO,$ALTURA,'D');

        // Cabecera
        $this->Line($eje_x_duplicado, $cabecera_alto, $eje_x_duplicado + $ANCHO , $cabecera_alto);

        // Linea que divide el encabezado
        $this->Line($enca_div + $eje_x_duplicado, $Y1 , $enca_div + $eje_x_duplicado, $cabecera_alto);


        $this->SetFont('Arial','B',20);
        $this->SetY($Y1);
        $this->SetX($eje_x_duplicado);
        $this->Image($this->array_parametros['comp_logo'], $eje_x_duplicado+0.05, $Y1+0.05, 2, 0.75, 'jpg');
       
        $this->SetFont('Arial','U',4.4);
        $this->SetY($Y1+0.22);
        $this->SetX($eje_x_duplicado+2);
        $this->Cell(3.5,0.22,$this->array_parametros['comp_tiulo']);

        $this->SetFont('Arial','B',4.5);
        $this->SetY($Y1+0.90);
        $this->SetX($eje_x_duplicado);
        $this->Cell(3.5,0.22,$this->array_empresa['emp_dir'].
                                    ' - TEL.: '.$this->array_empresa['emp_tel'].
                                    ' - '.$this->array_empresa['emp_loc'].
                                    ' '.$this->array_empresa['emp_pro']);

        $this->SetFont('Arial','B',5);
        $this->SetY($Y1+0.2);
        $this->SetX($eje_x_duplicado+5.3);
        $this->Cell(3.5,0.22,'COMPROBANTE No. '.$this->array_comprobante[$c_comp]['noComprobante']);

        $this->SetFont('Arial','B',5);
        $this->SetY($Y1+0.45);
        $this->SetX($eje_x_duplicado+5.3);
        $this->Cell(3.5,0.22,'Fecha: '.$this->array_parametros['comp_fecha']);

        $this->SetFont('Arial','B',8);
        $this->SetY($Y1+0.45);
        $this->SetX($eje_x_duplicado+8.40);
        $this->Cell(3.5,0.22,'DUPLICADO');

        $this->SetFont('Arial','B',4);
        $this->SetY($Y1+0.80);
        $this->SetX($eje_x_duplicado+6.2);
        $this->Cell(3.5,0.22,'C.U.I.T.: '.$this->array_empresa['emp_cuit'].
                             ' - Ing. Brutos: '.$this->array_empresa['emp_ingb']);

        $this->SetFont('Arial','B',4);
        $this->SetY($Y1+0.94);
        $this->SetX($eje_x_duplicado+6.8);
        $this->Cell(3.5,0.22,'Inicio de Actividad: '.$this->array_empresa['emp_inic']);

        // Cabecera Info de abonado
        $this->Line($eje_x_duplicado, $cabecera_alto + $cab_tit_alto , $eje_x_duplicado + $ANCHO, $cabecera_alto + $cab_tit_alto );
       
        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2);
        $this->SetX($eje_x_duplicado+0.2);
        $this->Cell(3.5,0.22,'Abonado: '.$this->array_comprobante[$c_comp]['abonado']);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2);
        $this->SetX($eje_x_duplicado+$ANCHO-2.5);
        $this->Cell(3.5,0.22,'No.: '.$this->array_comprobante[$c_comp]['noComprobante']);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40);
        $this->SetX($eje_x_duplicado+0.2);
        $this->Cell(3.5,0.22,'Domicilio: '.$this->array_comprobante[$c_comp]['domicilio']);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40);
        $this->SetX($eje_x_duplicado+$ANCHO-2.5);
        $this->Cell(3.5,0.22,'C.U.I.T.: '.$this->array_comprobante[$c_comp]['cuit']);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40);
        $this->SetX($eje_x_duplicado+0.2);
        $this->Cell(3.5,0.22,'Condicion de Pago: '.$this->array_comprobante[$c_comp]['condPago']);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40);
        $this->SetX($eje_x_duplicado+$ANCHO-6.20);
        $this->Cell(3.5,0.22,'Periodo: '.$this->array_comprobante[$c_comp]['periodo']);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40);
        $this->SetX($eje_x_duplicado+$ANCHO-2.5);
        $this->Cell(3.5,0.22,'Vencimiento: '.$this->array_comprobante[$c_comp]['vencimiento']);

        // Cuerpo
        $this->Line($eje_x_duplicado, $cuerpo_alto, $eje_x_duplicado + $ANCHO, $cuerpo_alto);

        // Titulo del cuerpo
        $this->Line($eje_x_duplicado, $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto , $eje_x_duplicado + $ANCHO, $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto);

        $this->SetFont('Arial','B',5.5);
        $this->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30);
        $this->SetX($eje_x_duplicado+0.60);
        $this->Cell(3.5,0.22,'Cantidad');

        $this->SetFont('Arial','B',5.5);
        $this->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30);
        $this->SetX($eje_x_duplicado+3.87);
        $this->Cell(3.5,0.22,'Descripcion');

        $this->SetFont('Arial','B',5.5);
        $this->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30);
        $this->SetX($eje_x_duplicado - 0.20 + $ANCHO  - (($ANCHO - $cuerpo_div + 0.50 )/2));
        $this->Cell(3.5,0.22,'Importe');

        for ($c=0; $c <= count($this->array_comprobante[$c_comp]['cantidad']) ; $c++) {

            /* Muestra la columna cantidad */
            $this->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30 + (0.40*($c+1)));
            $this->SetX($eje_x_duplicado+0.60);
            $this->Cell(3.5,0.22,$this->array_comprobante[$c_comp]['cantidad'][$c]);

            $this->SetX($eje_x_duplicado+3.87);
            $this->Cell(3.5,0.22,$this->array_comprobante[$c_comp]['descripcion'][$c]);

            $this->SetX($eje_x_duplicado - 0.20 + $ANCHO  - (($ANCHO - $cuerpo_div + 0.50 )/2));
            $this->Cell(3.5,0.22,$this->array_comprobante[$c_comp]['importe'][$c]);

        }

        $this->SetFont('Arial','B',5);
        $this->SetY($ALTURA - 1);
        $this->SetX($eje_x_duplicado+0.60);
        $this->Cell(3.5,0.22,str_pad($this->array_comprobante[$c_comp]['noComprobante'], 12, "0", STR_PAD_LEFT));

        // Genero el codigos de barra
        $this->EAN13($eje_x_duplicado+0.60,
                     $ALTURA - 1.50,
            str_pad($this->array_comprobante[$c_comp]['noComprobante'], 12, "0", STR_PAD_LEFT));


        // Linea que divide el cuerpo
        $this->Line($eje_x_duplicado + $cuerpo_div ,  $cabecera_alto + $cab_tit_alto , $eje_x_duplicado + $cuerpo_div, $cuerpo_alto + ($ALTURA - $cuerpo_alto + 0.20 ) );

        $this->SetFont('Arial','B',11);
        $this->SetY($ALTURA - 0.20);
        $this->SetX($eje_x_duplicado + $ANCHO  - ($ANCHO - $cuerpo_div) - 1.28 -  0.20 );
        $this->Cell(1,0.22,'TOTAL');

        $this->SetFont('Arial','B',8);
        $this->SetY($ALTURA - 0.20);
        $this->SetX($eje_x_duplicado + $ANCHO  - 1  );
        $this->Cell(1,0.22,$this->array_comprobante[$c_comp]['total']);

        /**** 2do cupon ****/
        /**** 2do cupon ****/
        /**** 2do cupon ****/
        // Incremento el contador de comprobantes
        $c_comp = $c_comp+1;
        // Rectangulo
        $this->Rect($eje_x_original,$Y3,$ANCHO,$ALTURA,'D');

        // Cabecera
        $this->Line($eje_x_original, $cabecera_alto + $Y3 - 0.20, $cabecera_ancho, $cabecera_alto+$Y3- 0.20);

        // Linea que divide el encabezado
        $this->Line($enca_div + $eje_x_original, $Y3 , $enca_div + $eje_x_original, $cabecera_alto+$Y3- 0.20);


        $this->SetFont('Arial','B',20);
        $this->SetY($Y3);
        $this->SetX($eje_x_original);
        $this->Image($this->array_parametros['comp_logo'], $eje_x_original+0.05, $Y3+0.05, 2, 0.75, 'jpg');


        $this->SetFont('Arial','U',4.4);
        $this->SetY($Y3+0.22);
        $this->SetX($eje_x_original+2);
        $this->Cell(3.5,0.22,$this->array_parametros['comp_tiulo']);

        $this->SetFont('Arial','B',4.5);
        $this->SetY($Y3+0.90);
        $this->SetX($eje_x_original);
        $this->Cell(3.5,0.22,$this->array_empresa['emp_dir'].
                                    ' - TEL.: '.$this->array_empresa['emp_tel'].
                                    ' - '.$this->array_empresa['emp_loc'].
                                    ' '.$this->array_empresa['emp_pro']);

 
        $this->SetFont('Arial','B',5);
        $this->SetY($Y3+0.2);
        $this->SetX($eje_x_original+5.3);
        $this->Cell(3.5,0.22,'COMPROBANTE No. '.$this->array_comprobante[$c_comp]['noComprobante']);

        $this->SetFont('Arial','B',5);
        $this->SetY($Y3+0.45);
        $this->SetX($eje_x_original+5.3);
        $this->Cell(3.5,0.22,'Fecha: '.$this->array_parametros['comp_fecha']);

        $this->SetFont('Arial','B',8);
        $this->SetY($Y3+0.45);
        $this->SetX($eje_x_original+8.40);
        $this->Cell(3.5,0.22,'ORIGINAL');

        $this->SetFont('Arial','B',4);
        $this->SetY($Y3+0.80);
        $this->SetX($eje_x_original+6.2);
        $this->Cell(3.5,0.22,'C.U.I.T.: '.$this->array_empresa['emp_cuit'].
                             ' - Ing. Brutos: '.$this->array_empresa['emp_ingb']);

        $this->SetFont('Arial','B',4);
        $this->SetY($Y3+0.94);
        $this->SetX($eje_x_original+6.8);
        $this->Cell(3.5,0.22,'Inicio de Actividad: '.$this->array_empresa['emp_inic']);

        // Cabecera Info de abonado
        $this->Line($eje_x_original, $cabecera_alto + $cab_tit_alto + $Y3 - 0.20 , $cabecera_ancho, $cabecera_alto + $cab_tit_alto +$Y3- 0.20);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2 + (+ $Y3 - 0.20) );
        $this->SetX(0.2);
        $this->Cell(3.5,0.22,'Abonado: '.$this->array_comprobante[$c_comp]['abonado']);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2 + (+ $Y3 - 0.20) );
        $this->SetX($ANCHO-2.5);
        $this->Cell(3.5,0.22,'No.: '.$this->array_comprobante[$c_comp]['noComprobante']);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40 + (+ $Y3 - 0.20) );
        $this->SetX(0.2);
        $this->Cell(3.5,0.22,'Domicilio: '.$this->array_comprobante[$c_comp]['domicilio']);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40 + (+ $Y3 - 0.20) );
        $this->SetX($ANCHO-2.5);
        $this->Cell(3.5,0.22,'C.U.I.T.: '.$this->array_comprobante[$c_comp]['cuit']);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40 + (+ $Y3 - 0.20) );
        $this->SetX(0.2);
        $this->Cell(3.5,0.22,'Condicion de Pago: '.$this->array_comprobante[$c_comp]['condPago']);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40 + (+ $Y3 - 0.20) );
        $this->SetX($ANCHO-6.20);
        $this->Cell(3.5,0.22,'Periodo: '.$this->array_comprobante[$c_comp]['periodo']);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40 + (+ $Y3 - 0.20) );
        $this->SetX($ANCHO-2.5);
        $this->Cell(3.5,0.22,'Vencimiento: '.$this->array_comprobante[$c_comp]['vencimiento']);

         // Cuerpo
        $this->Line($eje_x_original, $cuerpo_alto + $Y3 - 0.20, $cuerpo_ancho, $cuerpo_alto+$Y3- 0.20);

        // Titulo del cuerpo
        $this->Line($eje_x_original, $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto + $Y3 - 0.20 , $cabecera_ancho, $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto +$Y3- 0.20);

        $this->SetFont('Arial','B',5.5);
        $this->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30 + ($Y3- 0.20));
        $this->SetX(0.60);
        $this->Cell(3.5,0.22,'Cantidad');

        $this->SetFont('Arial','B',5.5);
        $this->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30 + ($Y3- 0.20));
        $this->SetX(3.87);
        $this->Cell(3.5,0.22,'Descripcion');

        $this->SetFont('Arial','B',5.5);
        $this->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30 + ($Y3- 0.20));
        $this->SetX($ANCHO  - (($ANCHO - $cuerpo_div + 0.50 )/2));
        $this->Cell(3.5,0.22,'Importe');

        for ($c=0; $c <= count($this->array_comprobante[$c_comp]['cantidad']) ; $c++) {

            /* Muestra la columna cantidad */
            $this->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30 + ($Y3- 0.20) + (0.40*($c+1)));
            $this->SetX(0.60);
            $this->Cell(3.5,0.22,$this->array_comprobante[$c_comp]['cantidad'][$c]);

            $this->SetX(3.87);
            $this->Cell(3.5,0.22,$this->array_comprobante[$c_comp]['descripcion'][$c]);

            $this->SetX($ANCHO  - (($ANCHO - $cuerpo_div + 0.50 )/2));
            $this->Cell(3.5,0.22,$this->array_comprobante[$c_comp]['importe'][$c]);

        }

        $this->SetFont('Arial','B',5);
        $this->SetY(($ALTURA - 0.20  + $Y3 - 0.20) - 1);
        $this->SetX(0.60);
        $this->Cell(3.5,0.22,str_pad($this->array_comprobante[$c_comp]['noComprobante'], 12, "0", STR_PAD_LEFT));

        // Genero el codigos de barra
        $this->EAN13(0.60,
                     ($ALTURA - 0.20  + $Y3 - 0.20) - 1.50,
            str_pad($this->array_comprobante[$c_comp]['noComprobante'], 12, "0", STR_PAD_LEFT));


        // Linea que divide el cuerpo
        $this->Line($eje_x_original + $cuerpo_div ,  $cabecera_alto + $cab_tit_alto +$Y3- 0.20, $eje_x_original + $cuerpo_div , $cuerpo_alto + $Y3 - 0.20 + ($ALTURA - $cuerpo_alto + 0.20 ) );

        $this->SetFont('Arial','B',11);
        $this->SetY($ALTURA - 0.20  + $Y3 - 0.20);
        $this->SetX($ANCHO  - ($ANCHO - $cuerpo_div) - 1.28  );
        $this->Cell(1,0.22,'TOTAL');

        $this->SetFont('Arial','B',8);
        $this->SetY($ALTURA - 0.20  + $Y3 - 0.20);
        $this->SetX($ANCHO   - 1  );
        $this->Cell(1,0.22,$this->array_comprobante[$c_comp]['total']);

        #Duplicado
        #Duplicado
        #Duplicado
        $this->Rect($eje_x_duplicado,$Y3,$ANCHO,$ALTURA,'D');

        // Cabecera
        $this->Line($eje_x_duplicado, $cabecera_alto+$Y3- 0.20, $eje_x_duplicado + $ANCHO , $cabecera_alto+$Y3- 0.20);

        // Linea que divide el encabezado
        $this->Line($enca_div + $eje_x_duplicado, $Y3 , $enca_div + $eje_x_duplicado, $cabecera_alto+$Y3- 0.20);
        
        $this->SetFont('Arial','B',20);
        $this->SetY($Y3);
        $this->SetX($eje_x_duplicado);
        $this->Image($this->array_parametros['comp_logo'], $eje_x_duplicado+0.05, $Y3+0.05, 2, 0.75, 'jpg');

        $this->SetFont('Arial','U',4.4);
        $this->SetY($Y3+0.22);
        $this->SetX($eje_x_duplicado+2);
        $this->Cell(3.5,0.22,$this->array_parametros['comp_tiulo']);
        
        $this->SetFont('Arial','B',4.5);
        $this->SetY($Y3+0.90);
        $this->SetX($eje_x_duplicado);
        $this->Cell(3.5,0.22,$this->array_empresa['emp_dir'].
                                    ' - TEL.: '.$this->array_empresa['emp_tel'].
                                    ' - '.$this->array_empresa['emp_loc'].
                                    ' '.$this->array_empresa['emp_pro']);

        $this->SetFont('Arial','B',5);
        $this->SetY($Y3+0.2);
        $this->SetX($eje_x_duplicado+5.3);
        $this->Cell(3.5,0.22,'COMPROBANTE No. '.$this->array_comprobante[$c_comp]['noComprobante']);


        $this->SetFont('Arial','B',5);
        $this->SetY($Y3+0.45);
        $this->SetX($eje_x_duplicado+5.3);
        $this->Cell(3.5,0.22,'Fecha: '.$this->array_parametros['comp_fecha']);

        $this->SetFont('Arial','B',8);
        $this->SetY($Y3+0.45);
        $this->SetX($eje_x_duplicado+8.40);
        $this->Cell(3.5,0.22,'DUPLICADO');

        $this->SetFont('Arial','B',4);
        $this->SetY($Y3+0.80);
        $this->SetX($eje_x_duplicado+6.2);
        $this->Cell(3.5,0.22,'C.U.I.T.: '.$this->array_empresa['emp_cuit'].
                             ' - Ing. Brutos: '.$this->array_empresa['emp_ingb']);

        $this->SetFont('Arial','B',4);
        $this->SetY($Y3+0.94);
        $this->SetX($eje_x_duplicado+6.8);
        $this->Cell(3.5,0.22,'Inicio de Actividad: '.$this->array_empresa['emp_inic']);

        // Cabecera Info de abonado
        $this->Line($eje_x_duplicado, $cabecera_alto + $cab_tit_alto +$Y3- 0.20 , $eje_x_duplicado + $ANCHO, $cabecera_alto + $cab_tit_alto +$Y3- 0.20 );

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2 + (+ $Y3 - 0.20) );
        $this->SetX($eje_x_duplicado+0.2);
        $this->Cell(3.5,0.22,'Abonado: '.$this->array_comprobante[$c_comp]['abonado']);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2 + (+ $Y3 - 0.20) );
        $this->SetX($eje_x_duplicado+$ANCHO-2.5);
        $this->Cell(3.5,0.22,'No.: '.$this->array_comprobante[$c_comp]['noComprobante']);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40 + (+ $Y3 - 0.20) );
        $this->SetX($eje_x_duplicado+0.2);
        $this->Cell(3.5,0.22,'Domicilio: '.$this->array_comprobante[$c_comp]['domicilio']);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40 + (+ $Y3 - 0.20) );
        $this->SetX($eje_x_duplicado+$ANCHO-2.5);
        $this->Cell(3.5,0.22,'C.U.I.T.: '.$this->array_comprobante[$c_comp]['cuit']);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40 + (+ $Y3 - 0.20) );
        $this->SetX($eje_x_duplicado+0.2);
        $this->Cell(3.5,0.22,'Condicion de Pago: '.$this->array_comprobante[$c_comp]['condPago']);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40 + (+ $Y3 - 0.20) );
        $this->SetX($eje_x_duplicado+$ANCHO-6.20);
        $this->Cell(3.5,0.22,'Periodo: '.$this->array_comprobante[$c_comp]['periodo']);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40 + (+ $Y3 - 0.20) );
        $this->SetX($eje_x_duplicado+$ANCHO-2.5);
        $this->Cell(3.5,0.22,'Vencimiento: '.$this->array_comprobante[$c_comp]['vencimiento']);

        // Cuerpo
        $this->Line($eje_x_duplicado, $cuerpo_alto+$Y3- 0.20, $eje_x_duplicado + $ANCHO, $cuerpo_alto+$Y3- 0.20);

        $this->SetFont('Arial','B',5.5);
        $this->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30 + ($Y3- 0.20));
        $this->SetX($eje_x_duplicado+0.60);
        $this->Cell(3.5,0.22,'Cantidad');

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30  + ($Y3- 0.20));
        $this->SetX($eje_x_duplicado+3.87);
        $this->Cell(3.5,0.22,'Descripcion');

        $this->SetFont('Arial','B',5.5);
        $this->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30 + ($Y3- 0.20));
        $this->SetX($eje_x_duplicado - 0.20 + $ANCHO  - (($ANCHO - $cuerpo_div + 0.50 )/2));
        $this->Cell(3.5,0.22,'Importe');

       for ($c=0; $c <= count($this->array_comprobante[$c_comp]['cantidad']) ; $c++) {

            /* Muestra la columna cantidad */
            $this->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30 + ($Y3- 0.20) + (0.40*($c+1)));
            $this->SetX($eje_x_duplicado+0.60);
            $this->Cell(3.5,0.22,$this->array_comprobante[$c_comp]['cantidad'][$c]);

            $this->SetX($eje_x_duplicado+3.87);
            $this->Cell(3.5,0.22,$this->array_comprobante[$c_comp]['descripcion'][$c]);

            $this->SetX($eje_x_duplicado - 0.20 + $ANCHO  - (($ANCHO - $cuerpo_div + 0.50 )/2));
            $this->Cell(3.5,0.22,$this->array_comprobante[$c_comp]['importe'][$c]);

        }

        $this->SetFont('Arial','B',5);
        $this->SetY($ALTURA - 0.20 + ($Y3- 0.20) - 1);
        $this->SetX($eje_x_duplicado+0.60);
        $this->Cell(3.5,0.22,str_pad($this->array_comprobante[$c_comp]['noComprobante'], 12, "0", STR_PAD_LEFT));

        // Genero el codigos de barra
        $this->EAN13($eje_x_duplicado+0.60,
                     $ALTURA - 0.20 + ($Y3- 0.20) - 1.50,
            str_pad($this->array_comprobante[$c_comp]['noComprobante'], 12, "0", STR_PAD_LEFT));

        // Titulo del cuerpo
        $this->Line($eje_x_duplicado, $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto +$Y3- 0.20 , $eje_x_duplicado + $ANCHO , $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto+$Y3- 0.20);

        // Linea que divide el cuerpo
        $this->Line($eje_x_duplicado + $cuerpo_div ,  $cabecera_alto + $cab_tit_alto + $Y3- 0.20, $eje_x_duplicado + $cuerpo_div, $cuerpo_alto +$Y3- 0.20 + ($ALTURA - $cuerpo_alto + 0.20 ) );

        $this->SetFont('Arial','B',11);
        $this->SetY($ALTURA - 0.20 + ($Y3- 0.20));
        $this->SetX($eje_x_duplicado + $ANCHO  - ($ANCHO - $cuerpo_div) - 1.28 -  0.20 );
        $this->Cell(1,0.22,'TOTAL');

        $this->SetFont('Arial','B',8);
        $this->SetY($ALTURA - 0.20  + $Y3 - 0.20);
        $this->SetX($eje_x_duplicado + $ANCHO   - 1  );
        $this->Cell(1,0.22,$this->array_comprobante[$c_comp]['total']);

        /* 3er cupon - Original */
        /* 3er cupon - Original */
        /* 3er cupon - Original */

        // Incremento el contador de comprobantes
        $c_comp = $c_comp + 1;


        // Rectangulo
        $this->Rect($eje_x_original,$Y5,$ANCHO,$ALTURA,'D');

        // Cabecera
        $this->Line($eje_x_original, $cabecera_alto + $Y5- 0.20, $cabecera_ancho, $cabecera_alto+$Y5- 0.20);

        // Linea que divide el encabezado
        $this->Line($enca_div + $eje_x_original, $Y5 , $enca_div + $eje_x_original, $cabecera_alto+$Y5- 0.20);

        $this->SetFont('Arial','B',20);
        $this->SetY($Y5);
        $this->SetX($eje_x_original);
        $this->Image($this->array_parametros['comp_logo'], $eje_x_original+0.05, $Y5+0.05, 2, 0.75, 'jpg');

        $this->SetFont('Arial','U',4.4);
        $this->SetY($Y5+0.22);
        $this->SetX($eje_x_original+2);
        $this->Cell(3.5,0.22,$this->array_parametros['comp_tiulo']);

        $this->SetFont('Arial','B',4.5);
        $this->SetY($Y5+0.90);
        $this->SetX($eje_x_original);
        $this->Cell(3.5,0.22,$this->array_empresa['emp_dir'].
                                    ' - TEL.: '.$this->array_empresa['emp_tel'].
                                    ' - '.$this->array_empresa['emp_loc'].
                                    ' '.$this->array_empresa['emp_pro']);


        $this->SetFont('Arial','B',5);
        $this->SetY($Y5+0.2);
        $this->SetX($eje_x_original+5.3);
        $this->Cell(3.5,0.22,'COMPROBANTE No. '.$this->array_comprobante[$c_comp]['noComprobante']);


        $this->SetFont('Arial','B',5);
        $this->SetY($Y5+0.45);
        $this->SetX($eje_x_original+5.3);
        $this->Cell(3.5,0.22,'Fecha: '.$this->array_parametros['comp_fecha']);

        $this->SetFont('Arial','B',8);
        $this->SetY($Y5+0.45);
        $this->SetX($eje_x_original+8.4);
        $this->Cell(3.5,0.22,'ORIGINAL');

        $this->SetFont('Arial','B',4);
        $this->SetY($Y5+0.80);
        $this->SetX($eje_x_original+6.2);
        $this->Cell(3.5,0.22,'C.U.I.T.: '.$this->array_empresa['emp_cuit'].
                             ' - Ing. Brutos: '.$this->array_empresa['emp_ingb']);


        $this->SetFont('Arial','B',4);
        $this->SetY($Y5+0.94);
        $this->SetX($eje_x_original+6.8);
        $this->Cell(3.5,0.22,'Inicio de Actividad: '.$this->array_empresa['emp_inic']);

        // Cabecera Info de abonado
        $this->Line($eje_x_original, $cabecera_alto + $cab_tit_alto + $Y5 - 0.20 , $cabecera_ancho, $cabecera_alto + $cab_tit_alto +$Y5- 0.20);


        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2 + (+ $Y5 - 0.20) );
        $this->SetX(0.2);
        $this->Cell(3.5,0.22,'Abonado: '.$this->array_comprobante[$c_comp]['abonado']);


        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2 + (+ $Y5 - 0.20) );
        $this->SetX($ANCHO-2.5);
        $this->Cell(3.5,0.22,'No.: '.$this->array_comprobante[$c_comp]['noComprobante']);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40 + (+ $Y5 - 0.20) );
        $this->SetX(0.2);
        $this->Cell(3.5,0.22,'Domicilio: '.$this->array_comprobante[$c_comp]['domicilio']);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40 + (+ $Y5 - 0.20) );
        $this->SetX($ANCHO-2.5);
        $this->Cell(3.5,0.22,'C.U.I.T.: '.$this->array_comprobante[$c_comp]['cuit']);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40 + (+ $Y5 - 0.20) );
        $this->SetX(0.2);
        $this->Cell(3.5,0.22,'Condicion de Pago: '.$this->array_comprobante[$c_comp]['condPago']);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40 + (+ $Y5 - 0.20) );
        $this->SetX($ANCHO-6.20);
        $this->Cell(3.5,0.22,'Periodo: '.$this->array_comprobante[$c_comp]['periodo']);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40 + (+ $Y5 - 0.20) );
        $this->SetX($ANCHO-2.5);
        $this->Cell(3.5,0.22,'Vencimiento: '.$this->array_comprobante[$c_comp]['vencimiento']);


        // Cuerpo
        $this->Line($eje_x_original, $cuerpo_alto + $Y5- 0.20, $cuerpo_ancho, $cuerpo_alto+$Y5- 0.20);

        // Titulo del cuerpo
        $this->Line($eje_x_original, $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto + $Y5 - 0.20 , $cabecera_ancho, $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto +$Y5- 0.20);


        $this->SetFont('Arial','B',5.5);
        $this->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30 + ($Y5- 0.20));
        $this->SetX(0.60);
        $this->Cell(3.5,0.22,'Cantidad');

        $this->SetFont('Arial','B',5.5);
        $this->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30 + ($Y5- 0.20));
        $this->SetX(3.87);
        $this->Cell(3.5,0.22,'Descripcion');

        $this->SetFont('Arial','B',5.5);
        $this->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30 + ($Y5- 0.20));
        $this->SetX($ANCHO  - (($ANCHO - $cuerpo_div + 0.50 )/2));
        $this->Cell(3.5,0.22,'Importe');

        for ($c=0; $c <= count($this->array_comprobante[$c_comp]['cantidad']) ; $c++) {

            /* Muestra la columna cantidad */
            $this->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30 + ($Y5- 0.20) + (0.40*($c+1)));
            $this->SetX(0.60);
            $this->Cell(3.5,0.22,$this->array_comprobante[$c_comp]['cantidad'][$c]);

            $this->SetX(3.87);
            $this->Cell(3.5,0.22,$this->array_comprobante[$c_comp]['descripcion'][$c]);

            $this->SetX($ANCHO  - (($ANCHO - $cuerpo_div + 0.50 )/2));
            $this->Cell(3.5,0.22,$this->array_comprobante[$c_comp]['importe'][$c]);

        }

        $this->SetFont('Arial','B',5);
        $this->SetY(($ALTURA - 0.20  + $Y5 - 0.20) - 1);
        $this->SetX(0.60);
        $this->Cell(3.5,0.22,str_pad($this->array_comprobante[$c_comp]['noComprobante'], 12, "0", STR_PAD_LEFT));

        // Genero el codigos de barra
        $this->EAN13(0.60,
                     ($ALTURA - 0.20  + $Y5 - 0.20) - 1.50,
            str_pad($this->array_comprobante[$c_comp]['noComprobante'], 12, "0", STR_PAD_LEFT));


        // Linea que divide el cuerpo
        $this->Line($eje_x_original + $cuerpo_div ,  $cabecera_alto + $cab_tit_alto +$Y5- 0.20, $eje_x_original + $cuerpo_div , $cuerpo_alto + $Y5 - 0.20 + ($ALTURA - $cuerpo_alto + 0.20 ) );

        $this->SetFont('Arial','B',11);
        $this->SetY($ALTURA - 0.20  + $Y5 - 0.20);
        $this->SetX($ANCHO  - ($ANCHO - $cuerpo_div) - 1.28  );
        $this->Cell(1,0.22,'TOTAL');

        $this->SetFont('Arial','B',8);
        $this->SetY($ALTURA - 0.20  + $Y5 - 0.20);
        $this->SetX($ANCHO   - 1  );
        $this->Cell(1,0.22,$this->array_comprobante[$c_comp]['total']);

        #Duplicado
        #Duplicado
        #Duplicado
        #Duplicado
        //Rectangulo
        $this->Rect($eje_x_duplicado,$Y5,$ANCHO,$ALTURA,'D');

        // Cabecera
        $this->Line($eje_x_duplicado, $cabecera_alto+$Y5- 0.20, $eje_x_duplicado + $ANCHO , $cabecera_alto+$Y5- 0.20);

        // Linea que divide el encabezado
        $this->Line($enca_div + $eje_x_duplicado, $Y5 , $enca_div + $eje_x_duplicado, $cabecera_alto+$Y5- 0.20);

        $this->SetFont('Arial','B',20);
        $this->SetY($Y5);
        $this->SetX($eje_x_duplicado);
        $this->Image($this->array_parametros['comp_logo'], $eje_x_duplicado+0.05, $Y5+0.05, 2, 0.75, 'jpg');

        $this->SetFont('Arial','U',4.4);
        $this->SetY($Y5+0.22);
        $this->SetX($eje_x_duplicado+2);
        $this->Cell(3.5,0.22,$this->array_parametros['comp_tiulo']);


        $this->SetFont('Arial','B',4.5);
        $this->SetY($Y5+0.90);
        $this->SetX($eje_x_duplicado);
        $this->Cell(3.5,0.22,$this->array_empresa['emp_dir'].
                                    ' - TEL.: '.$this->array_empresa['emp_tel'].
                                    ' - '.$this->array_empresa['emp_loc'].
                                    ' '.$this->array_empresa['emp_pro']);

        $this->SetFont('Arial','B',5);
        $this->SetY($Y5+0.2);
        $this->SetX($eje_x_duplicado+5.3);
        $this->Cell(3.5,0.22,'COMPROBANTE No. '.$this->array_comprobante[$c_comp]['noComprobante']);


        $this->SetFont('Arial','B',5);
        $this->SetY($Y5+0.45);
        $this->SetX($eje_x_duplicado+5.3);
        $this->Cell(3.5,0.22,'Fecha: '.$this->array_parametros['comp_fecha']);

        $this->SetFont('Arial','B',8);
        $this->SetY($Y5+0.45);
        $this->SetX($eje_x_duplicado+8.4);
        $this->Cell(3.5,0.22,'DUPLICADO');

        $this->SetFont('Arial','B',4);
        $this->SetY($Y5+0.80);
        $this->SetX($eje_x_duplicado+6.2);
        $this->Cell(3.5,0.22,'C.U.I.T.: '.$this->array_empresa['emp_cuit'].
                             ' - Ing. Brutos: '.$this->array_empresa['emp_ingb']);

        $this->SetFont('Arial','B',4);
        $this->SetY($Y5+0.94);
        $this->SetX($eje_x_duplicado+6.8);
        $this->Cell(3.5,0.22,'Inicio de Actividad: '.$this->array_empresa['emp_inic']);

        // Cabecera Info de abonado
        $this->Line($eje_x_duplicado, $cabecera_alto + $cab_tit_alto +$Y5- 0.20 , $eje_x_duplicado + $ANCHO, $cabecera_alto + $cab_tit_alto +$Y5- 0.20 );

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2 + (+ $Y5 - 0.20) );
        $this->SetX($eje_x_duplicado+0.2);
        $this->Cell(3.5,0.22,'Abonado: '.$this->array_comprobante[$c_comp]['abonado']);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2 + (+ $Y5 - 0.20) );
        $this->SetX($eje_x_duplicado+$ANCHO-2.5);
        $this->Cell(3.5,0.22,'No.: '.$this->array_comprobante[$c_comp]['noComprobante']);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40 + (+ $Y5 - 0.20) );
        $this->SetX($eje_x_duplicado+0.2);
        $this->Cell(3.5,0.22,'Domicilio: '.$this->array_comprobante[$c_comp]['domicilio']);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40 + (+ $Y5 - 0.20) );
        $this->SetX($eje_x_duplicado+$ANCHO-2.5);
        $this->Cell(3.5,0.22,'C.U.I.T.: '.$this->array_comprobante[$c_comp]['cuit']);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40 + (+ $Y5 - 0.20) );
        $this->SetX($eje_x_duplicado+0.2);
        $this->Cell(3.5,0.22,'Condicion de Pago: '.$this->array_comprobante[$c_comp]['condPago']);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40 + (+ $Y5 - 0.20) );
        $this->SetX($eje_x_duplicado+$ANCHO-6.20);
        $this->Cell(3.5,0.22,'Periodo: '.$this->array_comprobante[$c_comp]['periodo']);

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alt+0.2+0.40+0.40 + (+ $Y5 - 0.20) );
        $this->SetX($eje_x_duplicado+$ANCHO-2.5);
        $this->Cell(3.5,0.22,'Vencimiento: '.$this->array_comprobante[$c_comp]['vencimiento']);

        // Cuerpo
        $this->Line($eje_x_duplicado, $cuerpo_alto+$Y5- 0.20, $eje_x_duplicado + $ANCHO, $cuerpo_alto+$Y5- 0.20);

        $this->SetFont('Arial','B',5.5);
        $this->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30 + ($Y5- 0.20));
        $this->SetX($eje_x_duplicado+0.60);
        $this->Cell(3.5,0.22,'Cantidad');

        $this->SetFont('Arial','B',5.5);
        $this->SetY($cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30  + ($Y5- 0.20));
        $this->SetX($eje_x_duplicado+3.87);
        $this->Cell(3.5,0.22,'Descripcion');

        $this->SetFont('Arial','B',5.5);
        $this->SetY( $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30 + ($Y5- 0.20));
        $this->SetX($eje_x_duplicado - 0.20 + $ANCHO  - (($ANCHO - $cuerpo_div + 0.50 )/2));
        $this->Cell(3.5,0.22,'Importe');

       for ($c=0; $c <= count($this->array_comprobante[$c_comp]['cantidad']) ; $c++) {

            /* Muestra la columna cantidad */
            $this->SetY($cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto - 0.30 + ($Y5- 0.20) + (0.40*($c+1)));
            $this->SetX($eje_x_duplicado+0.60);
            $this->Cell(3.5,0.22,$this->array_comprobante[$c_comp]['cantidad'][$c]);

            $this->SetX($eje_x_duplicado+3.87);
            $this->Cell(3.5,0.22,$this->array_comprobante[$c_comp]['descripcion'][$c]);

            $this->SetX($eje_x_duplicado - 0.20 + $ANCHO  - (($ANCHO - $cuerpo_div + 0.50 )/2));
            $this->Cell(3.5,0.22,$this->array_comprobante[$c_comp]['importe'][$c]);

        }

        $this->SetFont('Arial','B',5);
        $this->SetY($ALTURA - 0.20 + ($Y5- 0.20) - 1);
        $this->SetX($eje_x_duplicado+0.60);
        $this->Cell(3.5,0.22,str_pad($this->array_comprobante[$c_comp]['noComprobante'], 12, "0", STR_PAD_LEFT));

        // Genero el codigos de barra
        $this->EAN13($eje_x_duplicado+0.60,
                     $ALTURA - 0.20 + ($Y5- 0.20) - 1.50,
            str_pad($this->array_comprobante[$c_comp]['noComprobante'], 12, "0", STR_PAD_LEFT));

        // Titulo del cuerpo
        $this->Line($eje_x_duplicado, $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto +$Y5- 0.20 , $eje_x_duplicado + $ANCHO , $cabecera_alto + $cab_tit_alto + $cuerpo_tit_alto+$Y5- 0.20);

        // Linea que divide el cuerpo
        $this->Line($eje_x_duplicado + $cuerpo_div ,  $cabecera_alto + $cab_tit_alto + $Y5- 0.20, $eje_x_duplicado + $cuerpo_div, $cuerpo_alto +$Y5- 0.20 + ($ALTURA - $cuerpo_alto + 0.20 ) );

        $this->SetFont('Arial','B',11);
        $this->SetY($ALTURA - 0.20 + ($Y5- 0.20));
        $this->SetX($eje_x_duplicado + $ANCHO  - ($ANCHO - $cuerpo_div) - 1.28 -  0.20 );
        $this->Cell(1,0.22,'TOTAL');

        $this->SetFont('Arial','B',8);
        $this->SetY($ALTURA - 0.20  + $Y5 - 0.20);
        $this->SetX($eje_x_duplicado + $ANCHO   - 1  );
        $this->Cell(1,0.22,$this->array_comprobante[$c_comp]['total']);
        
        if ( count($this->array_comprobante) <= $c_comp )
           $this->AddPage();
        
        }
    }
}

/*
 * Definicion de los arrays con la info de los cupones
 *
 *
 */

$array_info_empresa = array (
                           'emp_dir'  =>'URQUIZA 1470',
                           'emp_tel'  =>'(0343) 422-5544',
                           'emp_loc'  =>'(3100) PARANA',
                           'emp_pro'  =>'E.R',
                           'emp_cuit' =>'30-70766126-3',
                           'emp_ingb' =>'30-70766126-3',
                           'emp_inic' =>'01/07/2001',
);

$array_param = array (
                           'fpdf_orientation'  =>'P',
                           'fpdf_unit'         =>'cm',
                           'fpdf_format'       =>'A4',
                           'comp_tiulo'        => 'SERVICIO DE EMERGENCIAS MEDICAS',
                           'comp_logo'         => 'logo.jpg',
                           'comp_fecha'        => '2012/09/24'
);

$array_cantidad     = array ('1','1','2');
$array_descripcion  = array ('SEM EMERGENCIAS','ODONTOLOGIA','ENFERMERIA');
$array_importe      = array ('100','150','45');


$array_comprobante = array (
                            'abonado'       =>'Ottino, Maximiliano Miguel',
                            'noComprobante' =>'0001',
                            'domicilio'     =>'Diamante 232',
                            'condPago'      =>'xxx',
                            'cuit'          =>'20.31307630.0',
                            'periodo'       =>'201209',
                            'vencimiento'   =>'2012/09/20',
                            'cantidad'      => $array_cantidad ,
                            'descripcion'   => $array_descripcion,
                            'importe'       => $array_importe,
                            'total'         => '250',
                            'leyenda_cuerpo'=> 'Leyenda 1',
                            'leyenda_pie'   => 'Leyenda 2'
);

$array_comprobante_1 = array (
                            'abonado'       =>'Ottino, Mateo',
                            'noComprobante' =>'0002',
                            'domicilio'     =>'Urquiza 3020',
                            'condPago'      =>'xxx',
                            'cuit'          =>'20.31307630.0',
                            'periodo'       =>'201208',
                            'vencimiento'   =>'2012/09/21',
                            'cantidad'      => $array_cantidad ,
                            'descripcion'   => $array_descripcion,
                            'importe'       => $array_importe,
                            'total'         => '295',
                            'leyenda_cuerpo'=> 'Leyenda 1',
                            'leyenda_pie'   => 'Leyenda 2'
);


$array_comprobate_indice = array (
                             $array_comprobante,
                             $array_comprobante_1,
);

$comprobante = new comprobante($array_param , $array_info_empresa , $array_comprobate_indice);
$comprobante->generar_comprobantes();
$comprobante->Output();
//$comprobante->Output('sem_comprobante_010.pdf','D');
//echo "<PRE>" . print_r($array_comprobate_indice['3']) . "</PRE>";
//echo count($array_descripcion);

//echo "<PRE>" . print_r($array_param) . "</PRE> <br>";
//echo "<PRE>" . print_r($array_info_empresa) . "</PRE> <br>";
//echo "<PRE>" . print_r($array_comprobate_indice) . "</PRE> <br>";

//while (!count($array_descripcion))

?>
