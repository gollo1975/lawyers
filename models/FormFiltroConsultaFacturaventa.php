<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class FormFiltroConsultaFacturaventa extends Model
{
    public $idcliente;
    public $desde;
    public $hasta;
    public $numero;
    public $pendiente;
    public $tipo_factura;
    
    public function rules()
    {
        return [

            ['idcliente','tipo_factura', 'match', 'pattern' => '/^[0-9\s]+$/i', 'message' => 'Sólo se aceptan números'],
            ['desde', 'safe'],
            ['hasta', 'safe'],
            ['numero', 'match', 'pattern' => '/^[0-9\s]+$/i', 'message' => 'Sólo se aceptan números'],
            ['pendiente', 'match', 'pattern' => '/^[0-9\s]+$/i', 'message' => 'Sólo se aceptan números'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'idcliente' => 'Cliente:',
            'numero' => 'N° Factura:',
            'desde' => 'Desde:',
            'hasta' => 'Hasta:',
            'pendiente' => 'Saldo Pendiente:',
            'tipo_factura' => 'Tipo factura:'
        ];
    }
}
