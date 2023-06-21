<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class FormReciboCajaTipoDetalleEditar extends Model
{        
    public $cuenta;
    public $tipocuenta;    
    
    public function rules()
    {
        return [            
            [['cuenta','tipocuenta'], 'required'],            
        ];
    }

    public function attributeLabels()
    {
        return [                        
            'cuenta' => 'Cuenta:',                      
            'tipocuenta' => 'Tipo:',             
        ];
    }
    
}
