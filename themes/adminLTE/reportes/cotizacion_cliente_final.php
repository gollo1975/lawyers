<?php
use inquid\pdf\FPDF;
use app\models\Cotizaciones;
use app\models\CotizacionDetalle;
use app\models\Matriculaempresa;
use app\models\Municipio;
use app\models\Departamento;

class PDF extends FPDF
{
    function Header()
    {
        $id_cotizacion = $GLOBALS['id_cotizacion'];
        $cotizacion = Cotizaciones::findOne($id_cotizacion);
        $config = MatriculaEmpresa::findOne(1);
        $municipio = Municipio::findOne($config->idmunicipio);
        $departamento = Departamento::findOne($config->iddepartamento);
        //Logo
        $this->SetXY(43, 10);
        $this->Image('dist/images/logos/logoempresa.png', 10, 9, 30, 25);
        //Encabezado
        $this->SetFillColor(220, 220, 220);
        $this->SetXY(53, 9);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(30, 5, utf8_decode("Empresa:"), 0, 0, 'l', 0);
        $this->SetFont('Arial', '', 8);
        $this->Cell(65, 5, utf8_decode($config->razonsocialmatricula), 0, 0, 'L', 0);
        $this->SetXY(30, 5);
        //FIN
        $this->SetXY(53, 13);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(30, 5, utf8_decode("Nit:"), 0, 0, 'l', 0);
         $this->SetFont('Arial', '', 8);
        $this->Cell(65, 5, utf8_decode($config->nitmatricula." - ".$config->dv), 0, 0, 'L', 0);
        $this->SetXY(40, 5);
        //FIN
        $this->SetXY(53, 17);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(30, 5, utf8_decode("Dirección:"), 0, 0, 'l', 0);
         $this->SetFont('Arial', '', 8);
        $this->Cell(65, 5, utf8_decode($config->direccionmatricula), 0, 0, 'L', 0);
        $this->SetXY(40, 5);
        //FIN
        $this->SetXY(53, 21);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(30, 5, utf8_decode("Teléfono:"), 0, 0, 'l',0);
         $this->SetFont('Arial', '', 8);
        $this->Cell(65, 5, utf8_decode($config->telefonomatricula), 0, 0, 'L', 0);
        $this->SetXY(40, 5);
        //FIN
        $this->SetXY(53, 25);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(30, 5, utf8_decode("Municipio:"), 0, 0, 'l', 0);
         $this->SetFont('Arial', '', 8);
        $this->Cell(65, 5, utf8_decode($config->municipio->municipio." - ".$config->departamento->departamento), 0, 0, 'L', 0);
        $this->SetXY(40, 5);
        //FIN DATOS DE LA EPRESA
        $this->SetFont('Arial', 'B', 8);
        $this->SetXY(10, 33);
        $this->SetDrawColor(0, 0, 255);
        $this->Cell(193, 7, ("Datos del cliente"), 1, 0, 'C', 1);
        
        $this->SetFillColor(220, 220, 220);
        $this->SetXY(145, 15);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(30, 7, utf8_decode("COTIZACION"), 0, 0, 'l', 0);
        if($cotizacion->numero_cotizacion > 0){
            $this->Cell(30, 7, utf8_decode('N°. '.str_pad($cotizacion->numero_cotizacion, 5, "0", STR_PAD_LEFT)), 0, 0, 'l', 0);
        }else{
            $this->Cell(30, 7, utf8_decode('N°. '.str_pad($cotizacion->id_cotizacion, 5, "0", STR_PAD_LEFT)), 0, 0, 'l', 0);
        }    
        //FIN LINEA
        $this->SetFillColor(200, 200, 200);
        //FIN
        $this->SetXY(10, 40);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(26, 5, utf8_decode("Nit:"), 0, 0, 'L', 0);
        $this->SetFont('Arial', '', 8);
        $this->Cell(75, 5, utf8_decode($cotizacion->cliente->cedulanit.'-'.$cotizacion->cliente->dv), 0, 0, 'L',0);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(20, 5, utf8_decode("Cliente:"), 0, 0, 'c', 0);
        $this->SetFont('Arial', '', 8);
        $this->Cell(71, 5, utf8_decode($cotizacion->cliente->nombrecorto), 0, 0, 'c', 0);
        //FIN
         $this->SetXY(10, 44);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(26, 5, utf8_decode("Departamento:"), 0, 0, 'l', 0);
        $this->SetFont('Arial', '', 8);
        $this->Cell(75, 5, utf8_decode($cotizacion->cliente->departamento->departamento), 0, 0, 'L',0);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(20, 5, utf8_decode("Municipio:"), 0, 0, 'l', 0);
        $this->SetFont('Arial', '', 8);
        $this->Cell(71, 5, utf8_decode($cotizacion->cliente->municipio->municipio), 0, 0, 'L', 0);
        //FIN
        $this->SetXY(10, 48);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(26, 5, utf8_decode("Fecha cotización:"), 0, 0, 'l', 0);
        $this->SetFont('Arial', '', 8);
        $this->Cell(75, 5, utf8_decode($cotizacion->fecha_cotizacion), 0, 0, 'L',0);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(20, 5, utf8_decode("Fecha entrega:"), 0, 0, 'l', 0);
        $this->SetFont('Arial', '', 8);
        $this->Cell(71, 5, utf8_decode($cotizacion->fecha_entrega), 0, 0, 'L', 0);
         // FIN
        $this->SetXY(10, 52);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(26, 5, utf8_decode("Fecha registro:"), 0, 0, 'L', 0);
        $this->SetFont('Arial', '', 8);
        $this->Cell(75, 5, utf8_decode($cotizacion->fecha_registro), 0, 0, 'l', 0);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(20, 5, utf8_decode("Email:"), 0, 0, 'J', 0);
        $this->SetFont('Arial', '', 8);
        $this->Cell(71, 5, utf8_decode($cotizacion->cliente->emailcliente), 0, 0, 'L', 0);
        //FIN
        $this->SetXY(10, 53);
        $this->SetDrawColor(0, 0, 255);
        $this->Cell(193, 7, ("__________________________________________________________________________________________________________________________"), 0, 0, 'C', 0);

        //Lineas del encabezado
        $this->Line(10,62,10,213);
        $this->Line(20,62,20,205);
        $this->Line(45,62,45,205);
        $this->Line(53,62,53,205);
        $this->Line(64,62,64,205);
        $this->Line(76,62,76,205);
        $this->Line(144,62,144,205);
        $this->Line(202,62,202,213);
              
        //Cuadro de la nota
         $this->SetDrawColor(0, 0, 255);
        $this->Line(10,205,202,205);//linea horizontal superior
        $this->Line(10,182,10,182);//linea vertical
        $this->Line(10,213,202,213);//linea horizontal inferior
        //Linea de las observacines
        $this->Line(10,190,10,200);//linea vertical
        //lineas para los cuadros de nit/cc,fecha,firma        
     
            
        //Detalle factura
        $this->EncabezadoDetalles();              

     }//termina el head
    function EncabezadoDetalles() {
        $this->Ln(7);
        $header = array('CODIGO','REFERENCIA','CANT.','VLR UNIT.', 'TOTAL', 'NOTA COMERCIAL', 'DESCRIPCION VENTA');
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(.2);
        $this->SetFont('', 'B', 6);

        //creamos la cabecera de la tabla.
        
        $w = array(10, 25, 8, 11, 12, 68, 58);
        for ($i = 0; $i < count($header); $i++)
        
            if ($i == 0 || $i == 1)
                $this->Cell($w[$i], 4, $header[$i], 1, 0, 'C', 1);
            else
                $this->Cell($w[$i], 4, $header[$i], 1, 0, 'C', 1);

        //Restauración de colores y fuentes
        $this->SetFillColor(224, 235, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
        $this->Ln(5);
    }
    function Body($pdf,$model)
    {
        $config = \app\models\Matriculaempresa::findOne(1);
        $detalles = CotizacionDetalle::find()->where(['=','id_cotizacion',$model->id_cotizacion])->all();
        $contacto = \app\models\ClientesContactos::find()->where(['=','id_cliente', $model->id_cliente])->andWhere(['=','predeterminado', 1])->one();
        $pdf->SetX(10);
        $pdf->SetFont('Arial', '', 5);
        $cant = 0; $contador = 0;
        foreach ($detalles as $detalle) { 
            $contador +=1;
            $pdf->SetFont('Arial', '', 5);
            $pdf->Cell(10, 3, ('R-'.$detalle->codigo), 0, 0, 'L');
            $pdf->Cell(25,3, utf8_decode(substr($detalle->referencia, 0, 22)), 'L');
            $pdf->Cell(8, 3, number_format($detalle->cantidad_referencia,0), 0, 0, 'C');
            $pdf->Cell(11, 3, '$'.number_format($detalle->valor_unidad, 0), 0, 0, 'R');
            $pdf->Cell(12, 3, '$'.number_format($detalle->total_linea, 0), 0, 0, 'R'); 
            //primer
            $startX = $pdf->GetX();
            $pdf->MultiCell(68, 3, utf8_decode(substr($detalle->nota, 0, 310)), 0, 'J');
            //segundo
            $estimatedHeight = 3 * ceil(strlen($detalle->nota) / 68);
            $pdf->SetXY($startX + 68, $pdf->GetY() - $estimatedHeight);
            $pdf->MultiCell(58, 3, utf8_decode(substr($detalle->nota_comercial, 0, 310)), 0, 'J');
            $this->Ln();
             $pdf->SetAutoPageBreak(true, 20);
            if ($contador % 11 == 0) {
                $pdf->AddPage();
                $this->Line(10,240,10,200);
            }
            
        }
        if (!$contador % 11 == 0) {
             $this->Line(10,240,10,200);
        }
        $this->SetFillColor(224, 235, 255);
        $pdf->SetXY(10, 205);
        $this->SetFont('Arial', 'B', 9);
        $pdf->MultiCell(146, 4, utf8_decode(valorEnLetras($model->total_cotizacion)),0,'J');
        $pdf->SetXY(157, 205);
         $this->SetFont('Arial', 'B', 9);
         $this->SetDrawColor(0, 0, 255);
        $pdf->MultiCell(20, 8, 'SUBTOTAL:',1,'C');
        $pdf->SetXY(177, 205);
        $this->SetFont('Arial', '', 9);
        $pdf->MultiCell(25, 8, '$ '.number_format($model->subtotal, 0, '.', ','),1,'R');
        $pdf->SetXY(10, 213);
        $this->SetFont('Arial', '', 9);
        $pdf->MultiCell(146, 4, utf8_decode($model->observacion),0,'J');
        $this->SetFont('Arial', 'B', 9);
        $pdf->SetXY(157, 213);
        $pdf->MultiCell(20, 8, 'RETE FTE:',1,'C');
        $this->SetFont('Arial', '', 9);
        $pdf->SetXY(177, 213);
        $pdf->MultiCell(25, 8, number_format(0, 0, '.', ','),1,'R');
        $this->SetFont('Arial', 'B', 9);
        $pdf->SetXY(157, 221);
        $pdf->MultiCell(20, 8, 'IVA:',1,'C');
        $pdf->SetXY(177, 221);
        $this->SetFont('Arial', '', 9);
        $pdf->MultiCell(25, 8, '$'.number_format($model->impuesto, 0, '.', ','),1,'R');
        $pdf->SetXY(157, 229);
        $this->SetFont('Arial', 'B', 9);
        $pdf->MultiCell(20, 8, 'RETE IVA:',1,'C');
        $pdf->SetXY(177, 229);
        $this->SetFont('Arial', '', 9);
        $pdf->MultiCell(25, 8, number_format(0, 0, '.', ','),1,'R');
        $pdf->SetXY(10, 237);
        $pdf->MultiCell(109, 8, '',1,'R',1);
        $pdf->SetXY(119, 237);
        $pdf->MultiCell(38, 8, 'TOTAL CANTIDAD: '.$cant,1,'C',1);
        $pdf->SetXY(157, 237); 
        $this->SetFont('Arial', 'B', 9);
        $pdf->MultiCell(20, 8, 'TOTAL:',1,'C',1);
        $pdf->SetXY(177, 237);
        $this->SetFont('Arial', '', 9); 
        $pdf->MultiCell(25, 8, '$ '.number_format($model->total_cotizacion, 0, '.', ','),1,'R',1);
        //conacto
       if($contacto){
            $pdf->SetXY(10, 249);
            $this->SetFont('Arial', '', 8); 
            $pdf->MultiCell(192, 8, utf8_decode('Contacto: '. $contacto->nombres. ' '. $contacto->apellidos. '  Cargo: ' .$contacto->cargo->cargo),0, 1, 'L',1);
       }     

        $pdf->SetXY(10, 267);//firma trabajador
        $this->SetFillColor(224, 235, 255);
        $this->SetFont('', 'B', 9);
        $pdf->Cell(35, 5, 'FIRMA CLIENTE: ____________________________________________________', 0, 0, 'L',0);
        $pdf->SetXY(10, 272);
        $pdf->Cell(35, 5, 'NIT/CC.:', 0, 0, 'L',0);
   
    } //termina la funcion bodi
}//termina la clase

global $id_cotizacion;
$id_cotizacion = $model->id_cotizacion;
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Body($pdf,$model);
$pdf->AliasNbPages();
$pdf->SetFont('Times', '', 10);
$pdf->Output("Cotizacion_Cliente_$model->numero_cotizacion.pdf", 'D');

exit;
function zero_fill ($valor, $long = 0)
{
    return str_pad($valor, $long, '0', STR_PAD_LEFT);
}

function valorEnLetras($x) {
    if ($x < 0) {
        $signo = "menos ";
    } else {
        $signo = "";
    }
    $x = abs($x);
    $C1 = $x;

    $G6 = floor($x / (1000000));  // 7 y mas 

    $E7 = floor($x / (100000));
    $G7 = $E7 - $G6 * 10;   // 6 

    $E8 = floor($x / 1000);
    $G8 = $E8 - $E7 * 100;   // 5 y 4 

    $E9 = floor($x / 100);
    $G9 = $E9 - $E8 * 10;  //  3 

    $E10 = floor($x);
    $G10 = $E10 - $E9 * 100;  // 2 y 1 


    $G11 = round(($x - $E10) * 100);  // Decimales 
////////////////////// 

    $H6 = unidades($G6);

    if ($G7 == 1 AND $G8 == 0) {
        $H7 = "Cien ";
    } else {
        $H7 = decenas($G7);
    }

    $H8 = unidades($G8);

    if ($G9 == 1 AND $G10 == 0) {
        $H9 = "Cien ";
    } else {
        $H9 = decenas($G9);
    }

    $H10 = unidades($G10);

    if ($G11 < 10) {
        $H11 = "" . $G11;
    } else {
        $H11 = $G11;
    }

///////////////////////////// 
    if ($G6 == 0) {
        $I6 = " ";
    } elseif ($G6 == 1) {
        $I6 = "Millón ";
    } else {
        $I6 = "Millones ";
    }

    if ($G8 == 0 AND $G7 == 0) {
        $I8 = " ";
    } else {
        $I8 = "Mil ";
    }

    $I10 = "Pesos ";
    $I11 = "M.L ";

    $C3 = $signo . $H6 . $I6 . $H7 . $H8 . $I8 . $H9 . $H10 . $I10 . $H11 . $I11;

    return $C3; //Retornar el resultado 
}

function unidades($u) {
    if ($u == 0) {
        $ru = " ";
    } elseif ($u == 1) {
        $ru = "Un ";
    } elseif ($u == 2) {
        $ru = "Dos ";
    } elseif ($u == 3) {
        $ru = "Tres ";
    } elseif ($u == 4) {
        $ru = "Cuatro ";
    } elseif ($u == 5) {
        $ru = "Cinco ";
    } elseif ($u == 6) {
        $ru = "Seis ";
    } elseif ($u == 7) {
        $ru = "Siete ";
    } elseif ($u == 8) {
        $ru = "Ocho ";
    } elseif ($u == 9) {
        $ru = "Nueve ";
    } elseif ($u == 10) {
        $ru = "Diez ";
    } elseif ($u == 11) {
        $ru = "Once ";
    } elseif ($u == 12) {
        $ru = "Doce ";
    } elseif ($u == 13) {
        $ru = "Trece ";
    } elseif ($u == 14) {
        $ru = "Catorce ";
    } elseif ($u == 15) {
        $ru = "Quince ";
    } elseif ($u == 16) {
        $ru = "Dieciseis ";
    } elseif ($u == 17) {
        $ru = "Decisiete ";
    } elseif ($u == 18) {
        $ru = "Dieciocho ";
    } elseif ($u == 19) {
        $ru = "Diecinueve ";
    } elseif ($u == 20) {
        $ru = "Veinte ";
    } elseif ($u == 21) {
        $ru = "Veinti un ";
    } elseif ($u == 22) {
        $ru = "Veinti dos ";
    } elseif ($u == 23) {
        $ru = "Veinti tres ";
    } elseif ($u == 24) {
        $ru = "Veinti cuatro ";
    } elseif ($u == 25) {
        $ru = "Veinti cinco ";
    } elseif ($u == 26) {
        $ru = "Veinti seis ";
    } elseif ($u == 27) {
        $ru = "Veinti siente ";
    } elseif ($u == 28) {
        $ru = "Veintio cho ";
    } elseif ($u == 29) {
        $ru = "Veinti nueve ";
    } elseif ($u == 30) {
        $ru = "Treinta ";
    } elseif ($u == 31) {
        $ru = "Treinta y un ";
    } elseif ($u == 32) {
        $ru = "Treinta y dos ";
    } elseif ($u == 33) {
        $ru = "Treinta y tres ";
    } elseif ($u == 34) {
        $ru = "Treinta y cuatro ";
    } elseif ($u == 35) {
        $ru = "Treinta y cinco ";
    } elseif ($u == 36) {
        $ru = "Treinta y seis ";
    } elseif ($u == 37) {
        $ru = "Treinta y siete ";
    } elseif ($u == 38) {
        $ru = "Treinta y ocho ";
    } elseif ($u == 39) {
        $ru = "Treinta y nueve ";
    } elseif ($u == 40) {
        $ru = "Cuarenta ";
    } elseif ($u == 41) {
        $ru = "Cuarenta y un ";
    } elseif ($u == 42) {
        $ru = "Cuarenta y dos ";
    } elseif ($u == 43) {
        $ru = "Cuarenta y tres ";
    } elseif ($u == 44) {
        $ru = "Cuarenta y cuatro ";
    } elseif ($u == 45) {
        $ru = "Cuarenta y cinco ";
    } elseif ($u == 46) {
        $ru = "Cuarenta y seis ";
    } elseif ($u == 47) {
        $ru = "Cuarenta y siete ";
    } elseif ($u == 48) {
        $ru = "Cuarenta y ocho ";
    } elseif ($u == 49) {
        $ru = "Cuarenta y nueve ";
    } elseif ($u == 50) {
        $ru = "Cincuenta ";
    } elseif ($u == 51) {
        $ru = "Cincuenta y un ";
    } elseif ($u == 52) {
        $ru = "Cincuenta y dos ";
    } elseif ($u == 53) {
        $ru = "Cincuenta y tres ";
    } elseif ($u == 54) {
        $ru = "Cincuenta y cuatro ";
    } elseif ($u == 55) {
        $ru = "Cincuenta y cinco ";
    } elseif ($u == 56) {
        $ru = "Cincuenta y seis ";
    } elseif ($u == 57) {
        $ru = "Cincuenta y siete ";
    } elseif ($u == 58) {
        $ru = "Cincuenta y ocho ";
    } elseif ($u == 59) {
        $ru = "Cincuenta y nueve ";
    } elseif ($u == 60) {
        $ru = "Sesenta ";
    } elseif ($u == 61) {
        $ru = "Sesenta y un ";
    } elseif ($u == 62) {
        $ru = "Sesenta y dos ";
    } elseif ($u == 63) {
        $ru = "Sesenta y tres ";
    } elseif ($u == 64) {
        $ru = "Sesenta y cuatro ";
    } elseif ($u == 65) {
        $ru = "Sesenta y cinco ";
    } elseif ($u == 66) {
        $ru = "Sesenta y seis ";
    } elseif ($u == 67) {
        $ru = "Sesenta y siete ";
    } elseif ($u == 68) {
        $ru = "Sesenta y ocho ";
    } elseif ($u == 69) {
        $ru = "Sesenta y nueve ";
    } elseif ($u == 70) {
        $ru = "Setenta ";
    } elseif ($u == 71) {
        $ru = "Setenta y un ";
    } elseif ($u == 72) {
        $ru = "Setenta y dos ";
    } elseif ($u == 73) {
        $ru = "Setenta y tres ";
    } elseif ($u == 74) {
        $ru = "Setenta y cuatro ";
    } elseif ($u == 75) {
        $ru = "Setentaycinco ";
    } elseif ($u == 76) {
        $ru = "Setenta y seis ";
    } elseif ($u == 77) {
        $ru = "Setenta y siete ";
    } elseif ($u == 78) {
        $ru = "Setenta y ocho ";
    } elseif ($u == 79) {
        $ru = "Setenta y nueve ";
    } elseif ($u == 80) {
        $ru = "Ochenta ";
    } elseif ($u == 81) {
        $ru = "Ochenta y un ";
    } elseif ($u == 82) {
        $ru = "Ochenta y dos ";
    } elseif ($u == 83) {
        $ru = "Ochenta y tres ";
    } elseif ($u == 84) {
        $ru = "Ochenta y cuatro ";
    } elseif ($u == 85) {
        $ru = "Ochenta y cinco ";
    } elseif ($u == 86) {
        $ru = "Ochenta y seis ";
    } elseif ($u == 87) {
        $ru = "Ochenta y siete ";
    } elseif ($u == 88) {
        $ru = "Ochenta y ocho ";
    } elseif ($u == 89) {
        $ru = "Ochenta y nueve ";
    } elseif ($u == 90) {
        $ru = "Noventa ";
    } elseif ($u == 91) {
        $ru = "Noventa y un ";
    } elseif ($u == 92) {
        $ru = "Noventa y dos ";
    } elseif ($u == 93) {
        $ru = "Noventa y tres ";
    } elseif ($u == 94) {
        $ru = "Noventa y cuatro ";
    } elseif ($u == 95) {
        $ru = "Noventa y cinco ";
    } elseif ($u == 96) {
        $ru = "Noventa y seis ";
    } elseif ($u == 97) {
        $ru = "Noventaysiete ";
    } elseif ($u == 98) {
        $ru = "Noventa y ocho ";
    } else {
        $ru = "Noventa y nueve ";
    }
    return $ru; //Retornar el resultado 
}

function decenas($d) {
    if ($d == 0) {
        $rd = "";
    } elseif ($d == 1) {
        $rd = "Ciento ";
    } elseif ($d == 2) {
        $rd = "Doscientos ";
    } elseif ($d == 3) {
        $rd = "Trescientos ";
    } elseif ($d == 4) {
        $rd = "Cuatrocientos ";
    } elseif ($d == 5) {
        $rd = "Quinientos ";
    } elseif ($d == 6) {
        $rd = "Seiscientos ";
    } elseif ($d == 7) {
        $rd = "Setecientos ";
    } elseif ($d == 8) {
        $rd = "Ochocientos ";
    } else {
        $rd = "Novecientos ";
    }
    return $rd; //Retornar el resultado 
}
