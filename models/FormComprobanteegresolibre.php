<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class FormComprobanteegresolibre extends Model
{        
    public $fecha_comprobante;
    public $id_proveedor;
    public $id_comprobante_egreso_tipo;
    public $id_municipio;
    public $id_banco;
    public $observacion;    
    
    public function rules()
    {
        return [            
            [['id_comprobante_egreso_tipo', 'id_municipio','fecha_comprobante','id_proveedor','id_banco'], 'required'],            
            [['observacion'], 'string'],            
            [['id_comprobante_egreso_tipo','id_municipio'], 'string', 'max' => 15],            
        ];
    }

    public function attributeLabels()
    {
        return [                        
            'fecha_comprobante' => 'Fecha Comprobante',
            'id_comprobante_egreso_tipo' => 'Tipo Comprobante',
            'id_municipio' => 'Municipio',            
            'id_proveedor' => 'Proveedor',                        
            'id_banco' => 'Banco',
            'observacion' => 'Observacion',            
        ];
    }
    
}
