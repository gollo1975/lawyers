<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class FormFacturaventalibre extends Model
{        
    public $fechainicio;
    public $idcliente;    
    public $observacion;
    public $id_factura_venta_tipo;
    public $nrofacturaelectronica;
    
    public function rules()
    {
        return [            
            [['fechainicio','idcliente','id_factura_venta_tipo'], 'required'],            
            [['observacion'], 'string'],
            ['nrofacturaelectronica' , 'string']
        ];
    }

    public function attributeLabels()
    {
        return [                        
            'fechainicio' => 'Fecha Inicio',                      
            'idcliente' => 'Cliente',
            'id_factura_venta_tipo' => 'Tipo',
            'observacion' => 'Observacion',
            'nrofacturaelectronica' => 'Nro Factura Electrónica',
        ];
    }
    
}
