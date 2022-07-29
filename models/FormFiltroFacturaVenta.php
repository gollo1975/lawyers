<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class FormFiltroFacturaVenta extends Model
{
    public $idcliente;
    public $fecha_inicio;
    public $fecha_vencimiento;
    public $nro_factura;
    public $pendiente;
    public $tipo_factura;
    
    public function rules()
    {
        return [

            [['idcliente','tipo_factura'], 'match', 'pattern' => '/^[0-9\s]+$/i', 'message' => 'Sólo se aceptan números'],
            ['fecha_inicio', 'safe'],
            ['fecha_vencimiento', 'safe'],
            ['nro_factura', 'match', 'pattern' => '/^[0-9\s]+$/i', 'message' => 'Sólo se aceptan números'],
            ['pendiente', 'match', 'pattern' => '/^[0-9\s]+$/i', 'message' => 'Sólo se aceptan números'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'idcliente' => 'Cliente:',
            'nro_factura' => 'N° Factura:',
            'fecha_inicio' => 'Desde:',
            'fecha_vencimiento' => 'Hasta:',
            'pendiente' => 'Saldo Pendiente:',
            'tipo_factura' => 'Tipo factura:',
        ];
    }
}
