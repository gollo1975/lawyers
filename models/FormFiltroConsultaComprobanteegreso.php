<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class FormFiltroConsultaComprobanteegreso extends Model
{
    public $idproveedor;
    public $desde;
    public $hasta;
    public $numero;
    public $tipo;
    
    public function rules()
    {
        return [

            ['idproveedor', 'match', 'pattern' => '/^[0-9\s]+$/i', 'message' => 'Sólo se aceptan números'],
            ['desde', 'safe'],
            ['hasta', 'safe'],
            ['numero', 'match', 'pattern' => '/^[0-9\s]+$/i', 'message' => 'Sólo se aceptan números'],
            ['tipo', 'match', 'pattern' => '/^[0-9\s]+$/i', 'message' => 'Sólo se aceptan números'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'idproveedor' => 'Proveedor:',
            'numero' => 'N° Comprobante:',
            'desde' => 'Desde:',
            'hasta' => 'Hasta:',
            'tipo' => 'Tipo:',
        ];
    }
}
