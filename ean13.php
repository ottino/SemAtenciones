<?php

// libreria para crear pdf
require('fpdf.php');

class ean13 extends fpdf
{

        public $x;
        public $y;
        public $barcode;
        public $h;
        public $w;
        public $len;


    public function EAN13($x, $y, $barcode, $h=5, $w=0.15)
    {
        //$this->Barcode($x,$y,$barcode,$h/10,$w/10,2);
        $this->x= $x;
        $this->y= $y;
        $this->barcode= $barcode;
        $this->h= $h/10;
        $this->w= $w/10;
        $this->len = 2;
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

    public function Barcode()
    {
                
        //Padding
        $this->barcode=str_pad($this->barcode,$this->len-1,'0',STR_PAD_LEFT);
        if($this->len==12)
            $this->barcode='0'.$this->barcode;
        //Add or control the check digit
        if(strlen($this->barcode)==12)
           $this->barcode.=$this->GetCheckDigit($this->barcode);
        elseif(!$this->TestCheckDigit($this->barcode))
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
        $p=$parities[$this->barcode[0]];
        for($i=1;$i<=6;$i++)
            $code.=$codes[$p[$i-1]][$this->barcode[$i]];
        $code.='01010';
        for($i=7;$i<=12;$i++)
            $code.=$codes['C'][$this->barcode[$i]];
        $code.='101';
        //Draw bars
        for($i=0;$i<strlen($code);$i++)
        {
            if($code[$i]=='1')
                $this->Rect($this->x+$i*$this->w,$this->y,$this->w,$this->h,'F');
        }
        //Print text uder barcode
        //$this->SetFont('Arial','',5.5);
        //$this->Text($x,$y+$h+11/$this->k,substr($barcode,-$len));
    }

}

?>
