<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class FormFacturaVentaTipoDetalleEditar extends Model
{        
    public $cuenta;
    public $tipocuenta;
    public $base;
    public $subtotal;
    public $iva;
    public $rete_fuente;
    public $rete_iva;
    public $total;
    public $base_rete_fuente;    
    public $porcentaje_base;
    
    public function rules()
    {
        return [            
            [['cuenta','tipocuenta','base','subtotal','iva','rete_fuente','rete_iva','total','base_rete_fuente','porcentaje_base'], 'required'],            
            [['porcentaje_base'], 'number'],
        ];
    }

    public function attributeLabels()
    {
        return [                        
            'cuenta' => 'Cuenta:',                      
            'tipocuenta' => 'Tipo:',
            'base' => 'Base:',
            'subtotal' => 'Subtotal:',
            'iva' => 'Iva:',
            'rete_fuente' => 'Rete Fuente:',
            'rete_iva' => 'Rete Iva:',
            'total' => 'Total Factura:',
            'base_rete_fuente' => 'Base Rete Fuente:',
            'porcentaje_base' => '% Base',
        ];
    }
    
}
